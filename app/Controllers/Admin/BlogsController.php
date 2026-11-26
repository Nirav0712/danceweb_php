<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class BlogsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('blogs:manage');

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'blog' LIMIT 1");
        if (!$page) {
            Database::query(
                "INSERT INTO pages (slug, title, subtitle, is_published, created_at, updated_at)
                 VALUES ('blog', 'Dance Stories & Insights', 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.', 1, NOW(), NOW())"
            );
            $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'blog' LIMIT 1");
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'blog_header' LIMIT 1");
        if (!$section) {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'blog_header', :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'],
                    'heading' => 'Dance Stories & Insights',
                    'subheading' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
                    'badge' => 'PERSPECTIVES & WISDOM',
                ]
            );
            $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'blog_header' LIMIT 1");
        }

        $posts = Database::fetchAll('SELECT * FROM blog_posts ORDER BY published_at DESC');

        return $this->render('admin.blogs.index', [
            'title' => 'Dance Stories & Articles — Dynamice CMS',
            'posts' => $posts,
            'page' => $page,
            'section' => $section,
        ]);
    }

    public function updateSettings(Request $request): Response
    {
        $this->checkPermission('blogs:manage');
        $data = $request->getBody();

        $pageTitle = trim($data['page_title'] ?? 'Dance Stories & Insights');
        $pageSubtitle = trim($data['page_subtitle'] ?? 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.');
        $badgeLabel = trim($data['badge_label'] ?? 'PERSPECTIVES & WISDOM');
        $metaTitle = trim($data['meta_title'] ?? $pageTitle);
        $metaDescription = trim($data['meta_description'] ?? $pageSubtitle);

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'blog' LIMIT 1");
        if ($page) {
            Database::query(
                "UPDATE pages SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW() WHERE slug = 'blog'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                ]
            );
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'blog_header' LIMIT 1");
        if ($section) {
            Database::query(
                "UPDATE sections SET heading = :title, subheading = :subtitle, content = :badge, updated_at = NOW() WHERE section_key = 'blog_header'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'blog_header', :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                    'heading' => $pageTitle,
                    'subheading' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        }

        $this->logAudit('UPDATE', 'BlogSettings', 'blog_header');
        return $this->redirect('/admin/blogs', 'Blog header and banner settings saved successfully.');
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('blogs:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $content = trim($data['content'] ?? '');
        $slug = trim($data['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
        $category = trim($data['category'] ?? 'Culture');
        $author = trim($data['author_name'] ?? ($this->user['full_name'] ?? 'Director Tirthraj Trivedi'));
        $imageUrl = trim($data['featured_image_url'] ?? '');

        // Handle direct file upload if present
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'blogs');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

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
                'featured_image_url' => $imageUrl ?: '/assets/gallery/5.jpg',
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

        $imageUrl = trim($data['featured_image_url'] ?? '');
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'blogs');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

        Database::query(
            'UPDATE blog_posts SET slug = :slug, title = :title, category = :category, author_name = :author_name,
                    excerpt = :excerpt, content = :content, featured_image_url = :featured_image_url,
                    status = :status, published_at = :published_at, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW()
             WHERE id = :id',
            [
                'slug' => trim($data['slug'] ?? ''),
                'title' => trim($data['title'] ?? ''),
                'category' => trim($data['category'] ?? 'Culture'),
                'author_name' => trim($data['author_name'] ?? 'Director Tirthraj Trivedi'),
                'excerpt' => $data['excerpt'] ?? null,
                'content' => $data['content'] ?? '',
                'featured_image_url' => $imageUrl ?: '/assets/gallery/5.jpg',
                'status' => in_array($data['status'] ?? '', ['DRAFT', 'PUBLISHED', 'ARCHIVED']) ? $data['status'] : 'PUBLISHED',
                'published_at' => !empty($data['published_at']) ? $data['published_at'] : date('Y-m-d H:i:s'),
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
