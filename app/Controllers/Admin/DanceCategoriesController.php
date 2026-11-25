<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class DanceCategoriesController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('dance_forms:manage');
        $categories = Database::fetchAll('SELECT * FROM dance_categories ORDER BY sort_order ASC, name ASC');
        return $this->render('admin.dance_categories.index', [
            'title' => 'Dance Categories — Dynamice CMS',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('dance_forms:manage');
        $data = $request->getBody();
        $name = trim($data['name'] ?? '');
        $slug = trim($data['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));

        if (empty($name) || empty($slug)) {
            return $this->redirect('/admin/dance-categories', null, 'Category Name is required.');
        }

        Database::query(
            'INSERT INTO dance_categories (name, slug, description, sort_order, is_active, created_at, updated_at)
             VALUES (:name, :slug, :description, :sort_order, :is_active, NOW(), NOW())',
            [
                'name' => $name,
                'slug' => $slug,
                'description' => $data['description'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'DanceCategory', (string)$newId, ['name' => $name]);
        return $this->redirect('/admin/dance-categories', 'Category created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('dance_forms:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE dance_categories SET name = :name, slug = :slug, description = :description,
                    sort_order = :sort_order, is_active = :is_active, updated_at = NOW() WHERE id = :id',
            [
                'name' => trim($data['name'] ?? ''),
                'slug' => trim($data['slug'] ?? ''),
                'description' => $data['description'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'DanceCategory', (string)$id);
        return $this->redirect('/admin/dance-categories', 'Category updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('dance_forms:manage');
        $id = (int)($params['id'] ?? 0);
        // Check if referenced in dance_forms
        $count = Database::fetchOne('SELECT COUNT(*) as c FROM dance_forms WHERE category_id = :id', ['id' => $id])['c'] ?? 0;
        if ($count > 0) {
            return $this->redirect('/admin/dance-categories', null, 'Cannot delete category: forms are assigned to it.');
        }

        Database::query('DELETE FROM dance_categories WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'DanceCategory', (string)$id);
        return $this->redirect('/admin/dance-categories', 'Category deleted successfully.');
    }
}
