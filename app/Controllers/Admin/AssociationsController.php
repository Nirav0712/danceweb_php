<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class AssociationsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('associations:manage');
        $associations = Database::fetchAll('SELECT * FROM associations ORDER BY sort_order ASC, name ASC');
        return $this->render('admin.associations.index', [
            'title' => 'Affiliations & Partners — Dynamice CMS',
            'associations' => $associations,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('associations:manage');
        $data = $request->getBody();

        $name = trim($data['name'] ?? '');
        $logoUrl = trim($data['logo_url'] ?? '');
        if (empty($name) || empty($logoUrl)) {
            return $this->redirect('/admin/associations', null, 'Partner Name and Logo URL are required.');
        }

        Database::query(
            'INSERT INTO associations (name, acronym, description, logo_url, website_url, sort_order, is_active, created_at, updated_at)
             VALUES (:name, :acronym, :description, :logo_url, :website_url, :sort_order, :is_active, NOW(), NOW())',
            [
                'name' => $name,
                'acronym' => $data['acronym'] ?? null,
                'description' => $data['description'] ?? null,
                'logo_url' => $logoUrl,
                'website_url' => $data['website_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Association', (string)$newId, ['name' => $name]);
        return $this->redirect('/admin/associations', 'Affiliation created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('associations:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE associations SET name = :name, acronym = :acronym, description = :description,
                    logo_url = :logo_url, website_url = :website_url, sort_order = :sort_order,
                    is_active = :is_active, updated_at = NOW() WHERE id = :id',
            [
                'name' => trim($data['name'] ?? ''),
                'acronym' => $data['acronym'] ?? null,
                'description' => $data['description'] ?? null,
                'logo_url' => trim($data['logo_url'] ?? ''),
                'website_url' => $data['website_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Association', (string)$id);
        return $this->redirect('/admin/associations', 'Affiliation updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('associations:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM associations WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Association', (string)$id);
        return $this->redirect('/admin/associations', 'Affiliation deleted successfully.');
    }
}
