<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

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
            'SELECT * FROM journey_events WHERE event_type = :type ORDER BY year DESC, sort_order ASC, id DESC',
            ['type' => $this->type]
        );

        $isNational = $this->type === 'NATIONAL';
        $pageSlug = $isNational ? 'journey-national' : 'journey-international';
        $page = Database::fetchOne('SELECT * FROM pages WHERE slug = :slug LIMIT 1', ['slug' => $pageSlug]);

        $rawSections = [];
        if (!empty($page['id'])) {
            $rawSections = Database::fetchAll('SELECT * FROM sections WHERE page_id = :page_id', ['page_id' => $page['id']]);
        }
        $sections = [];
        foreach ($rawSections as $sec) {
            $sections[$sec['section_key']] = $sec;
        }

        return $this->render('admin.journey.index', [
            'title' => ($isNational ? 'National' : 'International') . ' Cultural Tours — Dynamice CMS',
            'events' => $events,
            'type' => $this->type,
            'isNational' => $isNational,
            'page' => $page,
            'sections' => $sections,
        ]);
    }

    public function updateSettings(Request $request): Response
    {
        $this->checkPermission('journey:manage');
        $data = $request->getBody();
        $isNational = $this->type === 'NATIONAL';
        $redirectUrl = $isNational ? '/admin/journey/national' : '/admin/journey/international';
        $pageSlug = $isNational ? 'journey-national' : 'journey-international';

        $page = Database::fetchOne('SELECT * FROM pages WHERE slug = :slug LIMIT 1', ['slug' => $pageSlug]);
        if (!$page) {
            return $this->redirect($redirectUrl, null, 'Page record not found.');
        }

        $pageTitle = trim($data['page_title'] ?? ($isNational ? 'Our National Journey' : 'Our International Journey'));
        $pageSubtitle = trim($data['page_subtitle'] ?? '');
        $metaTitle = trim($data['meta_title'] ?? '');
        $metaDescription = trim($data['meta_description'] ?? '');

        Database::query(
            'UPDATE pages SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_desc, updated_at = NOW() WHERE id = :id',
            [
                'title' => $pageTitle,
                'subtitle' => $pageSubtitle,
                'meta_title' => $metaTitle,
                'meta_desc' => $metaDescription,
                'id' => $page['id'],
            ]
        );

        // Upsert hero and showcase section content
        $heroBadge = trim($data['hero_badge'] ?? ($isNational ? 'Across India' : 'Global Tours'));
        $mapHeading = trim($data['map_heading'] ?? ($isNational ? 'Tours Across Major Indian States' : 'Tours Across World Nations'));
        $mapBadge = trim($data['map_badge'] ?? ($isNational ? 'National Map & Conclaves' : 'Global Footprint & Festivals'));
        $mapBaseNote = trim($data['map_base_note'] ?? ($isNational ? 'Base: Ahmedabad | Over 28+ National Festivals' : 'Base: Ahmedabad | 15+ World Nations'));
        $ctaText = trim($data['cta_text'] ?? ($isNational ? 'Want to see our international tours across 15+ world nations?' : 'Want to see our domestic tours across Indian states?'));
        $ctaUrl = trim($data['cta_url'] ?? ($isNational ? '/journey/international' : '/journey/national'));

        $sectionKey = $isNational ? 'national_map_showcase' : 'international_map_showcase';
        $contentJson = json_encode([
            'hero_badge' => $heroBadge,
            'map_heading' => $mapHeading,
            'map_badge' => $mapBadge,
            'map_base_note' => $mapBaseNote,
            'cta_text' => $ctaText,
            'cta_url' => $ctaUrl,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $existingSec = Database::fetchOne('SELECT id FROM sections WHERE page_id = :page_id AND section_key = :key LIMIT 1', [
            'page_id' => $page['id'],
            'key' => $sectionKey,
        ]);

        if ($existingSec) {
            Database::query(
                'UPDATE sections SET heading = :heading, subheading = :subheading, content = :content, updated_at = NOW() WHERE id = :id',
                [
                    'heading' => $mapHeading,
                    'subheading' => $mapBadge,
                    'content' => $contentJson,
                    'id' => $existingSec['id'],
                ]
            );
        } else {
            Database::query(
                'INSERT INTO sections (page_id, section_key, heading, subheading, content, sort_order, is_visible, created_at, updated_at)
                 VALUES (:page_id, :key, :heading, :subheading, :content, 1, 1, NOW(), NOW())',
                [
                    'page_id' => $page['id'],
                    'key' => $sectionKey,
                    'heading' => $mapHeading,
                    'subheading' => $mapBadge,
                    'content' => $contentJson,
                ]
            );
        }

        $this->logAudit('UPDATE', 'JourneyPageSettings', (string)$page['id']);
        return $this->redirect($redirectUrl, 'Page settings updated successfully.');
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

        // Handle File Upload if provided
        $coverImageUrl = trim($data['cover_image_url'] ?? '');
        if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = UploadService::handleUpload($_FILES['cover_image'], 'journey');
            if ($uploadResult['success']) {
                $coverImageUrl = $uploadResult['path'];
            }
        }

        Database::query(
            'INSERT INTO journey_events (event_type, title, festival_name, country, country_code, city, year, description, cover_image_url, participants_count, sort_order, created_at, updated_at)
             VALUES (:event_type, :title, :festival_name, :country, :country_code, :city, :year, :description, :cover_image_url, :participants_count, :sort_order, NOW(), NOW())',
            [
                'event_type' => $this->type,
                'title' => $title,
                'festival_name' => !empty($data['festival_name']) ? trim($data['festival_name']) : null,
                'country' => $country,
                'country_code' => !empty($data['country_code']) ? trim($data['country_code']) : ($this->type === 'NATIONAL' ? 'IN' : null),
                'city' => !empty($data['city']) ? trim($data['city']) : null,
                'year' => $year,
                'description' => !empty($data['description']) ? trim($data['description']) : null,
                'cover_image_url' => !empty($coverImageUrl) ? $coverImageUrl : null,
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

        // Handle File Upload if provided
        $coverImageUrl = trim($data['cover_image_url'] ?? '');
        if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = UploadService::handleUpload($_FILES['cover_image'], 'journey');
            if ($uploadResult['success']) {
                $coverImageUrl = $uploadResult['path'];
            }
        }

        Database::query(
            'UPDATE journey_events SET title = :title, festival_name = :festival_name, country = :country,
                    country_code = :country_code, city = :city, year = :year, description = :description,
                    cover_image_url = :cover_image_url, participants_count = :participants_count, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id AND event_type = :type',
            [
                'title' => trim($data['title'] ?? ''),
                'festival_name' => !empty($data['festival_name']) ? trim($data['festival_name']) : null,
                'country' => trim($data['country'] ?? ($this->type === 'NATIONAL' ? 'India' : '')),
                'country_code' => !empty($data['country_code']) ? trim($data['country_code']) : ($this->type === 'NATIONAL' ? 'IN' : null),
                'city' => !empty($data['city']) ? trim($data['city']) : null,
                'year' => (int)($data['year'] ?? date('Y')),
                'description' => !empty($data['description']) ? trim($data['description']) : null,
                'cover_image_url' => !empty($coverImageUrl) ? $coverImageUrl : null,
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
