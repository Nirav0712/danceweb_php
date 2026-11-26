<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Core\Database;
use App\Core\CSRF;
use App\Services\ContentService;
use App\Services\SeoService;

class PublicController
{
    public function home(Request $request): Response
    {
        // 1. Fetch categories
        $categories = Database::fetchAll("SELECT * FROM dance_categories ORDER BY sort_order ASC LIMIT 6");

        // 2. Fetch dance forms
        $danceForms = Database::fetchAll("SELECT * FROM dance_forms ORDER BY sort_order ASC LIMIT 8");

        // 3. Fetch awards
        $awards = Database::fetchAll("SELECT * FROM awards ORDER BY sort_order ASC LIMIT 6");

        // 4. Fetch featured gallery items
        $gallery = Database::fetchAll("SELECT * FROM gallery_items WHERE is_featured = 1 ORDER BY sort_order ASC LIMIT 8");

        // 4b. Fetch hero images: safely check hero_slides table, fallback to gallery_items and defaults
        $heroImages = [];
        try {
            $cmsHeroSlides = Database::fetchAll("SELECT title, image_url FROM hero_slides WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            if (!empty($cmsHeroSlides)) {
                foreach ($cmsHeroSlides as $slide) {
                    if (!empty($slide['image_url'])) {
                        $heroImages[] = [
                            'url' => $slide['image_url'],
                            'title' => $slide['title'] ?? 'Dynamic Children Academy Performance',
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {
            // Table might not exist yet on remote hostinger before migration
            $heroImages = [];
        }

        // If no active slides in hero_slides, fallback to featured gallery and default assets
        if (empty($heroImages)) {
            $heroGallery = Database::fetchAll("SELECT title, image_url FROM gallery_items ORDER BY is_featured DESC, sort_order ASC LIMIT 8");
            foreach ($heroGallery as $item) {
                if (!empty($item['image_url'])) {
                    $heroImages[] = [
                        'url' => $item['image_url'],
                        'title' => $item['title'] ?? 'Dynamic Children Academy Performance',
                    ];
                }
            }
        }

        // Ensure robust fallback high-quality images from media library if empty
        $defaultHeroAssets = [
            ['url' => '/assets/banners/homebanner.jpg', 'title' => 'Academy World Record Performance'],
            ['url' => '/assets/about/academy_group.jpg', 'title' => 'Cultural Dance Troupe'],
            ['url' => '/assets/about/founded-2002-stage.jpg', 'title' => 'Traditional Heritage Stage Showcase'],
            ['url' => '/assets/about/dance-teaching-steps.jpg', 'title' => 'Mastery & Technique Training'],
            ['url' => '/assets/gallery/1.jpg', 'title' => 'Folk Dance Troupe'],
            ['url' => '/assets/gallery/2.jpg', 'title' => 'Classical Garba & Raas'],
        ];
        if (empty($heroImages)) {
            $heroImages = $defaultHeroAssets;
        }

        // 5. Fetch tour flags
        $tourFlags = Database::fetchAll("SELECT * FROM tour_flags WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 16");

        // 6. Fetch testimonials
        $testimonials = Database::fetchAll("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 4");

        // 7. Fetch sections and index by section_key
        $rawSections = Database::fetchAll("SELECT * FROM sections WHERE is_visible = 1 AND page_id = (SELECT id FROM pages WHERE slug = 'home' LIMIT 1) ORDER BY sort_order ASC");
        $sections = [];
        foreach ($rawSections as $sec) {
            $sections[$sec['section_key']] = $sec;
        }

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'home' LIMIT 1");
        $settings = ContentService::getSettings();

        // 8. Fetch disciplines / services curriculum data (CMS-integrated with fallbacks)
        $disciplines = [
            'service' => [
                'id' => 'service',
                'tabLabel' => 'SERVICE',
                'title' => $sections['curriculum_service']['heading'] ?? 'Professional Event & Stage Services',
                'subtitle' => $sections['curriculum_service']['subheading'] ?? 'Custom Choreography, Corporate Productions & Institutional Training',
                'description' => $sections['curriculum_service']['content'] ?? 'We provide professional dance services for events, annual school functions, cultural showcases, and corporate presentations tailored to match the theme, audience, and occasion. Our choreographers combine creativity, theatrical discipline, and performance excellence to deliver memorable, grand experiences.',
                'image' => $sections['curriculum_service']['image_url'] ?? '/assets/homepage/services/service.jpg',
                'pillColor' => 'rose',
                'accentGradient' => 'from-rose-500 via-red-500 to-pink-500',
                'ctaText' => $sections['curriculum_service']['button_text'] ?? 'Book Event Choreography',
                'ctaUrl' => $sections['curriculum_service']['button_url'] ?? '/contact',
                'badges' => ['Event Choreography', 'School Annual Days', 'Stage Production', 'Competition Coaching'],
            ],
            'dance' => [
                'id' => 'dance',
                'tabLabel' => 'DANCE',
                'title' => $sections['curriculum_dance']['heading'] ?? 'Creative Movement & Indian Dance Heritage',
                'subtitle' => $sections['curriculum_dance']['subheading'] ?? 'Classical Kathak & Bharatnatyam, Authentic Folk Garba, Bollywood & Contemporary',
                'description' => $sections['curriculum_dance']['content'] ?? 'At our academy, we inspire children aged 4 to 14 to discover the joy of movement through a warm, encouraging environment. From traditional Gujarati Garba, Dandiya Raas, and Classical disciplines to high-energy Bollywood and Contemporary fusion, our progressive curriculum boosts stamina, posture, rhythm coordination, and stage presence.',
                'image' => $sections['curriculum_dance']['image_url'] ?? '/assets/homepage/services/dance.jpg',
                'pillColor' => 'emerald',
                'accentGradient' => 'from-emerald-500 via-teal-500 to-cyan-500',
                'ctaText' => $sections['curriculum_dance']['button_text'] ?? 'Explore Dance Curriculum',
                'ctaUrl' => $sections['curriculum_dance']['button_url'] ?? '/contact',
                'badges' => ['Folk & Garba', 'Classical Kathak', 'Bollywood Rhythm', 'Contemporary Floorwork'],
            ],
            'gymnastics' => [
                'id' => 'gymnastics',
                'tabLabel' => 'GYMNASTICS',
                'title' => $sections['curriculum_gymnastics']['heading'] ?? 'Youth Gymnastics & Aerial Agility',
                'subtitle' => $sections['curriculum_gymnastics']['subheading'] ?? 'Strength, Balance, Flexibility & Injury-Free Mat Acrobatics',
                'description' => $sections['curriculum_gymnastics']['content'] ?? 'We provide a safe, joyful, and highly structured environment for children aged 4 to 12 years to build physical strength, core balance, and motor agility. Supervised by certified mentors on high-density impact mats, exercises range from forward/backward tumbling and beam balance to rhythmic flexibility drills and safe acrobatic tumbling.',
                'image' => $sections['curriculum_gymnastics']['image_url'] ?? '/assets/homepage/services/gymnastics.jpg',
                'pillColor' => 'amber',
                'accentGradient' => 'from-amber-500 via-orange-500 to-yellow-500',
                'ctaText' => $sections['curriculum_gymnastics']['button_text'] ?? 'Join Gymnastics Batches',
                'ctaUrl' => $sections['curriculum_gymnastics']['button_url'] ?? '/contact',
                'badges' => ['Tumbling & Rolls', 'Core Balance', 'Flexibility Drills', 'Safety Mat Rigging'],
            ],
            'drama' => [
                'id' => 'drama',
                'tabLabel' => 'DRAMA SPEAKING',
                'title' => $sections['curriculum_drama']['heading'] ?? 'Dramatic Arts & Public Speaking',
                'subtitle' => $sections['curriculum_drama']['subheading'] ?? 'Voice Modulation, Theatrical Expressions & Stage Poise',
                'description' => $sections['curriculum_drama']['content'] ?? 'Our drama and public speaking program nurtures self-confidence, articulate diction, and emotional communication in young performers. Through interactive role-play, theatrical improv, script reading, and navarasa facial expressions, children overcome stage fright and develop unshakeable confidence that serves them for a lifetime.',
                'image' => $sections['curriculum_drama']['image_url'] ?? '/assets/homepage/services/drama.jpg',
                'pillColor' => 'sky',
                'accentGradient' => 'from-sky-500 via-blue-500 to-indigo-500',
                'ctaText' => $sections['curriculum_drama']['button_text'] ?? 'Enroll for Speech & Drama',
                'ctaUrl' => $sections['curriculum_drama']['button_url'] ?? '/contact',
                'badges' => ['Voice Projection', 'Stage Confidence', 'Storytelling & Bhav', 'Improv Theatrics'],
            ],
            'modeling' => [
                'id' => 'modeling',
                'tabLabel' => 'MODELING',
                'title' => $sections['curriculum_modeling']['heading'] ?? 'Fashion Runway, Posture & Poise',
                'subtitle' => $sections['curriculum_modeling']['subheading'] ?? 'Graceful Gait, Camera Angle Awareness & Ethnic Styling',
                'description' => $sections['curriculum_modeling']['content'] ?? 'Our modeling and personality grooming sessions instill confident posture, graceful runway walks, and lens presence. Children master camera angles, ethnic costume presentation, head-tilt poise, and stage etiquette—fostering poise, self-esteem, and charismatic personality in every aspiring student.',
                'image' => $sections['curriculum_modeling']['image_url'] ?? '/assets/homepage/services/modeling.jpg',
                'pillColor' => 'pink',
                'accentGradient' => 'from-pink-500 via-fuchsia-500 to-rose-500',
                'ctaText' => $sections['curriculum_modeling']['button_text'] ?? 'Explore Runway Grooming',
                'ctaUrl' => $sections['curriculum_modeling']['button_url'] ?? '/contact',
                'badges' => ['Runway Gait', 'Camera Angles', 'Costume Poise', 'Pageant Etiquette'],
            ],
            'drawing' => [
                'id' => 'drawing',
                'tabLabel' => 'DRAWING',
                'title' => $sections['curriculum_drawing']['heading'] ?? 'Fine Arts, Sketching & Creative Crafts',
                'subtitle' => $sections['curriculum_drawing']['subheading'] ?? 'Color Theory, Perspective Drawing & Hands-on Visual Crafts',
                'description' => $sections['curriculum_drawing']['content'] ?? 'From fundamental pencil sketching and shading to expressive watercolor washes and festival-themed 3D crafts, our fine arts curriculum nurtures fine motor control and visual imagination. Students showcase their creations at our annual exhibitions, celebrating their distinctive aesthetic talents.',
                'image' => $sections['curriculum_drawing']['image_url'] ?? '/assets/homepage/services/drawing.jpg',
                'pillColor' => 'indigo',
                'accentGradient' => 'from-indigo-500 via-purple-500 to-violet-500',
                'ctaText' => $sections['curriculum_drawing']['button_text'] ?? 'Join Art & Craft Studio',
                'ctaUrl' => $sections['curriculum_drawing']['button_url'] ?? '/contact',
                'badges' => ['Pencil Sketching', 'Watercolor Theory', 'Seasonal Crafts', 'Annual Exhibition'],
            ],
            'spiritual' => [
                'id' => 'spiritual',
                'tabLabel' => 'SPIRITUAL',
                'title' => $sections['curriculum_spiritual']['heading'] ?? 'Spiritual Heritage & Vedic Value Invocations',
                'subtitle' => $sections['curriculum_spiritual']['subheading'] ?? 'Nataraja Vandana, Sanskrit Slokas & Cultural Mindfulness',
                'description' => $sections['curriculum_spiritual']['content'] ?? 'Rooting modern youth in eternal Indian spiritual values, this discipline imparts Nataraja Vandana, sacred mudras, Vedic chants, and contemplative mindfulness. We teach respect for traditions, moral values, and emotional grounding through music, story recitals, and respectful stage traditions.',
                'image' => $sections['curriculum_spiritual']['image_url'] ?? '/assets/homepage/services/spiritual.jpg',
                'pillColor' => 'violet',
                'accentGradient' => 'from-violet-600 via-purple-600 to-fuchsia-600',
                'ctaText' => $sections['curriculum_spiritual']['button_text'] ?? 'Discover Spiritual Roots',
                'ctaUrl' => $sections['curriculum_spiritual']['button_url'] ?? '/contact',
                'badges' => ['Nataraja Vandana', 'Sanskrit Chants', 'Sacred Mudras', 'Mindful Values'],
            ],
        ];

        $seo = SeoService::resolve('/', [
            'title' => $page['title'] ?? 'Dynamice Children Academy — Premier Dance Institute Gujarat',
            'metaTitle' => $page['meta_title'] ?? 'Dynamice Children Academy — Indian Folk & Classical Dance Academy',
            'metaDescription' => $page['meta_description'] ?? 'Discover the joy of Indian folk, classical, and contemporary dance with Dynamice Children Academy in Nikol and Bapunagar, Ahmedabad.',
        ]);

        return (new Response())->html(View::render('public.home', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'categories' => $categories,
            'danceForms' => $danceForms,
            'awards' => $awards,
            'gallery' => $gallery,
            'heroImages' => $heroImages,
            'tourFlags' => $tourFlags,
            'testimonials' => $testimonials,
            'sections' => $sections,
            'page' => $page,
            'disciplines' => $disciplines,
            'settings' => $settings,
        ]));
    }

    public function about(Request $request): Response
    {
        $associations = Database::fetchAll("SELECT * FROM associations ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'about' LIMIT 1");
        $settings = ContentService::getSettings();

        $seo = SeoService::resolve('/about', [
            'title' => $page['title'] ?? 'About Us — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'About Academy & Founder Director Shri Tirthraj Trivedi',
            'metaDescription' => $page['meta_description'] ?? 'Learn about the legacy of Dynamice Children Academy, founded in 1998 to train generations of children in authentic Indian cultural dance.',
        ]);

        return (new Response())->html(View::render('public.about', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'associations' => $associations,
            'page' => $page,
            'settings' => $settings,
        ]));
    }

    public function gallery(Request $request): Response
    {
        $selectedCat = (int) $request->query('category', 0);
        $categories = Database::fetchAll("SELECT * FROM dance_categories ORDER BY sort_order ASC");

        if ($selectedCat > 0) {
            $items = Database::fetchAll("SELECT * FROM gallery_items WHERE category_id = :cat ORDER BY sort_order ASC", ['cat' => $selectedCat]);
        } else {
            $items = Database::fetchAll("SELECT * FROM gallery_items ORDER BY sort_order ASC LIMIT 60");
        }

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'gallery' LIMIT 1");
        $seo = SeoService::resolve('/gallery', [
            'title' => $page['title'] ?? 'Photo & Event Gallery — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Photo Gallery of State, National & World Dance Performances',
            'metaDescription' => $page['meta_description'] ?? 'Browse vibrant stage performances, international tours, competition wins, and traditional festival dance photos.',
        ]);

        return (new Response())->html(View::render('public.gallery', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'categories' => $categories,
            'items' => $items,
            'selectedCat' => $selectedCat,
        ]));
    }

    public function awards(Request $request): Response
    {
        $awards = Database::fetchAll("SELECT * FROM awards ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'award' LIMIT 1");

        $seo = SeoService::resolve('/awards', [
            'title' => $page['title'] ?? 'Awards & World Records — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Limca Book & Golden Book of World Records Awards',
            'metaDescription' => $page['meta_description'] ?? 'Prestigious honors, world records, and state trophies achieved by academy students across 25+ years of cultural dance excellence.',
        ]);

        return (new Response())->html(View::render('public.awards', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'awards' => $awards,
        ]));
    }

    public function associations(Request $request): Response
    {
        $associations = Database::fetchAll("SELECT * FROM associations ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'associations' LIMIT 1");

        $seo = SeoService::resolve('/associations', [
            'title' => $page['title'] ?? 'Affiliations & Accreditations — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Cultural Affiliations & International Partnerships',
            'metaDescription' => $page['meta_description'] ?? 'Recognized by national cultural ministries and international folk dance organizations worldwide.',
        ]);

        return (new Response())->html(View::render('public.associations', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'associations' => $associations,
        ]));
    }

