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

        // 3. Fetch awards (CMS-managed with fallback to authentic awards archive)
        try {
            $awards = Database::fetchAll("SELECT * FROM awards WHERE is_featured = 1 ORDER BY sort_order ASC, year DESC, id ASC");
            if (empty($awards) || count($awards) < 4) {
                $awards = Database::fetchAll("SELECT * FROM awards ORDER BY sort_order ASC, year DESC, id ASC");
            }
        } catch (\Throwable $e) {
            $awards = [];
        }

        if (empty($awards)) {
            $awards = [
                [
                    'id' => 1,
                    'title' => 'London Book of World Records Certificate',
                    'issuer' => 'London Book of World Records',
                    'year' => 2023,
                    'description' => 'Inscribed for historic mass child classical dance recital and world-class choreography synchronization.',
                    'certificate_image_url' => '/assets/awards/01.jpg',
                    'is_record_book' => 1,
                    'is_featured' => 1,
                    'sort_order' => 1,
                ],
                [
                    'id' => 2,
                    'title' => 'World Records India Recognition',
                    'issuer' => 'World Records India',
                    'year' => 2022,
                    'description' => 'Official national record for traditional Gujarati folk preservation and youth cultural heritage performance.',
                    'certificate_image_url' => '/assets/awards/02.jpg',
                    'is_record_book' => 1,
                    'is_featured' => 1,
                    'sort_order' => 2,
                ],
                [
                    'id' => 3,
                    'title' => 'Golden Book of World Records Honor',
                    'issuer' => 'Golden Book of World Records',
                    'year' => 2021,
                    'description' => 'World record certification recognizing over 5,000 children trained in authentic classical traditions.',
                    'certificate_image_url' => '/assets/awards/03.jpg',
                    'is_record_book' => 1,
                    'is_featured' => 1,
                    'sort_order' => 3,
                ],
                [
                    'id' => 4,
                    'title' => 'National Cultural Heritage Excellence Award',
                    'issuer' => 'Indian Cultural Association Partner',
                    'year' => 2019,
                    'description' => 'Conferred for outstanding dedication to grassroots performing arts pedagogy and national festivals.',
                    'certificate_image_url' => '/assets/awards/04.jpg',
                    'is_record_book' => 0,
                    'is_featured' => 1,
                    'sort_order' => 4,
                ],
                [
                    'id' => 5,
                    'title' => 'National Youth Performing Arts Citation',
                    'issuer' => 'All India Performing Arts Council',
                    'year' => 2023,
                    'description' => 'Distinguished honor celebrating excellence in multi-genre youth recitals and stage discipline.',
                    'certificate_image_url' => '/assets/awards/05.jpg',
                    'is_record_book' => 0,
                    'is_featured' => 1,
                    'sort_order' => 5,
                ],
                [
                    'id' => 6,
                    'title' => 'Rashtriya Sanskritik Kala Samman',
                    'issuer' => 'All India Performing Arts Council',
                    'year' => 2020,
                    'description' => 'Recognized for pioneering traditional Garba, Dandiya, and Bhavai stage productions across India.',
                    'certificate_image_url' => '/assets/awards/06.jpg',
                    'is_record_book' => 0,
                    'is_featured' => 1,
                    'sort_order' => 6,
                ],
                [
                    'id' => 7,
                    'title' => 'International Cultural Ambassador Trophy',
                    'issuer' => 'Global Folklore Exchange Forum',
                    'year' => 2019,
                    'description' => 'Awarded during Europe tour across France, Spain, and Switzerland representing Indian heritage.',
                    'certificate_image_url' => '/assets/awards/07.jpg',
                    'is_record_book' => 0,
                    'is_featured' => 1,
                    'sort_order' => 7,
                ],
                [
                    'id' => 8,
                    'title' => 'Excellence in Classical Dance Pedagogy',
                    'issuer' => 'Gujarat State Sangeet Natak Akademi Partner',
                    'year' => 2018,
                    'description' => 'Recognized for 20+ years of nurturing young artistic talent and ethical stage poise.',
                    'certificate_image_url' => '/assets/awards/08.jpg',
                    'is_record_book' => 0,
                    'is_featured' => 1,
                    'sort_order' => 8,
                ],
            ];
        }

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
        $tourFlags = Database::fetchAll("SELECT * FROM tour_flags WHERE is_active = 1 ORDER BY sort_order ASC, year DESC");

        // 6. Fetch testimonials (3x2 6-card showcase matching SS 1 reference)
        try {
            $testimonials = Database::fetchAll("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC, id ASC LIMIT 6");
            if (empty($testimonials) || count($testimonials) < 6) {
                $testimonials = Database::fetchAll("SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC LIMIT 6");
            }
        } catch (\Throwable $e) {
            $testimonials = [];
        }

        // 7. Fetch sections and index by section_key
        $rawSections = Database::fetchAll("SELECT * FROM sections WHERE is_visible = 1 AND page_id = (SELECT id FROM pages WHERE slug = 'home' LIMIT 1) ORDER BY sort_order ASC");
        $sections = [];
        foreach ($rawSections as $sec) {
            $sections[$sec['section_key']] = $sec;
        }

        $page = Database::fetchOne("SELECT * FROM pages WHERE slug = 'home' LIMIT 1");
        $settings = ContentService::getSettings();

        // 8. Fetch disciplines / services curriculum data (CMS-integrated with exact visual showcase fallbacks)
        $disciplines = [
            'service' => [
                'id' => 'service',
                'tabLabel' => 'SERVICE',
                'title' => $sections['curriculum_service']['heading'] ?? 'Service',
                'pillColor' => 'bg-rose-500 text-white hover:bg-rose-600',
                'activeBg' => 'from-rose-600 via-red-600 to-pink-600',
                'image' => $sections['curriculum_service']['image_url'] ?? '/assets/homepage/services/service.jpg',
                'paragraphs' => [
                    'We provide professional dance services for events, programs, and training, tailored to match the theme, audience, and occasion. Our services combine creativity, discipline, and performance excellence to deliver memorable experiences.',
                ],
                'subItemsHeader' => 'Service Offerings & Specializations',
                'subItems' => [
                    ['name' => 'Event Choreography', 'detail' => 'Tailored dance choreography for annual days, festivals & private events.', 'image' => '/assets/gallery/1.jpg'],
                    ['name' => 'School & College Programs', 'detail' => 'Structured institutional dance curriculums and group training.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Wedding & Celebration Dance', 'detail' => 'Theme-based family performance choreography and sangeet routines.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Stage Production & Lighting', 'detail' => 'Professional lighting, theatrical props and stagecraft coordination.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Competition Training', 'detail' => 'Elite coaching for state, national & international championships.', 'image' => '/assets/gallery/5.jpg'],
                    ['name' => 'Orientation Workshops', 'detail' => 'Beginner sessions to introduce young dancers to rhythm and movement.', 'image' => '/assets/gallery/6.jpg'],
                ],
            ],
            'dance' => [
                'id' => 'dance',
                'tabLabel' => 'DANCE',
                'title' => $sections['curriculum_dance']['heading'] ?? 'Dance',
                'pillColor' => 'bg-lime-500 text-white hover:bg-lime-600',
                'activeBg' => 'from-lime-500 via-emerald-500 to-teal-500',
                'image' => $sections['curriculum_dance']['image_url'] ?? '/assets/homepage/services/dance.jpg',
                'paragraphs' => [
                    'At our academy, we inspire children aged 4 to 14 years to discover the joy of movement through a warm, friendly, and encouraging environment. Our teaching style is simple, engaging, and child-friendly, making every session fun, comfortable, and easy to follow—even for complete beginners.',
                    'We offer a wide variety of dance genres to help young dancers explore their unique style and creativity. From Bollywood, Hip-Hop, Contemporary, Folk, Classical, Garba, and Semi-Classical to fun freestyle sessions, our curriculum ensures every child gets the chance to learn something new and exciting. Each class is designed to boost confidence, flexibility, discipline, and self-expression.',
                    'Our instructors understand the needs of each age group and use interactive techniques, storytelling, and step-by-step guidance so children learn effortlessly while enjoying every moment. Along with technique, we focus on teamwork, positivity, and building a strong foundation in rhythm and coordination.',
                    'Join us and let your child explore the world of dance in a safe, happy, and creative space.',
                ],
                'subItemsHeader' => 'Dance Disciplines — 1 Featured Stage Image for Each Form',
                'subItems' => [
                    ['name' => 'Bollywood', 'detail' => 'High-energy cinematic expressions, footwork & storytelling choreography.', 'image' => '/assets/gallery/1.jpg'],
                    ['name' => 'Folk Dance', 'detail' => 'Authentic Gujarati Garba, energetic Dandiya Raas & heritage Bhavai traditions.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Contemporary', 'detail' => 'Fluid emotional interpretation, ballet posture & modern floorwork grace.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Western', 'detail' => 'Urban Hip-Hop grooves, street locking, popping & modern rhythm agility.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Patriotic', 'detail' => 'Grand thematic mass formations honoring national heritage & cultural unity.', 'image' => '/assets/gallery/5.jpg'],
                    ['name' => 'Religious', 'detail' => 'Classical invocations, Nataraja vandana, devotional stutis & sacred mudras.', 'image' => '/assets/gallery/6.jpg'],
                ],
            ],
            'gymnastics' => [
                'id' => 'gymnastics',
                'tabLabel' => 'GYMNASTICS',
                'title' => $sections['curriculum_gymnastics']['heading'] ?? 'Gymnastics',
                'pillColor' => 'bg-amber-500 text-white hover:bg-amber-600',
                'activeBg' => 'from-amber-500 via-orange-500 to-yellow-500',
                'image' => $sections['curriculum_gymnastics']['image_url'] ?? '/assets/homepage/services/gymnastics.jpg',
                'paragraphs' => [
                    'At our academy, we provide a joyful, energetic, and supportive environment for children aged 4 to 12 years to learn, grow, and thrive through gymnastics. Our friendly mentors follow an easy and engaging teaching style, ensuring that every child feels comfortable, confident, and excited to participate.',
                    'We offer training across various forms and genres of gymnastics, including basic tumbling, balance skills, flexibility training, rhythmic movements, coordination exercises, and beginner-level artistic gymnastics. Each session is structured to build a strong foundation while keeping learning playful and enjoyable.',
                    'Safety is our top priority. Our academy follows strict safety protocols, with well-trained instructors supervising every activity. We use well-maintained, high-quality equipment designed specifically for young learners, ensuring a secure and worry-free experience for parents and children alike.',
                    'Whether your child is just beginning or ready to advance, we focus on step-by-step training, motivating them to discover their potential with positivity and discipline.',
                    'Join us to give your child an exciting opportunity to develop strength, flexibility, confidence, and lifelong fitness habits—all in a safe, friendly, and inspiring space!',
                ],
                'subItemsHeader' => 'Gymnastics Modules & Core Training Focus',
                'subItems' => [
                    ['name' => 'Basic Tumbling', 'detail' => 'Safe forward rolls, backward tumbling & body balance drills on cushioned mats.', 'image' => '/assets/homepage/services/gymnastics.jpg'],
                    ['name' => 'Balance & Poise', 'detail' => 'Arm-stands, beam balancing & upright core stability routines.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Flexibility & Splits', 'detail' => 'Gentle spinal elongation, hamstring flexibility & full split progression.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Coordination Drills', 'detail' => 'Agility drills, quick-reflex jump sequences & rhythmic motor control.', 'image' => '/assets/gallery/5.jpg'],
                    ['name' => 'Artistic Gymnastics', 'detail' => 'Graceful aesthetic body lines, floor routine combinations & pose holds.', 'image' => '/assets/gallery/7.jpg'],
                    ['name' => 'Safety & Equipment', 'detail' => 'Supervised safety practices with high-density protective landing gear.', 'image' => '/assets/gallery/8.jpg'],
                ],
            ],
            'drama' => [
                'id' => 'drama',
                'tabLabel' => 'DRAMA SPEAKING',
                'title' => $sections['curriculum_drama']['heading'] ?? 'Drama & Speaking',
                'pillColor' => 'bg-sky-500 text-white hover:bg-sky-600',
                'activeBg' => 'from-sky-500 via-blue-500 to-indigo-500',
                'image' => $sections['curriculum_drama']['image_url'] ?? '/assets/homepage/services/drama.jpg',
                'paragraphs' => [
                    "At our Children's Academy, we specialize in Drama and Public Speaking for children aged 4 to 14 years, creating a warm, friendly, and encouraging environment where every child feels free to express themselves. Our programs are designed to nurture creativity, build confidence, and help young minds develop strong communication skills.",
                    'Through interactive sessions, children explore voice modulation, storytelling, dialogues, stage presence, and expressive movement. We believe learning should be engaging and practical, which is why our curriculum includes theatre visits, curated movie screenings, role-play activities, and hands-on performance workshops that bring real-world experiences into the classroom.',
                    'Adding to this enriching journey, we host celebrity guests, industry professionals, and field experts who conduct exclusive masterclasses—offering children rare exposure and inspiring guidance.',
                    'With expert mentors and a positive, child-friendly atmosphere, we aim to shape confident speakers, expressive performers, and thoughtful young individuals ready to shine on any stage.',
                    'Join us and let your child discover the power of expression.',
                ],
                'subItemsHeader' => 'Drama & Public Speaking Modules',
                'subItems' => [
                    ['name' => 'Voice Modulation', 'detail' => 'Pitch control, speech clarity, vocal projection & breath control.', 'image' => '/assets/homepage/services/drama.jpg'],
                    ['name' => 'Storytelling & Bhav', 'detail' => 'Expressive facial navarasas, character roleplay & dramatic mon
                    ologue.', 'image' => '/assets/gallery/1.jpg'],
                    ['name' => 'Stage Presence', 'detail' => 'Conquering stage fear, commanding posture & authentic audience connection.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Roleplay & Improv', 'detail' => 'Quick theatrical thinking, unscripted responses & emotional empathy.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Theatre Screenings', 'detail' => 'Observing theatrical staging, dialogue pacing & live production backstage.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Celebrity Masterclasses', 'detail' => 'Exclusive interaction with renowned theater artists & performing veterans.', 'image' => '/assets/gallery/5.jpg'],
                ],
            ],
            'modeling' => [
                'id' => 'modeling',
                'tabLabel' => 'MODELING',
                'title' => $sections['curriculum_modeling']['heading'] ?? 'Modeling',
                'pillColor' => 'bg-pink-500 text-white hover:bg-pink-600',
                'activeBg' => 'from-pink-500 via-fuchsia-500 to-rose-500',
                'image' => $sections['curriculum_modeling']['image_url'] ?? '/assets/homepage/services/modeling.jpg',
                'paragraphs' => [
                    'We create structured, child-friendly art experiences that model creativity, confidence, and self-expression. By providing thoughtfully curated materials and guided activities, we ensure children not only enjoy the process but also understand the concepts behind each creation. Our theme-based and seasonal art modules—ranging from festive décor to nature-inspired crafts—help children connect abstract ideas with real-world experiences.',
                ],
                'subItemsHeader' => 'Modeling & Runway Poise Modules',
                'subItems' => [
                    ['name' => 'Runway Walk & Gait', 'detail' => 'Spine alignment, measured graceful strides & confident eye contact.', 'image' => '/assets/homepage/services/modeling.jpg'],
                    ['name' => 'Camera Angle Poses', 'detail' => 'Mastering head tilts, smile authenticity & lens synchronization.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Traditional Attire Styling', 'detail' => 'Carrying heritage lehengas, dupattas & ethnic costumes with poise.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Spotlight Positioning', 'detail' => 'Stage mark awareness, lighting synchronization & pacing.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Self-Confidence & Poise', 'detail' => 'Building positive self-image, public poise & graceful demeanor.', 'image' => '/assets/gallery/5.jpg'],
                    ['name' => 'Fashion Pageant Prep', 'detail' => 'Talent show presentation, stage introductions & awards etiquette.', 'image' => '/assets/gallery/6.jpg'],
                ],
            ],
            'drawing' => [
                'id' => 'drawing',
                'tabLabel' => 'DRAWING',
                'title' => $sections['curriculum_drawing']['heading'] ?? 'Drawing',
                'pillColor' => 'bg-indigo-500 text-white hover:bg-indigo-600',
                'activeBg' => 'from-indigo-600 via-purple-600 to-violet-600',
                'image' => $sections['curriculum_drawing']['image_url'] ?? '/assets/homepage/services/drawing.jpg',
                'paragraphs' => [
                    'Our curriculum covers a wide range of art genres and techniques, including basic drawing, sketching, shading, color theory, character drawing, creative craftwork, and theme-based artwork. Each session is designed to strengthen creativity, focus, and fine motor skills while allowing children to express their individuality.',
                    'We provide well-maintained, safe, and high-quality art equipment, ensuring that every child enjoys a smooth and engaging learning experience. To keep creativity alive throughout the year, we offer seasonal and festival-based art activities—from making Diwali lanterns to Christmas ornaments and vibrant summer crafts. These hands-on projects help children learn about culture, nature, and real-world concepts through the joyful medium of art.',
                    'With dedicated guidance and a warm atmosphere, our academy helps children discover their artistic potential and build a love for creativity that lasts a lifetime.',
                ],
                'subItemsHeader' => 'Drawing & Fine Arts Modules',
                'subItems' => [
                    ['name' => 'Sketching & Lines', 'detail' => 'Basic line control, pencil grips, geometric forms & proportions.', 'image' => '/assets/homepage/services/drawing.jpg'],
                    ['name' => 'Shading & Textures', 'detail' => 'Light-to-dark shading, cross-hatching & volume representation.', 'image' => '/assets/gallery/1.jpg'],
                    ['name' => 'Color Theory & Painting', 'detail' => 'Harmonious palettes, acrylic mixing, watercolor washes & blends.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Character Art', 'detail' => 'Fun cartoons, anime figures & imaginative storytelling drawing.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Festival Crafts', 'detail' => 'Diwali lanterns, seasonal ornaments, rangoli crafts & paper folding.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Annual Art Exhibition', 'detail' => 'Curated showcase of student masterpieces for proud families & mentors.', 'image' => '/assets/gallery/5.jpg'],
                ],
            ],
            'spiritual' => [
                'id' => 'spiritual',
                'tabLabel' => 'SPIRITUAL',
                'title' => $sections['curriculum_spiritual']['heading'] ?? 'Spiritual',
                'pillColor' => 'bg-rose-500 text-white hover:bg-rose-600',
                'activeBg' => 'from-rose-600 via-red-600 to-purple-600',
                'image' => $sections['curriculum_spiritual']['image_url'] ?? '/assets/homepage/services/spiritual.jpg',
                'paragraphs' => [
                    "In today's fast-paced world, where western influences are rapidly shaping young lifestyles, our Children's Academy is committed to preserving the essence of Indian culture, spirituality, and tradition. Designed for children aged 4 to 14 years, our programs blend engaging learning with meaningful values that stay for life.",
                    'We introduce children to the richness of our heritage through interactive storytelling, soulful bhajans, cultural activities, and thought-provoking sessions that encourage mindfulness, kindness, and emotional awareness. Each class is crafted to help children understand the roots of our traditions while developing confidence, discipline, and a positive outlook.',
                    'Our approach is modern yet deeply connected to our cultural identity. Through creative formats—songs, stories, festivals, meditation, and value-based activities—we ensure that learning spirituality becomes joyful, relatable, and inspiring for every child.',
                    'At our academy, we believe that strong cultural grounding shapes strong individuals. By nurturing both intellect and inner values, we aim to guide children towards becoming compassionate, confident, and culturally aware citizens of tomorrow.',
                ],
                'subItemsHeader' => 'Spiritual Invocations & Cultural Heritage Modules',
                'subItems' => [
                    ['name' => 'Nataraja Vandana', 'detail' => 'Sacred invocation to the Lord of Cosmic Dance with disciplined pranam.', 'image' => '/assets/homepage/services/spiritual.jpg'],
                    ['name' => 'Sanskrit Slokas', 'detail' => 'Vedic chants, mantra recitation & cognitive memory concentration.', 'image' => '/assets/gallery/2.jpg'],
                    ['name' => 'Soulful Bhajans', 'detail' => 'Devotional melodies that instill inner peace, rhythm & humility.', 'image' => '/assets/gallery/3.jpg'],
                    ['name' => 'Classical Mudras', 'detail' => 'Sacred hand mudras conveying symbolic divine narratives and focus.', 'image' => '/assets/gallery/4.jpg'],
                    ['name' => 'Mindfulness & Meditation', 'detail' => 'Deep breathing, seated contemplation & positive emotional awareness.', 'image' => '/assets/gallery/5.jpg'],
                    ['name' => 'Cultural Values', 'detail' => 'Respect for gurus, elder blessings & ancient Indian moral wisdom.', 'image' => '/assets/gallery/6.jpg'],
                ],
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

        // Fetch all CMS sections for about page
        $rawSections = [];
        if ($page) {
            $rawSections = Database::fetchAll("SELECT * FROM sections WHERE page_id = :pid ORDER BY sort_order ASC", ['pid' => $page['id']]);
        }
        $sections = [];
        foreach ($rawSections as $sec) {
            $sections[$sec['section_key']] = $sec;
        }

        $seo = SeoService::resolve('/about', [
            'title' => $page['title'] ?? 'About Us — Dynamice Children Academy',
            'metaTitle' => $page['meta_title'] ?? 'About Academy & Founder Director Shri Tirthraj Trivedi',
            'metaDescription' => $page['meta_description'] ?? 'Learn about the legacy of Dynamice Children Academy, founded in 2002 to train generations of children in authentic Indian cultural dance.',
        ]);

        return (new Response())->html(View::render('public.about', [
            'seo' => $seo,
            'title' => $seo['title'],
            'metaTitle' => $seo['metaTitle'],
            'metaDescription' => $seo['metaDescription'],
            'canonicalUrl' => $seo['canonicalUrl'],
            'associations' => $associations,
            'page' => $page,
            'sections' => $sections,
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
