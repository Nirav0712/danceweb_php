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

        $category = Database::fetchOne('SELECT * FROM dance_categories WHERE id = :id', ['id' => $id]);
        if (!$category) {
            return $this->redirect('/admin/dance-categories', null, 'Category not found.');
        }

        try {
            Database::beginTransaction();

            // 1. Delete associated dance_forms for this category to cleanly satisfy foreign key constraints
            Database::query('DELETE FROM dance_forms WHERE category_id = :id', ['id' => $id]);

            // 2. Unlink any gallery items that were tagged with this category (set to NULL so photos are preserved)
            Database::query('UPDATE gallery_items SET category_id = NULL WHERE category_id = :id', ['id' => $id]);

            // 3. Delete the category itself
            Database::query('DELETE FROM dance_categories WHERE id = :id', ['id' => $id]);

            Database::commit();

            $this->logAudit('DELETE', 'DanceCategory', (string)$id, ['name' => $category['name']]);
            return $this->redirect('/admin/dance-categories', 'Category "' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '" deleted successfully.');
        } catch (\Throwable $e) {
            Database::rollBack();
            \App\Core\Logger::error("DanceCategoriesController delete error: " . $e->getMessage());
            return $this->redirect('/admin/dance-categories', null, 'Error deleting category: ' . $e->getMessage());
        }
    }
}