    public function nationalJourney(Request $request): Response
    {
        $events = Database::fetchAll("SELECT * FROM journey_events WHERE event_type = 'NATIONAL' ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'journey-national' LIMIT 1");

        $seo = SeoService::resolve('/journey/national', [
            'title' => $page['title'] ?? 'National Journey — Cultural Festival Tours in India',
            'metaTitle' => $page['meta_title'] ?? 'National Dance Tours Across Indian States & Union Territories',
            'metaDescription' => $page['meta_description'] ?? 'Performances at Youth Festivals, National Folk Dance Conventions, and State Cultural Celebrations across India.',
        ]);

        return (new Response())->html(View::render('public.journey_national', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'events' => $events,
        ]));
    }

    public function internationalJourney(Request $request): Response
    {
        $events = Database::fetchAll("SELECT * FROM journey_events WHERE event_type = 'INTERNATIONAL' ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'journey-international' LIMIT 1");

        $seo = SeoService::resolve('/journey/international', [
            'title' => $page['title'] ?? 'International Journey — World Cultural Tours',
            'metaTitle' => $page['meta_title'] ?? 'International Folk Dance Tours — Turkey, Europe & Beyond',
            'metaDescription' => $page['meta_description'] ?? 'Representing India at the Golden Carnation International Folk Dance Competition and world cultural festivals.',
        ]);

        return (new Response())->html(View::render('public.journey_intl', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'events' => $events,
        ]));
    }

    public function nationalNews(Request $request): Response
    {
        $news = Database::fetchAll("SELECT * FROM news_items WHERE news_scope = 'NATIONAL' ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'news-national' LIMIT 1");

        $seo = SeoService::resolve('/news/national', [
            'title' => $page['title'] ?? 'National Press Coverage — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Newspaper Clippings & Press Coverage in Gujarat and India',
            'metaDescription' => $page['meta_description'] ?? 'Print media reviews and festival press coverage from Sandesh, Divya Bhaskar, Gujarat Samachar, and national dailies.',
        ]);

        return (new Response())->html(View::render('public.news_national', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'news' => $news,
        ]));
    }

    public function internationalNews(Request $request): Response
    {
        $news = Database::fetchAll("SELECT * FROM news_items WHERE news_scope = 'INTERNATIONAL' ORDER BY sort_order ASC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'news-international' LIMIT 1");

        $seo = SeoService::resolve('/news/international', [
            'title' => $page['title'] ?? 'International Press Coverage — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Global Press Features & International Media Coverage',
            'metaDescription' => $page['meta_description'] ?? 'International newspapers and cultural festival bulletins covering our young dancers overseas.',
        ]);

        return (new Response())->html(View::render('public.news_intl', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'news' => $news,
        ]));
    }

    public function blogs(Request $request): Response
    {
        $blogs = Database::fetchAll("SELECT * FROM blog_posts WHERE status = 'PUBLISHED' ORDER BY published_at DESC");
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'blog' LIMIT 1");

        $seo = SeoService::resolve('/blogs', [
            'title' => $page['title'] ?? 'Dance Stories & Articles — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Dance Education, Folk Traditions & Cultural Heritage Stories',
            'metaDescription' => $page['meta_description'] ?? 'Read expert insights on dance benefits for child development, traditional Garba history, and academy tour journals.',
        ]);

        return (new Response())->html(View::render('public.blogs', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'blogs' => $blogs,
        ]));
    }

    public function blogDetail(Request $request, array $params = []): Response
    {
        $slug = $params['slug'] ?? $request->param('slug');
        $blog = Database::fetchOne("SELECT * FROM blog_posts WHERE slug = :slug AND status = 'PUBLISHED' LIMIT 1", ['slug' => $slug]);

        if (!$blog) {
            $resp = new Response();
            $resp->status(404);
            return $resp->html(View::render('errors.404', ['title' => 'Story Not Found', 'uri' => "/blogs/{$slug}"]), 404);
        }

        $recentBlogs = Database::fetchAll("SELECT id, slug, title, published_at FROM blog_posts WHERE id != :id AND status = 'PUBLISHED' ORDER BY published_at DESC LIMIT 4", ['id' => $blog['id']]);

        $seo = SeoService::resolve("/blogs/{$slug}", [
            'title' => "{$blog['title']} — Dance Stories",
            'metaTitle' => $blog['meta_title'] ?: $blog['title'],
            'metaDescription' => $blog['meta_description'] ?: substr(strip_tags($blog['excerpt'] ?? $blog['content']), 0, 160),
            'ogImage' => $blog['featured_image_url'] ?? null,
            'ogType' => 'article',
            'article' => $blog,
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => '/'],
                ['name' => 'Dance Stories', 'url' => '/blogs'],
                ['name' => $blog['title'], 'url' => "/blogs/{$slug}"]
            ]
        ]);

        return (new Response())->html(View::render('public.blog_detail', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'blog' => $blog,
            'recentBlogs' => $recentBlogs,
        ]));
    }

    public function contact(Request $request): Response
    {
        $branches = ContentService::getBranches();
        $settings = ContentService::getSettings();
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'contact' LIMIT 1");

        $seo = SeoService::resolve('/contact', [
            'title' => $page['title'] ?? 'Contact Us & Campus Locations — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'Join Dance Batches in Nikol & Bapunagar, Ahmedabad',
            'metaDescription' => $page['meta_description'] ?? 'Connect with our dance academy admissions team. Visit our studios at Vaikunth Complex Nikol or Centre Point Bapunagar.',
        ]);

        return (new Response())->html(View::render('public.contact', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'branches' => $branches,
            'settings' => $settings,
            'csrf_token' => CSRF::getToken(),
        ]));
    }

    public function customPage(Request $request, array $params = []): Response
    {
        $slug = $params['slug'] ?? $request->param('slug');
        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = :slug AND is_published = 1 LIMIT 1", ['slug' => $slug]);

        if (!$page) {
            $resp = new Response();
            $resp->status(404);
            return $resp->html(View::render('errors.404', ['title' => 'Page Not Found', 'uri' => "/page/{$slug}"]), 404);
        }

        $sections = Database::fetchAll("SELECT * FROM sections WHERE page_id = :pid AND is_visible = 1 ORDER BY sort_order ASC", ['pid' => $page['id']]);

        $seo = SeoService::resolve("/page/{$slug}", [
            'title' => $page['title'] ?? 'Custom Page',
            'metaTitle' => $page['meta_title'] ?? $page['title'],
            'metaDescription' => $page['meta_description'] ?? ($page['subtitle'] ?? ''),
            'bannerImage' => $page['banner_image_url'] ?? null,
        ]);

        return (new Response())->html(View::render('public.custom_page', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'page' => $page,
            'sections' => $sections,
        ]));
    }

    public function submitEnquiry(Request $request): Response
    {
        $token = $request->post('csrf_token');
        if (!CSRF::validate($token)) {
            return (new Response())->json(['success' => false, 'message' => 'Invalid or expired security token.'], 400);
        }

        $studentName = trim((string) $request->post('student_name'));
        $parentName = trim((string) $request->post('parent_name'));
        $phone = trim((string) $request->post('phone'));
        $email = trim((string) $request->post('email'));
        $message = trim((string) $request->post('message'));
        $branch = trim((string) $request->post('preferred_branch', 'Nikol'));

        if (empty($studentName) || empty($phone)) {
            return (new Response())->json(['success' => false, 'message' => 'Student name and phone number are required.'], 422);
        }

        // Sanitize strings
        $studentName = htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8');
        $parentName = htmlspecialchars($parentName, ENT_QUOTES, 'UTF-8');
        $phone = preg_replace('/[^0-9+\-\s()]/', '', $phone);
        $combinedName = !empty($parentName) ? "{$studentName} (Parent: {$parentName})" : $studentName;
        $subject = 'Student Admission Enquiry';

        try {
            Database::query(
                "INSERT INTO enquiries (name, email, phone, subject, message, preferred_branch, status, created_at, updated_at) 
                 VALUES (:name, :email, :phone, :subject, :msg, :branch, 'NEW', NOW(), NOW())",
                [
                    'name' => $combinedName,
                    'email' => $email ?: 'not_provided@academy.com',
                    'phone' => $phone,
                    'subject' => $subject,
                    'msg' => $message ?: 'Admission enquiry submitted via website form.',
                    'branch' => $branch,
                ]
            );
            return (new Response())->json(['success' => true, 'message' => 'Thank you! Your enquiry has been submitted. Our team will contact you shortly.']);
        } catch (\Throwable $e) {
            return (new Response())->json(['success' => false, 'message' => 'Database error recording enquiry: ' . $e->getMessage()], 500);
        }
    }

    public function subscribeNewsletter(Request $request): Response
    {
        $email = trim((string) $request->post('email'));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return (new Response())->json(['success' => false, 'message' => 'Please provide a valid email address.'], 422);
        }

        try {
            $existing = Database::fetchOne("SELECT id FROM newsletter_subscribers WHERE email = :email LIMIT 1", ['email' => $email]);
            if ($existing) {
                return (new Response())->json(['success' => true, 'message' => 'You are already subscribed to our newsletter!']);
            }

            Database::query(
                "INSERT INTO newsletter_subscribers (email, is_subscribed, subscribed_at) VALUES (:email, 1, NOW())",
                ['email' => $email]
            );
            return (new Response())->json(['success' => true, 'message' => 'Successfully subscribed to academy updates!']);
        } catch (\Throwable $e) {
            return (new Response())->json(['success' => false, 'message' => 'Failed to subscribe: ' . $e->getMessage()], 500);
        }
    }

    public function sitemapXml(Request $request): Response
    {
        $baseUrl = SeoService::getBaseUrl();

        $routes = [
            '/' => ['freq' => 'weekly', 'prio' => '1.0'],
            '/about' => ['freq' => 'monthly', 'prio' => '0.8'],
            '/gallery' => ['freq' => 'weekly', 'prio' => '0.8'],
            '/awards' => ['freq' => 'monthly', 'prio' => '0.8'],
            '/associations' => ['freq' => 'monthly', 'prio' => '0.7'],
            '/journey/national' => ['freq' => 'monthly', 'prio' => '0.7'],
            '/journey/international' => ['freq' => 'monthly', 'prio' => '0.7'],
            '/news/national' => ['freq' => 'weekly', 'prio' => '0.7'],
            '/news/international' => ['freq' => 'weekly', 'prio' => '0.7'],
            '/blogs' => ['freq' => 'weekly', 'prio' => '0.8'],
            '/contact' => ['freq' => 'monthly', 'prio' => '0.8'],
        ];

        // Fetch published blog slugs
        try {
            $blogs = Database::fetchAll("SELECT slug, updated_at FROM blog_posts WHERE status = 'PUBLISHED'");
        } catch (\Throwable $e) {
            $blogs = [];
        }

        // Fetch custom published pages
        try {
            $customPages = Database::fetchAll("SELECT slug, updated_at FROM pages WHERE is_published = 1 AND slug NOT IN ('home', 'about', 'award', 'gallery', 'contact', 'blog', 'journey-national', 'journey-international', 'news-national', 'news-international')");
        } catch (\Throwable $e) {
            $customPages = [];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($routes as $route => $meta) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $route, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <changefreq>{$meta['freq']}</changefreq>\n";
            $xml .= "    <priority>{$meta['prio']}</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($blogs as $b) {
            $date = date('Y-m-d', strtotime($b['updated_at'] ?? 'now'));
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/blogs/' . $b['slug'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$date}</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($customPages as $cp) {
            $date = date('Y-m-d', strtotime($cp['updated_at'] ?? 'now'));
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/page/' . $cp['slug'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$date}</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.6</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        $res = new Response();
        $res->header('Content-Type', 'application/xml; charset=utf-8');
        return $res->html($xml);
    }

    public function robotsTxt(Request $request): Response
    {
        $baseUrl = SeoService::getBaseUrl();
        $txt = "User-agent: *\n";
        $txt .= "Allow: /\n";
        $txt .= "Disallow: /admin\n";
        $txt .= "Disallow: /admin/\n";
        $txt .= "Disallow: /health\n";
        $txt .= "Disallow: /api/\n\n";
        $txt .= "Sitemap: {$baseUrl}/seo/sitemap.xml\n";

        $res = new Response();
        $res->header('Content-Type', 'text/plain; charset=utf-8');
        return $res->html($txt);
    }
}
