<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class PagesController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('pages:view');
        $pages = Database::fetchAll('SELECT * FROM pages ORDER BY id ASC');
        return $this->render('admin.pages.index', [
            'title' => 'Website Pages & SEO — Dynamice CMS',
            'pages' => $pages,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('pages:create');
        $data = $request->getBody();

        $slug = trim($data['slug'] ?? '');
        $title = trim($data['title'] ?? '');
        if (empty($slug) || empty($title)) {
            return $this->redirect('/admin/pages', null, 'Slug and Title are required.');
        }

        Database::query(
            'INSERT INTO pages (slug, title, subtitle, banner_image_url, meta_title, meta_description, meta_keywords, is_published, created_at, updated_at)
             VALUES (:slug, :title, :subtitle, :banner_image_url, :meta_title, :meta_description, :meta_keywords, :is_published, NOW(), NOW())',
            [
                'slug' => $slug,
                'title' => $title,
                'subtitle' => $data['subtitle'] ?? null,
                'banner_image_url' => $data['banner_image_url'] ?? null,
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'is_published' => isset($data['is_published']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Page', (string)$newId, ['slug' => $slug, 'title' => $title]);
        return $this->redirect('/admin/pages', 'Page created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('pages:edit');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE pages SET title = :title, subtitle = :subtitle, banner_image_url = :banner_image_url,
                    meta_title = :meta_title, meta_description = :meta_description, meta_keywords = :meta_keywords,
                    is_published = :is_published, updated_at = NOW() WHERE id = :id',
            [
                'title' => trim($data['title'] ?? ''),
                'subtitle' => $data['subtitle'] ?? null,
                'banner_image_url' => $data['banner_image_url'] ?? null,
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'is_published' => isset($data['is_published']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Page', (string)$id, ['title' => $data['title'] ?? '']);
        return $this->redirect('/admin/pages', 'Page updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('pages:delete');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM pages WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Page', (string)$id);
        return $this->redirect('/admin/pages', 'Page deleted successfully.');
    }
}
