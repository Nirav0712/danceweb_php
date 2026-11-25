<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class HeroController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('sections:manage');

        // 1. Fetch hero section content & heading from sections table
        $heroSection = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero' LIMIT 1");
        if (!$heroSection) {
            Database::query(
                "INSERT INTO sections (page_id, section_key, heading, subheading, content, sort_order, is_visible, created_at, updated_at)
                 VALUES (1, 'hero', 'Culture Is a Way of Life', 'Premier Performing Arts & Cultural Heritage', '', 1, 1, NOW(), NOW())"
            );
            $heroSection = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero' LIMIT 1");
        }

        // 2. Fetch all hero slides
        $slides = Database::fetchAll("SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC");

        return $this->render('admin.hero.index', [
            'title' => 'Homepage Hero Section & Slides — Dynamice CMS',
            'heroSection' => $heroSection,
            'slides' => $slides,
        ]);
    }

    public function updateHeading(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $data = $request->getBody();

        $heading = trim($data['heading'] ?? 'Culture Is a Way of Life');
        $subheading = trim($data['subheading'] ?? '');

        Database::query(
            "UPDATE sections SET heading = :heading, subheading = :subheading, updated_at = NOW() WHERE section_key = 'hero'",
            [
                'heading' => $heading,
                'subheading' => $subheading,
            ]
        );

        $this->logAudit('UPDATE', 'HeroHeading', 'hero', ['heading' => $heading]);
        return $this->redirect('/admin/hero', 'Hero heading updated successfully.');
    }

    public function storeSlide(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $data = $request->getBody();
        $imageUrl = trim($data['image_url'] ?? '');

        // Handle file upload if present
        if (!empty($_FILES['image_file']['name'])) {
            $uploadResult = UploadService::handleUpload($_FILES['image_file'], 'hero');
            if ($uploadResult['success']) {
                $imageUrl = $uploadResult['url'];
            } else {
                return $this->redirect('/admin/hero', null, $uploadResult['error'] ?? 'Image upload failed.');
            }
        }

        if (empty($imageUrl)) {
            return $this->redirect('/admin/hero', null, 'Please upload an image file or provide an image URL.');
        }

        $title = trim($data['title'] ?? '');
        $sortOrder = (int)($data['sort_order'] ?? 0);
        $isActive = isset($data['is_active']) ? 1 : 0;

        Database::query(
            "INSERT INTO hero_slides (title, image_url, sort_order, is_active, created_at, updated_at)
             VALUES (:title, :image_url, :sort_order, :is_active, NOW(), NOW())",
            [
                'title' => $title ?: null,
                'image_url' => $imageUrl,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'HeroSlide', (string)$newId, ['title' => $title, 'url' => $imageUrl]);
        return $this->redirect('/admin/hero', 'Hero slide added successfully.');
    }

    public function updateSlide(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        $slide = Database::fetchOne("SELECT * FROM hero_slides WHERE id = :id", ['id' => $id]);
        if (!$slide) {
            return $this->redirect('/admin/hero', null, 'Hero slide not found.');
        }

        $imageUrl = trim($data['image_url'] ?? $slide['image_url']);

        // Handle file upload replacement
        if (!empty($_FILES['image_file']['name'])) {
            $uploadResult = UploadService::handleUpload($_FILES['image_file'], 'hero');
            if ($uploadResult['success']) {
                $imageUrl = $uploadResult['url'];
            }
        }

        $title = trim($data['title'] ?? '');
        $sortOrder = (int)($data['sort_order'] ?? 0);
        $isActive = isset($data['is_active']) ? 1 : 0;

        Database::query(
            "UPDATE hero_slides SET title = :title, image_url = :image_url, sort_order = :sort_order, is_active = :is_active, updated_at = NOW() WHERE id = :id",
            [
                'title' => $title ?: null,
                'image_url' => $imageUrl,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'HeroSlide', (string)$id);
        return $this->redirect('/admin/hero', 'Hero slide updated successfully.');
    }

    public function deleteSlide(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $id = (int)($params['id'] ?? 0);

        Database::query("DELETE FROM hero_slides WHERE id = :id", ['id' => $id]);
        $this->logAudit('DELETE', 'HeroSlide', (string)$id);
        return $this->redirect('/admin/hero', 'Hero slide deleted successfully.');
    }
}
