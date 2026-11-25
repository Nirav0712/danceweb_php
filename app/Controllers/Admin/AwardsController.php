<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class AwardsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('awards:manage');
        $awards = Database::fetchAll('SELECT * FROM awards ORDER BY year DESC, sort_order ASC');
        return $this->render('admin.awards.index', [
            'title' => 'Awards & Records Management — Dynamice CMS',
            'awards' => $awards,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('awards:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $issuer = trim($data['issuer'] ?? '');
        $year = (int)($data['year'] ?? date('Y'));

        if (empty($title) || empty($issuer)) {
            return $this->redirect('/admin/awards', null, 'Title and Issuer are required.');
        }

        Database::query(
            'INSERT INTO awards (title, issuer, category, year, description, certificate_image_url, is_record_book, is_featured, sort_order, created_at, updated_at)
             VALUES (:title, :issuer, :category, :year, :description, :certificate_image_url, :is_record_book, :is_featured, :sort_order, NOW(), NOW())',
            [
                'title' => $title,
                'issuer' => $issuer,
                'category' => $data['category'] ?? null,
                'year' => $year,
                'description' => $data['description'] ?? null,
                'certificate_image_url' => $data['certificate_image_url'] ?? null,
                'is_record_book' => isset($data['is_record_book']) ? 1 : 0,
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Award', (string)$newId, ['title' => $title]);
        return $this->redirect('/admin/awards', 'Award created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('awards:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE awards SET title = :title, issuer = :issuer, category = :category, year = :year,
                    description = :description, certificate_image_url = :certificate_image_url,
                    is_record_book = :is_record_book, is_featured = :is_featured, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id',
            [
                'title' => trim($data['title'] ?? ''),
                'issuer' => trim($data['issuer'] ?? ''),
                'category' => $data['category'] ?? null,
                'year' => (int)($data['year'] ?? date('Y')),
                'description' => $data['description'] ?? null,
                'certificate_image_url' => $data['certificate_image_url'] ?? null,
                'is_record_book' => isset($data['is_record_book']) ? 1 : 0,
                'is_featured' => isset($data['is_featured']) ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Award', (string)$id);
        return $this->redirect('/admin/awards', 'Award updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('awards:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM awards WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Award', (string)$id);
        return $this->redirect('/admin/awards', 'Award deleted successfully.');
    }
}
