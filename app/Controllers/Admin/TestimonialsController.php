<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class TestimonialsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('testimonials:manage');
        $testimonials = Database::fetchAll('SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC');

        $section = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'testimonials' LIMIT 1");
        if (!$section) {
            $section = [
                'heading' => 'Words From Our Families',
                'subheading' => 'Authentic reflections from parents and students experiencing our creative pedagogy.',
                'content' => 'PARENT REFLECTIONS',
            ];
        }

        return $this->render('admin.testimonials.index', [
            'title' => 'Testimonials & Reviews — Dynamice CMS',
            'testimonials' => $testimonials,
            'section' => $section,
        ]);
    }

    public function updateHeading(Request $request): Response
    {
        $this->checkPermission('testimonials:manage');
        $data = $request->getBody();

        $heading = trim($data['heading'] ?? 'Words From Our Families');
        $subheading = trim($data['subheading'] ?? 'Authentic reflections from parents and students experiencing our creative pedagogy.');
        $badge = trim($data['content'] ?? 'PARENT REFLECTIONS');

        $existing = Database::fetchOne("SELECT id FROM sections WHERE section_key = 'testimonials' LIMIT 1");
        if ($existing) {
            Database::query(
                "UPDATE sections SET heading = :heading, subheading = :subheading, content = :badge, updated_at = NOW() WHERE section_key = 'testimonials'",
                [
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'badge' => $badge,
                ]
            );
        } else {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, sort_order, is_visible, created_at, updated_at)
                 VALUES (1, 'testimonials', :heading, :subheading, :badge, 6, 1, NOW(), NOW())",
                [
                    'heading' => $heading,
                    'subheading' => $subheading,
                    'badge' => $badge,
                ]
            );
        }

        $this->logAudit('UPDATE', 'SectionHeading', 'testimonials', ['heading' => $heading]);
        return $this->redirect('/admin/testimonials', 'Section heading and badge updated successfully.');
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('testimonials:manage');
        $data = $request->getBody();

        $personName = trim($data['person_name'] ?? '');
        $reviewText = trim($data['review_text'] ?? '');
        $rating = (int)($data['rating'] ?? 5);

        if (empty($personName) || empty($reviewText)) {
            return $this->redirect('/admin/testimonials', null, 'Person Name and Review Text are required.');
        }

        Database::query(
            'INSERT INTO testimonials (person_name, relation_or_role, review_text, rating, avatar_image_url, is_featured, sort_order, is_active, created_at, updated_at)
             VALUES (:person_name, :relation_or_role, :review_text, :rating, :avatar_image_url, :is_featured, :sort_order, :is_active, NOW(), NOW())',
            [
                'person_name' => $personName,
                'relation_or_role' => $data['relation_or_role'] ?? null,
                'review_text' => $reviewText,
                'rating' => max(1, min(5, $rating)),
                'avatar_image_url' => $data['avatar_image_url'] ?? null,
                'is_featured' => isset($data['is_featured']) && $data['is_featured'] ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) && $data['is_active'] ? 1 : 0,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'Testimonial', (string)$newId, ['person' => $personName]);
        return $this->redirect('/admin/testimonials', 'Testimonial added successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('testimonials:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        Database::query(
            'UPDATE testimonials SET person_name = :person_name, relation_or_role = :relation_or_role,
                    review_text = :review_text, rating = :rating, avatar_image_url = :avatar_image_url,
                    is_featured = :is_featured, sort_order = :sort_order, is_active = :is_active, updated_at = NOW()
             WHERE id = :id',
            [
                'person_name' => trim($data['person_name'] ?? ''),
                'relation_or_role' => $data['relation_or_role'] ?? null,
                'review_text' => trim($data['review_text'] ?? ''),
                'rating' => max(1, min(5, (int)($data['rating'] ?? 5))),
                'avatar_image_url' => $data['avatar_image_url'] ?? null,
                'is_featured' => isset($data['is_featured']) && $data['is_featured'] ? 1 : 0,
                'sort_order' => (int)($data['sort_order'] ?? 0),
                'is_active' => isset($data['is_active']) && $data['is_active'] ? 1 : 0,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'Testimonial', (string)$id);
        return $this->redirect('/admin/testimonials', 'Testimonial updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('testimonials:manage');
        $id = (int)($params['id'] ?? 0);
        Database::query('DELETE FROM testimonials WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'Testimonial', (string)$id);
        return $this->redirect('/admin/testimonials', 'Testimonial deleted successfully.');
    }
}
