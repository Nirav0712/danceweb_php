<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class GalleryController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('gallery:view');

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'gallery' LIMIT 1");
        if (!$page) {
            Database::query(
                "INSERT INTO pages (slug, title, subtitle, is_published, created_at, updated_at)
                 VALUES ('gallery', 'Performance Photo Gallery', 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.', 1, NOW(), NOW())"
            );
            $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'gallery' LIMIT 1");
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'gallery_header' LIMIT 1");
        if (!$section) {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'gallery_header', 'Performance Photo Gallery', 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.', 'VISUAL ARCHIVE', 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                ]
            );
            $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'gallery_header' LIMIT 1");
        }

        $items = Database::fetchAll(
            'SELECT g.*, c.name as category_name FROM gallery_items g
             LEFT JOIN dance_categories c ON g.category_id = c.id
             ORDER BY g.sort_order ASC, g.id DESC'
        );
        $categories = Database::fetchAll('SELECT id, name FROM dance_categories ORDER BY sort_order ASC, name ASC');

        return $this->render('admin.gallery.index', [
            'title' => 'Photo Gallery Management — Dynamice CMS',
            'items' => $items,
            'categories' => $categories,
            'page' => $page,
            'section' => $section,
        ]);
    }

    public function updateSettings(Request $request): Response
    {
        $this->checkPermission('gallery:manage');
        $data = $request->getBody();

        $pageTitle = trim($data['page_title'] ?? 'Performance Photo Gallery');
        $pageSubtitle = trim($data['page_subtitle'] ?? 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.');
        $badgeLabel = trim($data['badge_label'] ?? 'VISUAL ARCHIVE');
        $metaTitle = trim($data['meta_title'] ?? $pageTitle);
        $metaDescription = trim($data['meta_description'] ?? $pageSubtitle);

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'gallery' LIMIT 1");
        if ($page) {
            Database::query(
                "UPDATE pages SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW() WHERE slug = 'gallery'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                ]
            );
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'gallery_header' LIMIT 1");
        if ($section) {
            Database::query(
                "UPDATE sections SET heading = :title, subheading = :subtitle, content = :badge, updated_at = NOW() WHERE section_key = 'gallery_header'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'gallery_header', :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                    'heading' => $pageTitle,
                    'subheading' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        }

        $this->logAudit('UPDATE', 'GallerySettings', 'gallery_header');
        return $this->redirect('/admin/gallery', 'Gallery page header & banner settings saved successfully.');
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('gallery:manage');
        $data = $request->getBody();

        $imageUrl = trim($data['image_url'] ?? '');
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'gallery');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

        if (empty($imageUrl)) {
            $imageUrl = '/assets/gallery/5.jpg';
        }

        Database::query(
            'INSERT INTO gallery_items (category_id, title, caption, image_url, thumbnail_url, event_year, is_featured, sort_order, created_at, updated_at)
             VALUES (:category_id, :title, :caption, :image_url, :thumbnail_url, :event_year, :is_featured, :sort_order, NOW(), NOW())',
            [
                'category_id' => !empty($data['category_id']) ? (int)$data['category_id'] : null,
                'title' => !empty($data['title']) ? trim($data['title']) : 'Academy Performance Photo',
                'caption' => $data['caption'] ?? null,
                'image_url' => $imageUrl,
                'thumbnail_url' => $data['thumbnail_url'] ?? $imageUrl,
                'event_year' => !empty($data['event_year']) ? (int)$data['event_year'] : (int)date('Y'),
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'GalleryItem', (string)$newId, ['url' => $imageUrl]);
        return $this->redirect('/admin/gallery', 'Gallery photo added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('gallery:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        $imageUrl = trim($data['image_url'] ?? '');
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'gallery');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

        Database::query(
            'UPDATE gallery_items SET category_id = :category_id, title = :title, caption = :caption,
                    image_url = :image_url, thumbnail_url = :thumbnail_url, event_year = :event_year,
                    is_featured = :is_featured, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id',
            [
                'category_id' => !empty($data['category_id']) ? (int)$data['category_id'] : null,
                'title' => !empty($data['title']) ? trim($data['title']) : 'Academy Performance Photo',
                'caption' => $data['caption'] ?? null,
                'image_url' => $imageUrl ?: '/assets/gallery/5.jpg',
                'thumbnail_url' => $imageUrl ?: '/assets/gallery/5.jpg',
                'event_year' => !empty($data['event_year']) ? (int)$data['event_year'] : (int)date('Y'),
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'GalleryItem', (string)$id);
        return $this->redirect('/admin/gallery', 'Gallery photo updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('gallery:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM gallery_items WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'GalleryItem', (string)$id);
        return $this->redirect('/admin/gallery', 'Gallery photo deleted successfully.');
    }
}
