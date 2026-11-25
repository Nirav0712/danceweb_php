<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class DanceFormsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('dance_forms:manage');
        $forms = Database::fetchAll(
            'SELECT f.*, c.name as category_name FROM dance_forms f 
             LEFT JOIN dance_categories c ON f.category_id = c.id 
             ORDER BY f.sort_order ASC, f.name ASC'
        );
        $categories = Database::fetchAll('SELECT id, name FROM dance_categories WHERE is_active = 1 ORDER BY name ASC');

        return $this->render('admin.dance_forms.index', [
            'title' => 'Dance Forms Curriculum — Dynamice CMS',
            'forms' => $forms,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('dance_forms:manage');
        $data = $request->getBody();

        $name = trim($data['name'] ?? '');
        $categoryId = (int)($data['category_id'] ?? 0);
        $slug = trim($data['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));

        if (empty($name) || $categoryId <= 0) {
            return $this->redirect('/admin/dance-forms', null, 'Form Name and Category are required.');
        }

        Database::query(
            'INSERT INTO dance_forms (category_id, name, slug, tagline, description, curriculum, target_age_group, cover_image_url, sort_order, is_active, created_at, updated_at)
             VALUES (:category_id, :name, :slug, :tagline, :description, :curriculum, :target_age_group, :cover_image_url, :sort_order, :is_active, NOW(), NOW())',
            [
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => $slug,
                'tagline' => $data['tagline'] ?? null,
                'description' => $data['description'] ?? null,
                'curriculum' => $data['curriculum'] ?? null,
                'target_age_group' => $data['target_age_group'] ?? null,
                'cover_image_url' => $data['cover_image_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'DanceForm', (string)$newId, ['name' => $name]);
        return $this->redirect('/admin/dance-forms', 'Dance form created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('dance_forms:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE dance_forms SET category_id = :category_id, name = :name, slug = :slug, tagline = :tagline,
                    description = :description, curriculum = :curriculum, target_age_group = :target_age_group,
                    cover_image_url = :cover_image_url, sort_order = :sort_order, is_active = :is_active, updated_at = NOW()
             WHERE id = :id',
            [
                'category_id' => (int)($data['category_id'] ?? 0),
                'name' => trim($data['name'] ?? ''),
                'slug' => trim($data['slug'] ?? ''),
                'tagline' => $data['tagline'] ?? null,
                'description' => $data['description'] ?? null,
                'curriculum' => $data['curriculum'] ?? null,
                'target_age_group' => $data['target_age_group'] ?? null,
                'cover_image_url' => $data['cover_image_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'DanceForm', (string)$id);
        return $this->redirect('/admin/dance-forms', 'Dance form updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('dance_forms:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM dance_forms WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'DanceForm', (string)$id);
        return $this->redirect('/admin/dance-forms', 'Dance form deleted successfully.');
    }
}
