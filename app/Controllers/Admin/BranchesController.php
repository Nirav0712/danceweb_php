<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class BranchesController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('branches:manage');
        $branches = Database::fetchAll('SELECT * FROM branches ORDER BY sort_order ASC, branch_name ASC');
        return $this->render('admin.branches.index', [
            'title' => 'Campuses & Studio Branches — Dynamice CMS',
            'branches' => $branches,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('branches:manage');
        $data = $request->getBody();

        $name = trim($data['branch_name'] ?? '');
        $address = trim($data['address_line_1'] ?? '');
        $city = trim($data['city'] ?? '');
        $state = trim($data['state'] ?? 'Punjab');
        $phone = trim($data['phone_primary'] ?? '');
        $email = trim($data['email'] ?? '');

        if (empty($name) || empty($address) || empty($city) || empty($phone) || empty($email)) {
            return $this->redirect('/admin/branches', null, 'Branch name, address, city, phone and email are required.');
        }

        Database::query(
            'INSERT INTO branches (branch_name, address_line_1, address_line_2, city, state, phone_primary, phone_secondary, email, timing_info, google_map_embed_url, sort_order, is_active, created_at, updated_at)
             VALUES (:branch_name, :address_line_1, :address_line_2, :city, :state, :phone_primary, :phone_secondary, :email, :timing_info, :google_map_embed_url, :sort_order, :is_active, NOW(), NOW())',
            [
                'branch_name' => $name,
                'address_line_1' => $address,
                'address_line_2' => $data['address_line_2'] ?? null,
                'city' => $city,
                'state' => $state,
                'phone_primary' => $phone,
                'phone_secondary' => $data['phone_secondary'] ?? null,
                'email' => $email,
                'timing_info' => $data['timing_info'] ?? null,
                'google_map_embed_url' => $data['google_map_embed_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Branch', (string)$newId, ['name' => $name]);
        return $this->redirect('/admin/branches', 'Branch added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('branches:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE branches SET branch_name = :branch_name, address_line_1 = :address_line_1,
                    address_line_2 = :address_line_2, city = :city, state = :state, phone_primary = :phone_primary,
                    phone_secondary = :phone_secondary, email = :email, timing_info = :timing_info,
                    google_map_embed_url = :google_map_embed_url, sort_order = :sort_order, is_active = :is_active, updated_at = NOW()
             WHERE id = :id',
            [
                'branch_name' => trim($data['branch_name'] ?? ''),
                'address_line_1' => trim($data['address_line_1'] ?? ''),
                'address_line_2' => $data['address_line_2'] ?? null,
                'city' => trim($data['city'] ?? ''),
                'state' => trim($data['state'] ?? 'Punjab'),
                'phone_primary' => trim($data['phone_primary'] ?? ''),
                'phone_secondary' => $data['phone_secondary'] ?? null,
                'email' => trim($data['email'] ?? ''),
                'timing_info' => $data['timing_info'] ?? null,
                'google_map_embed_url' => $data['google_map_embed_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Branch', (string)$id);
        return $this->redirect('/admin/branches', 'Branch updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('branches:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM branches WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Branch', (string)$id);
        return $this->redirect('/admin/branches', 'Branch deleted successfully.');
    }
}
