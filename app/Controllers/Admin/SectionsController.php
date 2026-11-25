<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class SectionsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $pageId = (int)($request->query('page_id') ?? $request->getParam('page_id') ?? 0);

        if ($pageId > 0) {
            $sections = Database::fetchAll(
                'SELECT s.*, p.title as page_title FROM sections s JOIN pages p ON s.page_id = p.id WHERE s.page_id = :pid ORDER BY s.sort_order ASC',
                ['pid' => $pageId]
            );
        } else {
            $sections = Database::fetchAll(
                'SELECT s.*, p.title as page_title FROM sections s JOIN pages p ON s.page_id = p.id ORDER BY s.page_id ASC, s.sort_order ASC'
            );
        }

        $pages = Database::fetchAll('SELECT id, title, slug FROM pages ORDER BY title ASC');

        return $this->render('admin.sections.index', [
            'title' => 'Page Sections Management — Dynamice CMS',
            'sections' => $sections,
            'pages' => $pages,
            'selected_page_id' => $pageId,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $data = $request->getBody();

        $pageId = (int)($data['page_id'] ?? 0);
        $sectionKey = trim($data['section_key'] ?? '');

        if ($pageId <= 0 || empty($sectionKey)) {
            return $this->redirect('/admin/sections', null, 'Page and Section Key are required.');
        }

        Database::query(
            'INSERT INTO sections (page_id, section_key, heading, subheading, content, image_url, button_text, button_url, sort_order, is_visible, created_at, updated_at)
             VALUES (:page_id, :section_key, :heading, :subheading, :content, :image_url, :button_text, :button_url, :sort_order, :is_visible, NOW(), NOW())',
            [
                'page_id' => $pageId,
                'section_key' => $sectionKey,
                'heading' => $data['heading'] ?? null,
                'subheading' => $data['subheading'] ?? null,
                'content' => $data['content'] ?? null,
                'image_url' => $data['image_url'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_url' => $data['button_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_visible' => isset($data['is_visible']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Section', (string)$newId, ['page_id' => $pageId, 'key' => $sectionKey]);
        return $this->redirect('/admin/sections', 'Section created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE sections SET heading = :heading, subheading = :subheading, content = :content, image_url = :image_url,
                    button_text = :button_text, button_url = :button_url, sort_order = :sort_order, is_visible = :is_visible, updated_at = NOW()
             WHERE id = :id',
            [
                'heading' => $data['heading'] ?? null,
                'subheading' => $data['subheading'] ?? null,
                'content' => $data['content'] ?? null,
                'image_url' => $data['image_url'] ?? null,
                'button_text' => $data['button_text'] ?? null,
                'button_url' => $data['button_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_visible' => isset($data['is_visible']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Section', (string)$id);
        return $this->redirect('/admin/sections', 'Section updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM sections WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Section', (string)$id);
        return $this->redirect('/admin/sections', 'Section deleted successfully.');
    }
}
