<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class SettingsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('settings:manage');
        $settings = Database::fetchAll('SELECT * FROM website_settings ORDER BY setting_key ASC');
        return $this->render('admin.settings.index', [
            'title' => 'Academy Settings & Global SEO — Dynamice CMS',
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): Response
    {
        $this->checkPermission('settings:manage');
        $data = $request->getBody();

        if (isset($data['settings']) && is_array($data['settings'])) {
            foreach ($data['settings'] as $key => $val) {
                Database::query(
                    'UPDATE website_settings SET setting_value = :val, updated_at = NOW() WHERE setting_key = :key',
                    ['val' => (string)$val, 'key' => (string)$key]
                );
            }
            $this->logAudit('UPDATE', 'WebsiteSettings', null, ['keys' => array_keys($data['settings'])]);
        }

        return $this->redirect('/admin/settings', 'Website settings updated successfully.');
    }
}
