<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Services\UploadService;

class AboutController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('pages:edit');

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'about' LIMIT 1");
        if (!$page) {
            Database::query(
                "INSERT INTO pages (slug, title, subtitle, is_published, created_at, updated_at)
                 VALUES ('about', 'About Us', 'Founded in 2002 by Director Tirthraj Trivedi', 1, NOW(), NOW())"
            );
            $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'about' LIMIT 1");
        }

        $rawSections = Database::fetchAll("SELECT * FROM sections WHERE page_id = :pid", ['pid' => $page['id']]);
        $sections = [];
        foreach ($rawSections as $sec) {
            $sections[$sec['section_key']] = $sec;
        }

        return $this->render('admin.about.index', [
            'title' => 'About Us Page Management — Dynamice CMS',
            'page' => $page,
            'sections' => $sections,
        ]);
    }

    public function update(Request $request): Response
    {
        $this->checkPermission('pages:edit');
        $data = $request->getBody();

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'about' LIMIT 1");
        if (!$page) {
            return $this->redirect('/admin/about', null, 'About page record not found in database.');
        }

        $pageId = (int)$page['id'];

        // 1. Update Main Page Info & SEO
        $title = trim($data['page_title'] ?? 'About Us');
        $subtitle = trim($data['page_subtitle'] ?? 'Founded in 2002 by Director Tirthraj Trivedi');
        $bannerImageUrl = trim($data['page_banner_image_url'] ?? ($page['banner_image_url'] ?? ''));

        if (!empty($_FILES['page_banner_image']['tmp_name'])) {
            try {
                $upload = UploadService::uploadImage($_FILES['page_banner_image'], 'banners');
                $bannerImageUrl = $upload['url'] ?? $bannerImageUrl;
            } catch (\Throwable $e) {}
        }

        Database::query(
            "UPDATE pages SET title = :title, subtitle = :subtitle, banner_image_url = :banner_image_url,
                    meta_title = :meta_title, meta_description = :meta_description, updated_at = NOW() WHERE id = :id",
            [
                'title' => $title,
                'subtitle' => $subtitle,
                'banner_image_url' => $bannerImageUrl,
                'meta_title' => trim($data['meta_title'] ?? ''),
                'meta_description' => trim($data['meta_description'] ?? ''),
                'id' => $pageId,
            ]
        );

        // Helper to upsert a section
        $upsertSection = function (string $key, array $values) use ($pageId) {
            $existing = Database::fetchOne(
                "SELECT id FROM sections WHERE page_id = :pid AND section_key = :key LIMIT 1",
                ['pid' => $pageId, 'key' => $key]
            );

            if ($existing) {
                Database::query(
                    "UPDATE sections SET heading = :heading, subheading = :subheading, content = :content,
                            image_url = :image_url, button_text = :button_text, button_url = :button_url,
                            sort_order = :sort_order, updated_at = NOW()
                     WHERE id = :id",
                    [
                        'heading' => $values['heading'] ?? null,
                        'subheading' => $values['subheading'] ?? null,
                        'content' => $values['content'] ?? null,
                        'image_url' => $values['image_url'] ?? null,
                        'button_text' => $values['button_text'] ?? null,
                        'button_url' => $values['button_url'] ?? null,
                        'sort_order' => (int)($values['sort_order'] ?? 0),
                        'id' => $existing['id'],
                    ]
                );
            } else {
                Database::query(
                    "INSERT INTO sections (page_id, section_key, heading, subheading, content, image_url, button_text, button_url, sort_order, is_visible, created_at, updated_at)
                     VALUES (:pid, :key, :heading, :subheading, :content, :image_url, :button_text, :button_url, :sort_order, 1, NOW(), NOW())",
                    [
                        'pid' => $pageId,
                        'key' => $key,
                        'heading' => $values['heading'] ?? null,
                        'subheading' => $values['subheading'] ?? null,
                        'content' => $values['content'] ?? null,
                        'image_url' => $values['image_url'] ?? null,
                        'button_text' => $values['button_text'] ?? null,
                        'button_url' => $values['button_url'] ?? null,
                        'sort_order' => (int)($values['sort_order'] ?? 0),
                    ]
                );
            }
        };

        // 2. Founded in 2002 Section
        $foundedImage = trim($data['founded_image_url'] ?? '/assets/about/founded-2002-stage.jpg');
        if (!empty($_FILES['founded_image']['tmp_name'])) {
            try {
                $upload = UploadService::uploadImage($_FILES['founded_image'], 'about');
                $foundedImage = $upload['url'] ?? $foundedImage;
            } catch (\Throwable $e) {}
        }
        $upsertSection('about_founded', [
            'heading' => trim($data['founded_heading'] ?? 'Founded in 2002'),
            'subheading' => trim($data['founded_badge'] ?? 'ABOUT US'),
            'content' => json_encode([
                'est_year' => trim($data['founded_est_year'] ?? '2002'),
                'students_trained' => trim($data['founded_students_trained'] ?? '6,000+ Students Trained'),
                'p1' => trim($data['founded_p1'] ?? ''),
                'p2' => trim($data['founded_p2'] ?? ''),
                'p3' => trim($data['founded_p3'] ?? ''),
                'p4' => trim($data['founded_p4'] ?? ''),
            ], JSON_UNESCAPED_UNICODE),
            'image_url' => $foundedImage,
            'sort_order' => 1,
        ]);

        // 3. Our Dance Technique Section
        $upsertSection('about_technique', [
            'heading' => trim($data['technique_heading'] ?? "We're some simple steps for teaching dance"),
            'subheading' => trim($data['technique_badge'] ?? 'OUR DANCE TECHNIQUE'),
            'content' => json_encode([
                'step1' => trim($data['technique_step1'] ?? ''),
                'step2' => trim($data['technique_step2'] ?? ''),
                'step3' => trim($data['technique_step3'] ?? ''),
                'checklist' => [
                    trim($data['technique_check1'] ?? 'Dance Practice'),
                    trim($data['technique_check2'] ?? 'Dance Growth'),
                    trim($data['technique_check3'] ?? 'Dance Training'),
                    trim($data['technique_check4'] ?? 'Dance Improvement'),
                ],
            ], JSON_UNESCAPED_UNICODE),
            'sort_order' => 2,
        ]);

        // 4. Structured Pedagogical Framework (Dark Digital UI)
        $upsertSection('about_framework', [
            'heading' => trim($data['framework_heading'] ?? 'SIMPLE STEPS FOR TEACHING DANCE'),
            'subheading' => trim($data['framework_badge'] ?? 'Structured Pedagogical Framework'),
            'content' => json_encode([
                'subtitle' => trim($data['framework_subtitle'] ?? 'Our proven 4-stage systematic methodology transforming complete beginners into confident, culturally enriched stage performers.'),
                'step1_title' => trim($data['framework_s1_title'] ?? 'WARM-UP & STRETCH'),
                'step1_sub' => trim($data['framework_s1_sub'] ?? '1. Build Flexibility & Prevent Injury'),
                'step1_desc' => trim($data['framework_s1_desc'] ?? ''),
                'step2_title' => trim($data['framework_s2_title'] ?? 'BREAKDOWN & DRILL'),
                'step2_sub' => trim($data['framework_s2_sub'] ?? '2. Teach Basic Movements & Repetition'),
                'step2_desc' => trim($data['framework_s2_desc'] ?? ''),
                'step3_title' => trim($data['framework_s3_title'] ?? 'CHOREOGRAPH & CREATE'),
                'step3_sub' => trim($data['framework_s3_sub'] ?? '3. Combine Steps Into Routines'),
                'step3_desc' => trim($data['framework_s3_desc'] ?? ''),
                'step4_title' => trim($data['framework_s4_title'] ?? 'PERFORM & SHARE'),
                'step4_sub' => trim($data['framework_s4_sub'] ?? '4. Encourage Confidence & Expression'),
                'step4_desc' => trim($data['framework_s4_desc'] ?? ''),
            ], JSON_UNESCAPED_UNICODE),
            'sort_order' => 3,
        ]);

        // 5. Awards & Recognition Section
        $upsertSection('about_awards', [
            'heading' => trim($data['awards_heading'] ?? 'Our Awards & Recognition'),
            'subheading' => trim($data['awards_badge'] ?? 'RECOGNITIONS & ACCREDITATIONS'),
            'content' => json_encode([
                'p1' => trim($data['awards_p1'] ?? ''),
                'p2' => trim($data['awards_p2'] ?? ''),
                'p3' => trim($data['awards_p3'] ?? ''),
                'badge1' => trim($data['awards_b1'] ?? '🏆 London Book of World Records'),
                'badge2' => trim($data['awards_b2'] ?? '🏛️ Govt. Approved Vocational Centre'),
                'badge3' => trim($data['awards_b3'] ?? '🌐 CIOFF & IOV (UNESCO Partner)'),
                'badge4' => trim($data['awards_b4'] ?? '📜 IAF & EGAC Quality Certified'),
            ], JSON_UNESCAPED_UNICODE),
            'sort_order' => 4,
        ]);

        // 6. Media Journey Section
        $upsertSection('about_media', [
            'heading' => trim($data['media_heading'] ?? 'Our Media Journey'),
            'subheading' => trim($data['media_badge'] ?? 'RECOGNIZED GLOBALLY, CELEBRATED NATIONALLY'),
            'content' => json_encode([
                'col1_title' => trim($data['media_col1_title'] ?? '200+ Print Articles'),
                'col1_desc' => trim($data['media_col1_desc'] ?? ''),
                'col2_title' => trim($data['media_col2_title'] ?? '60+ News Channels'),
                'col2_desc' => trim($data['media_col2_desc'] ?? ''),
                'col3_title' => trim($data['media_col3_title'] ?? '50+ Global Features'),
                'col3_desc' => trim($data['media_col3_desc'] ?? ''),
            ], JSON_UNESCAPED_UNICODE),
            'sort_order' => 5,
        ]);

        // 7. Vision, Mission & Core Values Section
        $upsertSection('about_vision', [
            'heading' => trim($data['vision_heading'] ?? 'Our Vision, Mission & Core Values'),
            'subheading' => trim($data['vision_badge'] ?? 'Guiding Principles'),
            'content' => json_encode([
                'vision_desc' => trim($data['vision_desc'] ?? ''),
                'mission_desc' => trim($data['mission_desc'] ?? ''),
                'values_desc' => trim($data['values_desc'] ?? ''),
            ], JSON_UNESCAPED_UNICODE),
            'sort_order' => 6,
        ]);

        // 8. Call To Action Banner
        $upsertSection('about_cta', [
            'heading' => trim($data['cta_heading'] ?? 'Experience the Joy of Dance Firsthand'),
            'subheading' => trim($data['cta_subheading'] ?? 'Book a free observation session or trial class at our Nikol or Bapunagar branches.'),
            'button_text' => trim($data['cta_button_text'] ?? 'Contact Admissions'),
            'button_url' => trim($data['cta_button_url'] ?? '/contact'),
            'sort_order' => 7,
        ]);

        $this->logAudit('UPDATE', 'AboutPage', (string)$pageId);
        return $this->redirect('/admin/about', 'About Us page content and all sections updated successfully.');
    }
}
