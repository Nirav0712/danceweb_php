<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class MenusController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('menus:manage');
        $menus = Database::fetchAll('SELECT * FROM menu_items ORDER BY position ASC, sort_order ASC');
        return $this->render('admin.menus.index', [
            'title' => 'Navigation Menus — Dynamice CMS',
            'menus' => $menus,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('menus:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $url = trim($data['url'] ?? '');
        $position = in_array($data['position'] ?? '', ['HEADER', 'FOOTER']) ? $data['position'] : 'HEADER';

        if (empty($title) || empty($url)) {
            return $this->redirect('/admin/navigation', null, 'Title and URL are required.');
        }

        Database::query(
            'INSERT INTO menu_items (title, url, target, position, parent_id, sort_order, is_active, created_at, updated_at)
             VALUES (:title, :url, :target, :position, :parent_id, :sort_order, :is_active, NOW(), NOW())',
            [
                'title' => $title,
                'url' => $url,
                'target' => $data['target'] ?? '_self',
                'position' => $position,
                'parent_id' => !empty($data['parent_id']) ? (int)$data['parent_id'] : null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'MenuItem', (string)$newId, ['title' => $title, 'url' => $url]);
        return $this->redirect('/admin/navigation', 'Menu item added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('menus:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE menu_items SET title = :title, url = :url, target = :target, position = :position,
                    parent_id = :parent_id, sort_order = :sort_order, is_active = :is_active, updated_at = NOW()
             WHERE id = :id',
            [
                'title' => trim($data['title'] ?? ''),
                'url' => trim($data['url'] ?? ''),
                'target' => $data['target'] ?? '_self',
                'position' => in_array($data['position'] ?? '', ['HEADER', 'FOOTER']) ? $data['position'] : 'HEADER',
                'parent_id' => !empty($data['parent_id']) ? (int)$data['parent_id'] : null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'MenuItem', (string)$id);
        return $this->redirect('/admin/navigation', 'Menu item updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('menus:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM menu_items WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'MenuItem', (string)$id);
        return $this->redirect('/admin/navigation', 'Menu item deleted successfully.');
    }
}
