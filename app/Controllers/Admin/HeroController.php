<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class HeroController extends BaseAdminController
{
    /**
     * Ensure the hero_slides and hero_rotating_phrases tables exist seamlessly without manual SQL execution.
     */
    protected function ensureTableExists(): void
    {
        try {
            // 1. Hero banner slides table
            Database::query("CREATE TABLE IF NOT EXISTS hero_slides (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NULL,
                image_url VARCHAR(500) NOT NULL,
                sort_order INT DEFAULT 0,
                is_active TINYINT(1) DEFAULT 1,
                created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3),
                updated_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Seed default slides from existing website assets if newly created and empty
            $count = (int)Database::fetchColumn("SELECT COUNT(*) FROM hero_slides");
            if ($count === 0) {
                $initialSlides = [
                    ['title' => 'Academy World Record Showcase', 'image_url' => '/assets/banners/homebanner.jpg', 'sort_order' => 1],
                    ['title' => 'Cultural Dance Troupe Performance', 'image_url' => '/assets/about/academy_group.jpg', 'sort_order' => 2],
                    ['title' => 'Heritage Stage Grand Production', 'image_url' => '/assets/about/founded-2002-stage.jpg', 'sort_order' => 3],
                    ['title' => 'Artistic Excellence & Rhythmic Mastery', 'image_url' => '/assets/about/dance-teaching-steps.jpg', 'sort_order' => 4],
                    ['title' => 'Traditional Garba & Raas Heritage', 'image_url' => '/assets/gallery/1.jpg', 'sort_order' => 5],
                ];
                foreach ($initialSlides as $s) {
                    Database::query(
                        "INSERT INTO hero_slides (title, image_url, sort_order, is_active, created_at, updated_at) VALUES (:title, :image_url, :sort_order, 1, NOW(), NOW())",
                        $s
                    );
                }
            }

            // 2. Hero rotating heading phrases table
            Database::query("CREATE TABLE IF NOT EXISTS hero_rotating_phrases (
                id INT AUTO_INCREMENT PRIMARY KEY,
                phrase VARCHAR(255) NOT NULL,
                sort_order INT DEFAULT 0,
                is_active TINYINT(1) DEFAULT 1,
                created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3),
                updated_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Seed default phrases if newly created and empty
            $phraseCount = (int)Database::fetchColumn("SELECT COUNT(*) FROM hero_rotating_phrases");
            if ($phraseCount === 0) {
                $initialPhrases = [
                    ['phrase' => 'Indian Dance', 'sort_order' => 1],
                    ['phrase' => 'Classical Dance', 'sort_order' => 2],
                    ['phrase' => 'Cultural Excellence', 'sort_order' => 3],
                    ['phrase' => 'Artistic Expression', 'sort_order' => 4],
                    ['phrase' => 'Creative Learning', 'sort_order' => 5],
                ];
                foreach ($initialPhrases as $p) {
                    Database::query(
                        "INSERT INTO hero_rotating_phrases (phrase, sort_order, is_active, created_at, updated_at) VALUES (:phrase, :sort_order, 1, NOW(), NOW())",
                        $p
                    );
                }
            }

            // 3. Ensure hero section exists with default "Empowering Young Minds Through"
            $heroSection = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero' LIMIT 1");
            if (!$heroSection) {
                Database::query(
                    "INSERT INTO sections (page_id, section_key, heading, subheading, content, sort_order, is_visible, created_at, updated_at)
                     VALUES (1, 'hero', 'Empowering Young Minds Through', 'Premier Performing Arts & Cultural Heritage', '{\"rotation_duration\":3,\"transition_style\":\"slide-fade\"}', 1, 1, NOW(), NOW())"
                );
            } else if ($heroSection['heading'] === 'Culture Is a Way of Life' || empty($heroSection['heading'])) {
                Database::query("UPDATE sections SET heading = 'Empowering Young Minds Through' WHERE section_key = 'hero'");
            }
        } catch (\Throwable $e) {
            // Silently log error, do not break the whole panel
            \App\Core\Logger::error("HeroController ensureTableExists error: " . $e->getMessage());
        }
    }

    public function index(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();

        // 1. Fetch hero section content & heading from sections table
        $heroSection = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero' LIMIT 1");
        if (!$heroSection) {
            $heroSection = [
                'heading' => 'Empowering Young Minds Through',
                'subheading' => 'Premier Performing Arts & Cultural Heritage',
                'content' => json_encode(['rotation_duration' => 3, 'transition_style' => 'slide-fade']),
            ];
        }

        // Parse JSON configuration for heading slider
        $config = json_decode($heroSection['content'] ?? '', true);
        if (!is_array($config)) {
            $config = [
                'rotation_duration' => 3,
                'transition_style' => 'slide-fade',
            ];
        }

        // 2. Fetch all hero rotating phrases
        try {
            $phrases = Database::fetchAll("SELECT * FROM hero_rotating_phrases ORDER BY sort_order ASC, id ASC");
        } catch (\Throwable $e) {
            $phrases = [];
        }

        // 3. Fetch all hero slides safely
        try {
            $slides = Database::fetchAll("SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC");
        } catch (\Throwable $e) {
            $slides = [];
        }

        return $this->render('admin.hero.index', [
            'title' => 'Homepage Hero Section & Slides — Dynamice CMS',
            'heroSection' => $heroSection,
            'config' => $config,
            'phrases' => $phrases,
            'slides' => $slides,
        ]);
    }

    public function updateHeading(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
        $data = $request->getBody();

        $heading = trim($data['heading'] ?? 'Empowering Young Minds Through');
        if (empty($heading)) {
            $heading = 'Empowering Young Minds Through';
        }
        $subheading = trim($data['subheading'] ?? '');

        // Validate rotation duration (range: 2 to 15 seconds)
        $duration = (int)($data['rotation_duration'] ?? 3);
        if ($duration < 2 || $duration > 15) {
            return $this->redirect('/admin/hero', null, 'Rotation duration must be between 2 and 15 seconds.');
        }

        // Validate transition style
        $transition = trim($data['transition_style'] ?? 'slide-fade');
        if (!in_array($transition, ['slide-fade', 'fade', 'slide-up'], true)) {
            $transition = 'slide-fade';
        }

        // Validate at least one enabled rotating phrase exists
        $enabledCount = (int)Database::fetchColumn("SELECT COUNT(*) FROM hero_rotating_phrases WHERE is_active = 1");
        if ($enabledCount === 0) {
            return $this->redirect('/admin/hero', null, 'At least one enabled rotating phrase must exist before saving heading configuration.');
        }

        $config = [
            'rotation_duration' => $duration,
            'transition_style' => $transition,
        ];

        Database::query(
            "UPDATE sections SET heading = :heading, subheading = :subheading, content = :content, updated_at = NOW() WHERE section_key = 'hero'",
            [
                'heading' => $heading,
                'subheading' => $subheading,
                'content' => json_encode($config),
            ]
        );

        $this->logAudit('UPDATE', 'HeroHeading', 'hero', ['heading' => $heading, 'config' => $config]);
        return $this->redirect('/admin/hero', 'Hero heading & rotation settings updated successfully.');
    }

    public function storePhrase(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
        $data = $request->getBody();

        $phrase = trim($data['phrase'] ?? '');
        if (empty($phrase)) {
            return $this->redirect('/admin/hero', null, 'Rotating phrase text cannot be empty.');
        }

        $sortOrder = (int)($data['sort_order'] ?? 0);
        $isActive = isset($data['is_active']) ? 1 : 0;

        Database::query(
            "INSERT INTO hero_rotating_phrases (phrase, sort_order, is_active, created_at, updated_at)
             VALUES (:phrase, :sort_order, :is_active, NOW(), NOW())",
            [
                'phrase' => $phrase,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ]
        );

        $newId = Database::lastInsertId();
        $this->logAudit('CREATE', 'HeroRotatingPhrase', (string)$newId, ['phrase' => $phrase]);
        return $this->redirect('/admin/hero', 'New rotating phrase added successfully.');
    }

    public function updatePhrase(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
        $id = (int)($params['id'] ?? 0);
        $data = $request->getBody();

        $existing = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $id]);
        if (!$existing) {
            return $this->redirect('/admin/hero', null, 'Rotating phrase not found.');
        }

        $phrase = trim($data['phrase'] ?? '');
        if (empty($phrase)) {
            return $this->redirect('/admin/hero', null, 'Rotating phrase text cannot be empty.');
        }

        $sortOrder = (int)($data['sort_order'] ?? 0);
        $isActive = isset($data['is_active']) ? 1 : 0;

        // If disabling, ensure at least one other active phrase remains
        if ($isActive === 0) {
            $otherActive = (int)Database::fetchColumn(
                "SELECT COUNT(*) FROM hero_rotating_phrases WHERE is_active = 1 AND id != :id",
                ['id' => $id]
            );
            if ($otherActive === 0) {
                return $this->redirect('/admin/hero', null, 'At least one enabled rotating phrase must remain active. Enable another phrase first.');
            }
        }

        Database::query(
            "UPDATE hero_rotating_phrases SET phrase = :phrase, sort_order = :sort_order, is_active = :is_active, updated_at = NOW() WHERE id = :id",
            [
                'phrase' => $phrase,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
                'id' => $id,
            ]
        );

        $this->logAudit('UPDATE', 'HeroRotatingPhrase', (string)$id, ['phrase' => $phrase]);
        return $this->redirect('/admin/hero', 'Rotating phrase updated successfully.');
    }

    public function deletePhrase(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
        $id = (int)($params['id'] ?? 0);

        $totalCount = (int)Database::fetchColumn("SELECT COUNT(*) FROM hero_rotating_phrases");
        if ($totalCount <= 1) {
            return $this->redirect('/admin/hero', null, 'Cannot delete the only phrase. At least one rotating phrase must exist.');
        }

        $activeRemaining = (int)Database::fetchColumn(
            "SELECT COUNT(*) FROM hero_rotating_phrases WHERE is_active = 1 AND id != :id",
            ['id' => $id]
        );
        if ($activeRemaining === 0) {
            return $this->redirect('/admin/hero', null, 'Cannot delete this phrase because it is the only active phrase. Enable another phrase first.');
        }

        Database::query("DELETE FROM hero_rotating_phrases WHERE id = :id", ['id' => $id]);
        $this->logAudit('DELETE', 'HeroRotatingPhrase', (string)$id);
        return $this->redirect('/admin/hero', 'Rotating phrase deleted successfully.');
    }

    public function togglePhrase(Request $request, array $params): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
        $id = (int)($params['id'] ?? 0);

        $existing = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $id]);
        if (!$existing) {
            return $this->redirect('/admin/hero', null, 'Rotating phrase not found.');
        }

        $newStatus = $existing['is_active'] ? 0 : 1;

        if ($newStatus === 0) {
            $otherActive = (int)Database::fetchColumn(
                "SELECT COUNT(*) FROM hero_rotating_phrases WHERE is_active = 1 AND id != :id",
                ['id' => $id]
            );
            if ($otherActive === 0) {
                return $this->redirect('/admin/hero', null, 'At least one enabled rotating phrase must remain active. Enable another phrase first.');
            }
        }

        Database::query("UPDATE hero_rotating_phrases SET is_active = :status, updated_at = NOW() WHERE id = :id", [
            'status' => $newStatus,
            'id' => $id,
        ]);

        $this->logAudit('UPDATE', 'HeroRotatingPhraseToggle', (string)$id, ['is_active' => $newStatus]);
        return $this->redirect('/admin/hero', 'Phrase status toggled successfully.');
    }

    public function storeSlide(Request $request): Response
    {
        $this->checkPermission('sections:manage');
        $this->ensureTableExists();
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
        $this->ensureTableExists();
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
        $this->ensureTableExists();
        $id = (int)($params['id'] ?? 0);

        Database::query("DELETE FROM hero_slides WHERE id = :id", ['id' => $id]);
        $this->logAudit('DELETE', 'HeroSlide', (string)$id);
        return $this->redirect('/admin/hero', 'Hero slide deleted successfully.');
    }
}
