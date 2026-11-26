<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class AwardsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('awards:manage');
        $awards = Database::fetchAll('SELECT * FROM awards ORDER BY sort_order ASC, year DESC, id ASC');

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'awards' LIMIT 1");
        if (!$section) {
            $section = [
                'heading' => 'Awards & World Records',
                'subheading' => 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.',
                'content' => 'PRESTIGIOUS ACCREDITATIONS & HONORS',
                'button_text' => 'View All Records & Honors',
                'button_url' => '/awards',
            ];
        }

        return $this->render('admin.awards.index', [
            'title' => 'Awards & Records Management — Dynamice CMS',
            'awards' => $awards,
            'section' => $section,
        ]);
    }

    public function updateHeading(Request $request): Response
    {
        $this->checkPermission('awards:manage');
        $data = $request->getBody();

        $heading = trim($data['heading'] ?? 'Awards & World Records');
        $subheading = trim($data['subheading'] ?? 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.');
        $badge = trim($data['content'] ?? 'PRESTIGIOUS ACCREDITATIONS & HONORS');
        $btnText = trim($data['button_text'] ?? 'View All Records & Honors');
        $btnUrl = trim($data['button_url'] ?? '/awards');

        $existing = Database::fetchOne("SELECT id FROM sections WHERE section_key = 'awards' LIMIT 1");
        if ($existing) {
            Database::query(
                "UPDATE sections SET heading = :heading, subheading = :subheading, content = :badge, button_text = :btn_text, button_url = :btn_url, updated_at = NOW() WHERE section_key = 'awards'",
                [
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'badge' => $badge,
                    'btn_text' => $btnText,
                    'btn_url' => $btnUrl,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, button_text, button_url, sort_order, is_visible, created_at, updated_at)
                 VALUES (1, 'awards', :heading, :subheading, :badge, :btn_text, :btn_url, 5, 1, NOW(), NOW())",
                [
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'badge' => $badge,
                    'btn_text' => $btnText,
                    'btn_url' => $btnUrl,
                ]
            );
        }

        $this->logAudit('UPDATE', 'SectionHeading', 'awards', ['heading' => $heading]);

        // Also update dedicated /award page title & subtitle
        Database::query(
            "UPDATE pages SET title = :title, subtitle = :subtitle, updated_at = NOW() WHERE slug = 'award'",
            ['title' => $heading, 'subtitle' => $subheading]
        );

        return $this->redirect('/admin/awards', 'Section heading and subtitle updated successfully.');
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('awards:manage');
        $data = $request->getBody();

        $title = trim($data['title'] ?? '');
        $issuer = trim($data['issuer'] ?? '');
        $year = (int)($data['year'] ?? date('Y'));

        if (empty($title) || empty($issuer)) {
            return $this->redirect('/admin/awards', null, 'Title and Issuer are required.');
        }

        $imageUrl = trim($data['certificate_image_url'] ?? '');
        if (!empty($_FILES['certificate_image']['tmp_name'])) {
            try {
                $uploadResult = UploadService::uploadImage($_FILES['certificate_image'], 'awards');
                $imageUrl = $uploadResult['url'] ?? $imageUrl;
            } catch (\Throwable $e) {
                return $this->redirect('/admin/awards', null, 'Image upload failed: ' . $e->getMessage());
            }
        }

        Database::query(
            'INSERT INTO awards (title, issuer, category, year, description, certificate_image_url, is_record_book, is_featured, sort_order, created_at, updated_at)
             VALUES (:title, :issuer, :category, :year, :description, :certificate_image_url, :is_record_book, :is_featured, :sort_order, NOW(), NOW())',
            [
                'title' => $title,
                'issuer' => $issuer,
                'category' => $data['category'] ?? null,
                'year' => $year,
                'description' => $data['description'] ?? null,
                'certificate_image_url' => !empty($imageUrl) ? $imageUrl : '/assets/awards/01.jpg',
                'is_record_book' => isset($data['is_record_book']) && $data['is_record_book'] ? 1 : 0,
                'is_featured' => isset($data['is_featured']) && $data['is_featured'] ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Award', (string)$newId, ['title' => $title]);
        return $this->redirect('/admin/awards', 'Award created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('awards:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        $existing = Database::fetchOne('SELECT * FROM awards WHERE id = :id', ['id' => $id]);
        if (!$existing) {
            return $this->redirect('/admin/awards', null, 'Award not found.');
        }

        $imageUrl = trim($data['certificate_image_url'] ?? ($existing['certificate_image_url'] ?? ''));
        if (!empty($_FILES['certificate_image']['tmp_name'])) {
            try {
                $uploadResult = UploadService::uploadImage($_FILES['certificate_image'], 'awards');
                $imageUrl = $uploadResult['url'] ?? $imageUrl;
            } catch (\Throwable $e) {
                return $this->redirect('/admin/awards', null, 'Image upload failed: ' . $e->getMessage());
            }
        }

        Database::query(
            'UPDATE awards SET title = :title, issuer = :issuer, category = :category, year = :year,
                    description = :description, certificate_image_url = :certificate_image_url,
                    is_record_book = :is_record_book, is_featured = :is_featured, sort_order = :sort_order, updated_at = NOW()
             WHERE id = :id',
            [
                'title' => trim($data['title'] ?? ''),
                'issuer' => trim($data['issuer'] ?? ''),
                'category' => $data['category'] ?? null,
                'year' => (int)($data['year'] ?? date('Y')),
                'description' => $data['description'] ?? null,
                'certificate_image_url' => !empty($imageUrl) ? $imageUrl : '/assets/awards/01.jpg',
                'is_record_book' => isset($data['is_record_book']) && $data['is_record_book'] ? 1 : 0,
                'is_featured' => isset($data['is_featured']) && $data['is_featured'] ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Award', (string)$id);
        return $this->redirect('/admin/awards', 'Award updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('awards:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM awards WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Award', (string)$id);
        return $this->redirect('/admin/awards', 'Award deleted successfully.');
    }
}
