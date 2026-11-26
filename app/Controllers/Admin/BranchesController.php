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

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'contact' LIMIT 1");
        if (!$page) {
            Database::query(
                "INSERT INTO pages (slug, title, subtitle, is_published, created_at, updated_at)
                 VALUES ('contact', 'Connect With Our Academy', 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.', 1, NOW(), NOW())"
            );
            $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'contact' LIMIT 1");
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'contact_header' LIMIT 1");
        if (!$section) {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'contact_header', 'Connect With Our Academy', 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.', 'ADMISSIONS & ENQUIRIES', 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                ]
            );
            $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'contact_header' LIMIT 1");
        }

        $branches = Database::fetchAll('SELECT * FROM branches ORDER BY sort_order ASC, branch_name ASC');

        $settingsRows = Database::fetchAll('SELECT setting_key, setting_value FROM website_settings');
        $settings = [];
        foreach ($settingsRows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return $this->render('admin.branches.index', [
            'title' => 'Campuses & Contact Page CMS — Dynamice CMS',
            'branches' => $branches,
            'page' => $page,
            'section' => $section,
            'settings' => $settings,
        ]);
    }

    public function updateSettings(Request $request): Response
    {
        $this->checkPermission('branches:manage');
        $data = $request->getBody();

        $pageTitle = trim($data['page_title'] ?? 'Connect With Our Academy');
        $pageSubtitle = trim($data['page_subtitle'] ?? 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.');
        $badgeLabel = trim($data['badge_label'] ?? 'ADMISSIONS & ENQUIRIES');
        $metaTitle = trim($data['meta_title'] ?? $pageTitle);
        $metaDescription = trim($data['meta_description'] ?? $pageSubtitle);

        $phone = trim($data['contact_phone'] ?? '+91 99242 81372');
        $email = trim($data['contact_email'] ?? 'info@dynamicechildrenacademy.com');
        $hours = trim($data['contact_hours'] ?? 'Monday to Saturday: 8:00 AM - 9:00 PM | Sunday: 8:00 AM - 2:00 PM (Special Batches)');

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'contact' LIMIT 1");
        if ($page) {
            Database::query(
                "UPDATE pages SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW() WHERE slug = 'contact'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDescription,
                ]
            );
        }

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'contact_header' LIMIT 1");
        if ($section) {
            Database::query(
                "UPDATE sections SET heading = :title, subheading = :subtitle, content = :badge, updated_at = NOW() WHERE section_key = 'contact_header'",
                [
                    'title' => $pageTitle,
                    'subtitle' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
                 VALUES (:pid, 'contact_header', :heading, :subheading, :badge, 1, NOW(), NOW())",
                [
                    'pid' => $page['id'] ?? 1,
                    'heading' => $pageTitle,
                    'subheading' => $pageSubtitle,
                    'badge' => $badgeLabel,
                ]
            );
        }

        // Update website_settings table
        $settingUpdates = [
            'contact_phone' => $phone,
            'contact_email' => $email,
            'contact_hours' => $hours,
        ];

        foreach ($settingUpdates as $key => $val) {
            $exists = Database::fetchOne("SELECT id FROM website_settings WHERE setting_key = :k", ['k' => $key]);
            if ($exists) {
                Database::query("UPDATE website_settings SET setting_value = :v, updated_at = NOW() WHERE setting_key = :k", ['k' => $key, 'v' => $val]);
            } else {
                Database::query("INSERT INTO website_settings (setting_key, setting_value, setting_type, updated_at) VALUES (:k, :v, 'TEXT', NOW())", ['k' => $key, 'v' => $val]);
            }
        }

        $this->logAudit('UPDATE', 'ContactSettings', '1', ['title' => $pageTitle]);
        return $this->redirect('/admin/branches', 'Contact page header & settings updated successfully.');
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
