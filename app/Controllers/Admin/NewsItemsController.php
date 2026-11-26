<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class NewsItemsController extends BaseAdminController
{
    protected string $scope = 'NATIONAL';

    public function __construct(string $scope = 'NATIONAL')
    {
        parent::__construct();
        $this->scope = strtoupper($scope);
    }

    public function index(Request $request): Response
    {
        $this->checkPermission('news:manage');
        $isNational = $this->scope === 'NATIONAL';
        $pageSlug = $isNational ? 'news-national' : 'news-international';
        $sectionKey = $isNational ? 'news_national_header' : 'news_international_header';
        $defaultTitle = $isNational ? 'National News & Media' : 'International News & Media';
        $defaultSubtitle = $isNational 
            ? 'Press clippings and national print media coverage celebrating our performances and world record events.' 
            : 'Global press coverage, international festival reports, and UNESCO partner accreditations.';
        $defaultBadge = $isNational ? 'IN THE HEADLINES' : 'GLOBAL HEADLINES';

        // Ensure page record exists
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = :slug LIMIT 1", ['slug' => $pageSlug]);
        if (!$page) {
            Database::query(
                "INSERT INTO pages (slug, title, subtitle, is_published, created_at, updated_at)
                 VALUES (:slug, :title, :subtitle, 1, NOW(), NOW())",
                [
                    'slug' => $pageSlug,
                    'title' => $defaultTitle,
                    'subtitle' => $defaultSubtitle,
                ]
            );
            $page = Database::fetchOne("SELECT * FROM pages WHERE slug = :slug LIMIT 1", ['slug' => $pageSlug]);
        }

        // Ensure section record exists
        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = :key LIMIT 1", ['key' => $sectionKey]);
        if (!$section) {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, :key, :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                    'key' => $sectionKey,
                    'heading' => $defaultTitle,
                    'subheading' => $defaultSubtitle,
                    'badge' => $defaultBadge,
                ]
            );
            $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = :key LIMIT 1", ['key' => $sectionKey]);
        }

        $items = Database::fetchAll(
            'SELECT * FROM news_items WHERE news_scope = :scope ORDER BY publish_date DESC, sort_order ASC',
            ['scope' => $this->scope]
        );

        return $this->render('admin.news.index', [
            'title' => ($isNational ? 'National' : 'International') . ' Media Press — Dynamice CMS',
            'items' => $items,
            'scope' => $this->scope,
            'isNational' => $isNational,
            'page' => $page,
            'section' => $section,
        ]);
    }

    public function updateSettings(Request $request): Response
    {
        $this->checkPermission('news:manage');
        $data = $request->getBody();

        $isNational = $this->scope === 'NATIONAL';
        $pageSlug = $isNational ? 'news-national' : 'news-international';
        $sectionKey = $isNational ? 'news_national_header' : 'news_international_header';
        $redirectUrl = $isNational ? '/admin/news/national' : '/admin/news/international';

        $pageTitle = trim($data['page_title'] ?? ($isNational ? 'National News & Media' : 'International News & Media'));
        $pageSubtitle = trim($data['page_subtitle'] ?? '');
        $badgeLabel = trim($data['badge_label'] ?? ($isNational ? 'IN THE HEADLINES' : 'GLOBAL HEADLINES'));
        $metaTitle = trim($data['meta_title'] ?? $pageTitle);
        $metaDescription = trim($data['meta_description'] ?? $pageSubtitle);

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = :slug LIMIT 1", ['slug' => $pageSlug]);
        if ($page) {
            Database::query(
                "UPDATE pages SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW() WHERE slug = :slug",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                    'slug' => $pageSlug,
                ]
            );
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = :key LIMIT 1", ['key' => $sectionKey]);
        if ($section) {
            Database::query(
                "UPDATE sections SET heading = :title, subheading = :subtitle, content = :badge, updated_at = NOW() WHERE section_key = :key",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'badge' => $badgeLabel,
                    'key' => $sectionKey,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, :key, :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                    'key' => $sectionKey,
                    'heading' => $pageTitle,
                    'subheading' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        }

        $this->logAudit('UPDATE', 'NewsSettings', $sectionKey);
        return $this->redirect($redirectUrl, 'Page banner and CMS header settings saved successfully.');
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('news:manage');
        $data = $request->getBody();
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';

        $headline = trim($data['headline'] ?? '');
        $pubName = trim($data['publication_name'] ?? '');
        $imageUrl = trim($data['image_url'] ?? '');

        // Handle direct file upload if present
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'news');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

        if (empty($headline) || empty($pubName)) {
            return $this->redirect($redirectUrl, null, 'Headline and Publication Name are required.');
        }

        Database::query(
            'INSERT INTO news_items (news_scope, headline, publication_name, publish_date, summary, image_url, external_link, sort_order, created_at, updated_at)
             VALUES (:news_scope, :headline, :publication_name, :publish_date, :summary, :image_url, :external_link, :sort_order, NOW(), NOW())',
            [
                'news_scope' => $this->scope,
                'headline' => $headline,
                'publication_name' => $pubName,
                'publish_date' => !empty($data['publish_date']) ? $data['publish_date'] : date('Y-m-d'),
                'summary' => $data['summary'] ?? null,
                'image_url' => $imageUrl ?: '/assets/gallery/5.jpg',
                'external_link' => $data['external_link'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'NewsItem', (string)$newId, ['scope' => $this->scope, 'headline' => $headline]);
        return $this->redirect($redirectUrl, 'News clipping published successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('news:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';

        $imageUrl = trim($data['image_url'] ?? '');
        if (!empty($_FILES['image_file']['name'])) {
            $upload = UploadService::handleUpload($_FILES['image_file'], 'news');
            if ($upload['success']) {
                $imageUrl = $upload['url'];
            }
        }

        Database::query(
            'UPDATE news_items SET headline = :headline, publication_name = :publication_name,
                    publish_date = :publish_date, summary = :summary, image_url = :image_url,
                    external_link = :external_link, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id AND news_scope = :scope',
            [
                'headline' => trim($data['headline'] ?? ''),
                'publication_name' => trim($data['publication_name'] ?? ''),
                'publish_date' => !empty($data['publish_date']) ? $data['publish_date'] : date('Y-m-d'),
                'summary' => $data['summary'] ?? null,
                'image_url' => $imageUrl ?: '/assets/gallery/5.jpg',
                'external_link' => $data['external_link'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
                'scope' => $this->scope,
            ]
        );

        $this->logAudit('UPDATE', 'NewsItem', (string)$id);
        return $this->redirect($redirectUrl, 'News clipping updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('news:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM news_items WHERE id = :id AND news_scope = :scope', ['id' => $id, 'scope' => $this->scope]);
        $this->logAudit('DELETE', 'NewsItem', (string)$id);
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';
        return $this->redirect($redirectUrl, 'News clipping deleted successfully.');
    }
}
