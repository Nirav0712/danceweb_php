<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

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
        $items = Database::fetchAll(
            'SELECT * FROM news_items WHERE news_scope = :scope ORDER BY publish_date DESC, sort_order ASC',
            ['scope' => $this->scope]
        );

        $isNational = $this->scope === 'NATIONAL';
        return $this->render('admin.news.index', [
            'title' => ($isNational ? 'National' : 'International') . ' Media Press — Dynamice CMS',
            'items' => $items,
            'scope' => $this->scope,
            'isNational' => $isNational,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('news:manage');
        $data = $request->getBody();

        $headline = trim($data['headline'] ?? '');
        $pubName = trim($data['publication_name'] ?? '');
        $imageUrl = trim($data['image_url'] ?? '');

        if (empty($headline) || empty($pubName) || empty($imageUrl)) {
            $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';
            return $this->redirect($redirectUrl, null, 'Headline, Publication Name, and Image URL are required.');
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
                'image_url' => $imageUrl,
                'external_link' => $data['external_link'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'NewsItem', (string)$newId, ['scope' => $this->scope, 'headline' => $headline]);
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';
        return $this->redirect($redirectUrl, 'News item added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('news:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

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
                'image_url' => trim($data['image_url'] ?? ''),
                'external_link' => $data['external_link'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
                'scope' => $this->scope,
            ]
        );

        $this->logAudit('UPDATE', 'NewsItem', (string)$id);
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';
        return $this->redirect($redirectUrl, 'News item updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('news:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM news_items WHERE id = :id AND news_scope = :scope', ['id' => $id, 'scope' => $this->scope]);
        $this->logAudit('DELETE', 'NewsItem', (string)$id);
        $redirectUrl = $this->scope === 'NATIONAL' ? '/admin/news/national' : '/admin/news/international';
        return $this->redirect($redirectUrl, 'News item deleted successfully.');
    }
}
