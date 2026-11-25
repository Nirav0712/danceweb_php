<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class BlogsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('blogs:manage');
        $posts = Database::fetchAll('SELECT * FROM blog_posts ORDER BY published_at DESC');
        return $this->render('admin.blogs.index', [
            'title' => 'Dance Stories & Articles — Dynamice CMS',
            'posts' => $posts,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('blogs:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $content = trim($data['content'] ?? '');
        $slug = trim($data['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
        $category = trim($data['category'] ?? 'Dance & Culture');
        $author = trim($data['author_name'] ?? ($this->user['full_name'] ?? 'Editor'));

        if (empty($title) || empty($content)) {
            return $this->redirect('/admin/blogs', null, 'Title and Content are required.');
        }

        Database::query(
            'INSERT INTO blog_posts (slug, title, category, author_name, excerpt, content, featured_image_url, status, published_at, meta_title, meta_description, created_at, updated_at)
             VALUES (:slug, :title, :category, :author_name, :excerpt, :content, :featured_image_url, :status, :published_at, :meta_title, :meta_description, NOW(), NOW())',
            [
                'slug' => $slug,
                'title' => $title,
                'category' => $category,
                'author_name' => $author,
                'excerpt' => $data['excerpt'] ?? null,
                'content' => $content,
                'featured_image_url' => $data['featured_image_url'] ?? null,
                'status' => in_array($data['status'] ?? '', ['DRAFT', 'PUBLISHED', 'ARCHIVED']) ? $data['status'] : 'PUBLISHED',
                'published_at' => !empty($data['published_at']) ? $data['published_at'] : date('Y-m-d H:i:s'),
                'meta_title' => $data['meta_title'] ?? $title,
                'meta_description' => $data['meta_description'] ?? null,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'BlogPost', (string)$newId, ['slug' => $slug, 'title' => $title]);
        return $this->redirect('/admin/blogs', 'Blog story published successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('blogs:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE blog_posts SET slug = :slug, title = :title, category = :category, author_name = :author_name,
                    excerpt = :excerpt, content = :content, featured_image_url = :featured_image_url,
                    status = :status, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW()
             WHERE id = :id',
            [
                'slug' => trim($data['slug'] ?? ''),
                'title' => trim($data['title'] ?? ''),
                'category' => trim($data['category'] ?? 'Dance & Culture'),
                'author_name' => trim($data['author_name'] ?? 'Editor'),
                'excerpt' => $data['excerpt'] ?? null,
                'content' => $data['content'] ?? '',
                'featured_image_url' => $data['featured_image_url'] ?? null,
                'status' => in_array($data['status'] ?? '', ['DRAFT', 'PUBLISHED', 'ARCHIVED']) ? $data['status'] : 'PUBLISHED',
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'BlogPost', (string)$id);
        return $this->redirect('/admin/blogs', 'Blog story updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('blogs:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM blog_posts WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'BlogPost', (string)$id);
        return $this->redirect('/admin/blogs', 'Blog story deleted successfully.');
    }
}
