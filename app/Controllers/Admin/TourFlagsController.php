<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class TourFlagsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('journey:manage');
        $flags = Database::fetchAll('SELECT * FROM tour_flags ORDER BY sort_order ASC, year DESC');
        return $this->render('admin.tour_flags.index', [
            'title' => 'Tour Flags Carousel — Dynamice CMS',
            'flags' => $flags,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('journey:manage');
        $data = $request->getBody();

        $country = trim($data['country_name'] ?? '');
        $code = trim($data['country_code'] ?? '');
        $flagUrl = trim($data['flag_url'] ?? '');
        $year = (int)($data['year'] ?? date('Y'));

        if (empty($country) || empty($flagUrl)) {
            return $this->redirect('/admin/tour-flags', null, 'Country name and Flag URL are required.');
        }

        Database::query(
            'INSERT INTO tour_flags (country_name, country_code, flag_url, journey_type, city, year, festival_name, target_url, sort_order, is_active, created_at, updated_at)
             VALUES (:country_name, :country_code, :flag_url, :journey_type, :city, :year, :festival_name, :target_url, :sort_order, :is_active, NOW(), NOW())',
            [
                'country_name' => $country,
                'country_code' => $code ?: substr(strtoupper($country), 0, 2),
                'flag_url' => $flagUrl,
                'journey_type' => in_array($data['journey_type'] ?? '', ['NATIONAL', 'INTERNATIONAL']) ? $data['journey_type'] : 'INTERNATIONAL',
                'city' => $data['city'] ?? null,
                'year' => $year,
                'festival_name' => $data['festival_name'] ?? null,
                'target_url' => $data['target_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'TourFlag', (string)$newId, ['country' => $country]);
        return $this->redirect('/admin/tour-flags', 'Tour flag added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('journey:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE tour_flags SET country_name = :country_name, country_code = :country_code, flag_url = :flag_url,
                    journey_type = :journey_type, city = :city, year = :year, festival_name = :festival_name,
                    target_url = :target_url, sort_order = :sort_order, is_active = :is_active, updated_at = NOW()
             WHERE id = :id',
            [
                'country_name' => trim($data['country_name'] ?? ''),
                'country_code' => trim($data['country_code'] ?? ''),
                'flag_url' => trim($data['flag_url'] ?? ''),
                'journey_type' => in_array($data['journey_type'] ?? '', ['NATIONAL', 'INTERNATIONAL']) ? $data['journey_type'] : 'INTERNATIONAL',
                'city' => $data['city'] ?? null,
                'year' => (int)($data['year'] ?? date('Y')),
                'festival_name' => $data['festival_name'] ?? null,
                'target_url' => $data['target_url'] ?? null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'TourFlag', (string)$id);
        return $this->redirect('/admin/tour-flags', 'Tour flag updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('journey:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM tour_flags WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'TourFlag', (string)$id);
        return $this->redirect('/admin/tour-flags', 'Tour flag deleted successfully.');
    }
}
