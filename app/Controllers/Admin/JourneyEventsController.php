<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class JourneyEventsController extends BaseAdminController
{
    protected string $type = 'NATIONAL'; // or INTERNATIONAL

    public function __construct(string $type = 'NATIONAL')
    {
        parent::__construct();
        $this->type = strtoupper($type);
    }

    public function index(Request $request): Response
    {
        $this->checkPermission('journey:manage');
        $events = Database::fetchAll(
            'SELECT * FROM journey_events WHERE event_type = :type ORDER BY year DESC, sort_order ASC',
            ['type' => $this->type]
        );

        $isNational = $this->type === 'NATIONAL';
        return $this->render('admin.journey.index', [
            'title' => ($isNational ? 'National' : 'International') . ' Cultural Tours — Dynamice CMS',
            'events' => $events,
            'type' => $this->type,
            'isNational' => $isNational,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('journey:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $country = trim($data['country'] ?? ($this->type === 'NATIONAL' ? 'India' : ''));
        $year = (int)($data['year'] ?? date('Y'));

        if (empty($title) || empty($country)) {
            $redirectUrl = $this->type === 'NATIONAL' ? '/admin/journey/national' : '/admin/journey/international';
            return $this->redirect($redirectUrl, null, 'Title and Country are required.');
        }

        Database::query(
            'INSERT INTO journey_events (event_type, title, festival_name, country, country_code, city, year, description, cover_image_url, participants_count, sort_order, created_at, updated_at)
             VALUES (:event_type, :title, :festival_name, :country, :country_code, :city, :year, :description, :cover_image_url, :participants_count, :sort_order, NOW(), NOW())',
            [
                'event_type' => $this->type,
                'title' => $title,
                'festival_name' => $data['festival_name'] ?? null,
                'country' => $country,
                'country_code' => $data['country_code'] ?? null,
                'city' => $data['city'] ?? null,
                'year' => $year,
                'description' => $data['description'] ?? null,
                'cover_image_url' => $data['cover_image_url'] ?? null,
                'participants_count' => !empty($data['participants_count']) ? (int)$data['participants_count'] : null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'JourneyEvent', (string)$newId, ['type' => $this->type, 'title' => $title]);
        $redirectUrl = $this->type === 'NATIONAL' ? '/admin/journey/national' : '/admin/journey/international';
        return $this->redirect($redirectUrl, 'Tour event created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('journey:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE journey_events SET title = :title, festival_name = :festival_name, country = :country,
                    country_code = :country_code, city = :city, year = :year, description = :description,
                    cover_image_url = :cover_image_url, participants_count = :participants_count, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id AND event_type = :type',
            [
                'title' => trim($data['title'] ?? ''),
                'festival_name' => $data['festival_name'] ?? null,
                'country' => trim($data['country'] ?? ''),
                'country_code' => $data['country_code'] ?? null,
                'city' => $data['city'] ?? null,
                'year' => (int)($data['year'] ?? date('Y')),
                'description' => $data['description'] ?? null,
                'cover_image_url' => $data['cover_image_url'] ?? null,
                'participants_count' => !empty($data['participants_count']) ? (int)$data['participants_count'] : null,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
                'type' => $this->type,
            ]
        );

        $this->logAudit('UPDATE', 'JourneyEvent', (string)$id);
        $redirectUrl = $this->type === 'NATIONAL' ? '/admin/journey/national' : '/admin/journey/international';
        return $this->redirect($redirectUrl, 'Tour event updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('journey:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM journey_events WHERE id = :id AND event_type = :type', ['id' => $id, 'type' => $this->type]);
        $this->logAudit('DELETE', 'JourneyEvent', (string)$id);
        $redirectUrl = $this->type === 'NATIONAL' ? '/admin/journey/national' : '/admin/journey/international';
        return $this->redirect($redirectUrl, 'Tour event deleted successfully.');
    }
}
