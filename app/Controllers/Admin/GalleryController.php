<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class GalleryController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('gallery:view');
        $items = Database::fetchAll(
            'SELECT g.*, c.name as category_name FROM gallery_items g
             LEFT JOIN dance_categories c ON g.category_id = c.id
             ORDER BY g.sort_order ASC, g.id DESC'
        );
        $categories = Database::fetchAll('SELECT id, name FROM dance_categories ORDER BY name ASC');

        return $this->render('admin.gallery.index', [
            'title' => 'Photo Gallery Management — Dynamice CMS',
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('gallery:manage');
        $data = $request->getBody();

        $imageUrl = trim($data['image_url'] ?? '');
        if (empty($imageUrl)) {
            return $this->redirect('/admin/gallery', null, 'Image URL is required.');
        }

        Database::query(
            'INSERT INTO gallery_items (category_id, title, caption, image_url, thumbnail_url, event_year, is_featured, sort_order, created_at, updated_at)
             VALUES (:category_id, :title, :caption, :image_url, :thumbnail_url, :event_year, :is_featured, :sort_order, NOW(), NOW())',
            [
                'category_id' => !empty($data['category_id']) ? (int)$data['category_id'] : null,
                'title' => $data['title'] ?? null,
                'caption' => $data['caption'] ?? null,
                'image_url' => $imageUrl,
                'thumbnail_url' => $data['thumbnail_url'] ?? $imageUrl,
                'event_year' => !empty($data['event_year']) ? (int)$data['event_year'] : null,
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'GalleryItem', (string)$newId, ['url' => $imageUrl]);
        return $this->redirect('/admin/gallery', 'Gallery item added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('gallery:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE gallery_items SET category_id = :category_id, title = :title, caption = :caption,
                    image_url = :image_url, thumbnail_url = :thumbnail_url, event_year = :event_year,
                    is_featured = :is_featured, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id',
            [
                'category_id' => !empty($data['category_id']) ? (int)$data['category_id'] : null,
                'title' => $data['title'] ?? null,
                'caption' => $data['caption'] ?? null,
                'image_url' => trim($data['image_url'] ?? ''),
                'thumbnail_url' => trim($data['thumbnail_url'] ?? $data['image_url'] ?? ''),
                'event_year' => !empty($data['event_year']) ? (int)$data['event_year'] : null,
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'GalleryItem', (string)$id);
        return $this->redirect('/admin/gallery', 'Gallery item updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('gallery:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM gallery_items WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'GalleryItem', (string)$id);
        return $this->redirect('/admin/gallery', 'Gallery item deleted successfully.');
    }
}
