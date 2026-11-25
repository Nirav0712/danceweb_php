<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class MediaController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('media:view');
        $media = Database::fetchAll('SELECT * FROM media_assets ORDER BY id DESC');
        return $this->render('admin.media.index', [
            'title' => 'Media Assets Library — Dynamice CMS',
            'media' => $media,
        ]);
    }

    public function upload(Request $request): Response
    {
        $this->checkPermission('media:upload');
        if (!isset($_FILES['file'])) {
            return $this->redirect('/admin/media', null, 'No file selected for upload.');
        }

        $folder = trim($_POST['folder'] ?? 'general');
        $altText = trim($_POST['alt_text'] ?? '');
        $res = UploadService::handleUpload($_FILES['file'], $folder);

        if (!$res['success']) {
            return $this->redirect('/admin/media', null, $res['error']);
        }

        $publicId = 'local_' . bin2hex(random_bytes(8));
        Database::query(
            'INSERT INTO media_assets (public_id, url, secure_url, original_filename, folder, format, width, height, bytes, alt_text, created_at, updated_at)
             VALUES (:public_id, :url, :secure_url, :original_filename, :folder, :format, :width, :height, :bytes, :alt_text, NOW(), NOW())',
            [
                'public_id' => $publicId,
                'url' => $res['url'],
                'secure_url' => $res['url'],
                'original_filename' => $res['original_filename'],
                'folder' => $folder,
                'format' => $res['format'],
                'width' => $res['width'],
                'height' => $res['height'],
                'bytes' => $res['bytes'],
                'alt_text' => $altText ?: $res['original_filename'],
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('UPLOAD', 'MediaAsset', (string)$newId, ['filename' => $res['original_filename'], 'url' => $res['url']]);
        return $this->redirect('/admin/media', 'File uploaded successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('media:delete');
        $id = (int)($params['id'] ?? 0);
        $asset = Database::fetchOne('SELECT * FROM media_assets WHERE id = :id', ['id' => $id]);

        if ($asset) {
            // Optional local file cleanup
            $filePath = dirname(__DIR__, 3) . '/public' . $asset['url'];
            if (file_exists($filePath) && str_starts_with($asset['url'], '/uploads/')) {
                @unlink($filePath);
            }
            Database::query('DELETE FROM media_assets WHERE id = :id', ['id' => $id]);
            $this->logAudit('DELETE', 'MediaAsset', (string)$id, ['url' => $asset['url']]);
        }

        return $this->redirect('/admin/media', 'Media asset removed.');
    }
}
