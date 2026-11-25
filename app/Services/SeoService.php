<?php

namespace App\Services;

use App\Core\Database;
use App\Core\Env;
use App\Core\Config;

class SeoService
{
    protected static ?array $cachedSettings = null;
    protected static ?array $cachedPages = null;

    /**
     * Get the canonical base URL
     */
    public static function getBaseUrl(): string
    {
        $appUrl = rtrim(Env::get('APP_URL', Config::get('app.url', 'https://dynamicechildrenacademy.com')), '/');
        // In local development, if needed, preserve or default to production domain for canonicals
        if (empty($appUrl) || str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1')) {
            return 'https://dynamicechildrenacademy.com';
        }
        return $appUrl;
    }

    /**
     * Resolve SEO metadata following the 4-tier priority:
     * 1. Manual CMS / Controller SEO override ($overrides)
     * 2. Existing saved SEO metadata in database (`pages` table)
     * 3. Dynamic SEO template based on entity / route
     * 4. Safe site-wide fallback
     */
    public static function resolve(string $slugOrRoute, array $overrides = []): array
    {
        $baseUrl = static::getBaseUrl();
        $settings = static::getSettings();
        $siteName = $settings['site_name'] ?? 'Dynamice Children Academy';
        $defaultDesc = 'Dynamice Children Academy is a premier cultural dance institution in Ahmedabad, Gujarat, specializing in authentic Indian folk, classical, and contemporary dance arts since 1998.';
        $defaultImage = $baseUrl . '/assets/banners/home_hero.jpg';

        // Clean path for canonical URL (strip query parameters and trailing slashes)
        $cleanPath = '/' . ltrim(explode('?', $slugOrRoute)[0], '/');
        if ($cleanPath !== '/' && str_ends_with($cleanPath, '/')) {
            $cleanPath = rtrim($cleanPath, '/');
        }
        $canonicalUrl = $baseUrl . ($cleanPath === '/' ? '' : $cleanPath);

        // Fetch page record from database if applicable
        $slug = trim($cleanPath, '/');
        if (empty($slug)) {
            $slug = 'home';
        }
        // Normalize known routes to page slugs
        $slugMap = [
            'home' => 'home',
            'about' => 'about',
            'gallery' => 'gallery',
            'awards' => 'award',
            'award' => 'award',
            'associations' => 'associations',
            'journey/national' => 'journey-national',
            'journey/international' => 'journey-international',
            'news/national' => 'news-national',
            'news/international' => 'news-international',
            'blogs' => 'blog',
            'blog' => 'blog',
            'contact' => 'contact',
        ];
        $mappedSlug = $slugMap[$slug] ?? $slug;
        $pageRecord = static::getPageBySlug($mappedSlug);

        // Tier 1 & 2 & 3: Title
        if (!empty($overrides['metaTitle'])) {
            $metaTitle = $overrides['metaTitle'];
        } elseif (!empty($overrides['title'])) {
            $metaTitle = $overrides['title'];
        } elseif (!empty($pageRecord['meta_title'])) {
            $metaTitle = $pageRecord['meta_title'];
        } elseif (!empty($pageRecord['title'])) {
            $metaTitle = "{$pageRecord['title']} — {$siteName}";
        } else {
            $metaTitle = "{$siteName} — Premier Dance Institute Gujarat";
        }

        // Full browser title
        $title = $overrides['title'] ?? ($pageRecord['title'] ?? $metaTitle);
        if (!str_contains($title, $siteName) && $cleanPath !== '/') {
            $title = "{$title} — {$siteName}";
        }

        // Tier 1 & 2 & 3: Meta Description
        if (!empty($overrides['metaDescription'])) {
            $metaDescription = $overrides['metaDescription'];
        } elseif (!empty($pageRecord['meta_description'])) {
            $metaDescription = $pageRecord['meta_description'];
        } else {
            $metaDescription = $defaultDesc;
        }

        // Tier 1 & 2 & 3: Meta Robots
        $metaRobots = $overrides['metaRobots'] ?? ($pageRecord && empty($pageRecord['is_published']) ? 'noindex, nofollow' : 'index, follow');

        // OpenGraph Image
        $ogImage = $overrides['ogImage'] ?? $overrides['image'] ?? ($pageRecord['banner_image_url'] ?? $defaultImage);
        if (!empty($ogImage) && !str_starts_with($ogImage, 'http://') && !str_starts_with($ogImage, 'https://')) {
            $ogImage = $baseUrl . '/' . ltrim($ogImage, '/');
        }

        // OpenGraph & Twitter
        $ogTitle = $overrides['ogTitle'] ?? $metaTitle;
        $ogDescription = $overrides['ogDescription'] ?? $metaDescription;
        $ogType = $overrides['ogType'] ?? ($cleanPath === '/' ? 'website' : 'article');
        $twitterCard = $overrides['twitterCard'] ?? 'summary_large_image';

        // Breadcrumbs
        $breadcrumbs = static::buildBreadcrumbs($cleanPath, $title, $overrides['breadcrumbs'] ?? []);

        // Structured Data JSON-LD
        $schemas = static::generateSchemas($cleanPath, [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'canonicalUrl' => $canonicalUrl,
            'ogImage' => $ogImage,
            'breadcrumbs' => $breadcrumbs,
            'article' => $overrides['article'] ?? null,
        ]);

        return [
            'title' => $title,
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'canonicalUrl' => $canonicalUrl,
            'metaRobots' => $metaRobots,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription,
            'ogImage' => $ogImage,
            'ogUrl' => $canonicalUrl,
            'ogType' => $ogType,
            'siteName' => $siteName,
            'twitterCard' => $twitterCard,
            'breadcrumbs' => $breadcrumbs,
            'schemas' => $schemas,
            'jsonLdHtml' => static::renderJsonLd($schemas),
            'googleSiteVerification' => $settings['google_site_verification'] ?? null,
            'googleAnalyticsId' => $settings['google_analytics_id'] ?? null,
        ];
    }

    /**
     * Build breadcrumbs array
     */
    protected static function buildBreadcrumbs(string $cleanPath, string $pageTitle, array $custom = []): array
    {
        $baseUrl = static::getBaseUrl();
        $crumbs = [
            ['name' => 'Home', 'url' => $baseUrl . '/']
        ];

        if ($cleanPath === '/') {
            return $crumbs;
        }

        if (!empty($custom)) {
            foreach ($custom as $c) {
                $crumbs[] = [
                    'name' => $c['name'],
                    'url' => str_starts_with($c['url'], 'http') ? $c['url'] : $baseUrl . '/' . ltrim($c['url'], '/')
                ];
            }
            return $crumbs;
        }

        $segments = array_filter(explode('/', trim($cleanPath, '/')));
        $accumulated = '';
        foreach ($segments as $index => $seg) {
            $accumulated .= '/' . $seg;
            $isLast = ($index === count($segments) - 1);
            $crumbs[] = [
                'name' => $isLast ? $pageTitle : ucwords(str_replace(['-', '_'], ' ', $seg)),
                'url' => $baseUrl . $accumulated
            ];
        }

        return $crumbs;
    }

    /**
     * Generate Schema.org JSON-LD structured data
     */
    public static function generateSchemas(string $cleanPath, array $context): array
    {
        $baseUrl = static::getBaseUrl();
        $settings = static::getSettings();
        $siteName = $settings['site_name'] ?? 'Dynamice Children Academy';
        $schemas = [];

        // 1. Organization / DanceSchool Schema (included on all public pages)
        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => ['EducationalOrganization', 'DanceGroup'],
            '@id' => $baseUrl . '/#organization',
            'name' => $siteName,
            'url' => $baseUrl . '/',
            'logo' => $baseUrl . '/logodance.png',
            'image' => $context['ogImage'] ?? ($baseUrl . '/assets/banners/home_hero.jpg'),
            'description' => 'Premier cultural dance institution in Ahmedabad, Gujarat, training children in folk, classical, and contemporary performing arts since 1998.',
            'foundingDate' => '1998',
            'founder' => [
                '@type' => 'Person',
                'name' => $settings['director_name'] ?? 'Shri Tirthraj Trivedi',
                'jobTitle' => 'Founder & Artistic Director'
            ],
            'telephone' => $settings['primary_phone'] ?? '+91 91738 78750',
            'email' => $settings['official_email'] ?? 'dynamicechildrenacademy@gmail.com',
            'sameAs' => array_filter([
                $settings['instagram_url'] ?? 'https://www.instagram.com/dynamice_academy/',
                $settings['youtube_url'] ?? 'https://www.youtube.com/@dynamicechildrenacademy617'
            ]),
        ];
        $schemas[] = $orgSchema;

        // 2. WebSite Schema (Homepage)
        if ($cleanPath === '/') {
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => $baseUrl . '/#website',
                'url' => $baseUrl . '/',
                'name' => $siteName,
                'description' => $context['description'],
                'publisher' => ['@id' => $baseUrl . '/#organization'],
                'inLanguage' => 'en-IN'
            ];
        }

        // 3. BreadcrumbList Schema (Subpages)
        if ($cleanPath !== '/' && !empty($context['breadcrumbs'])) {
            $items = [];
            foreach ($context['breadcrumbs'] as $idx => $crumb) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $idx + 1,
                    'name' => $crumb['name'],
                    'item' => $crumb['url']
                ];
            }
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $items
            ];
        }

        // 4. Article / BlogPosting Schema (Blog Detail)
        if (!empty($context['article'])) {
            $art = $context['article'];
            $articleImage = $art['featured_image_url'] ?? $context['ogImage'];
            if (!empty($articleImage) && !str_starts_with($articleImage, 'http')) {
                $articleImage = $baseUrl . '/' . ltrim($articleImage, '/');
            }

            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $context['canonicalUrl']
                ],
                'headline' => $art['title'] ?? $context['title'],
                'description' => $art['excerpt'] ?? $context['description'],
                'image' => $articleImage,
                'datePublished' => !empty($art['published_at']) ? date('c', strtotime($art['published_at'])) : date('c'),
                'dateModified' => !empty($art['updated_at']) ? date('c', strtotime($art['updated_at'])) : date('c'),
                'author' => [
                    '@type' => 'Person',
                    'name' => $art['author_name'] ?? 'Dynamice Children Academy'
                ],
                'publisher' => ['@id' => $baseUrl . '/#organization']
            ];
        }

        // 5. LocalBusiness Schema for Branches (Contact page)
        if ($cleanPath === '/contact') {
            try {
                $branches = Database::fetchAll("SELECT * FROM branches WHERE is_active = 1 ORDER BY sort_order ASC");
                foreach ($branches as $branch) {
                    $schemas[] = [
                        '@context' => 'https://schema.org',
                        '@type' => 'DanceSchool',
                        'name' => "{$siteName} — {$branch['branch_name']}",
                        'url' => $baseUrl . '/contact',
                        'telephone' => $branch['phone_primary'] ?? ($settings['primary_phone'] ?? '+91 91738 78750'),
                        'address' => [
                            '@type' => 'PostalAddress',
                            'streetAddress' => trim(($branch['address_line_1'] ?? '') . ' ' . ($branch['address_line_2'] ?? '')),
                            'addressLocality' => $branch['city'] ?? 'Ahmedabad',
                            'addressRegion' => $branch['state'] ?? 'Gujarat',
                            'addressCountry' => 'IN'
                        ]
                    ];
                }
            } catch (\Throwable $e) {
                // Graceful fallback
            }
        }

        return $schemas;
    }

    /**
     * Render JSON-LD scripts
     */
    public static function renderJsonLd(array $schemas): string
    {
        if (empty($schemas)) {
            return '';
        }

        $html = '';
        foreach ($schemas as $schema) {
            $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $html .= '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>' . "\n";
        }
        return $html;
    }

    /**
     * Get single page record by slug
     */
    protected static function getPageBySlug(string $slug): ?array
    {
        if (static::$cachedPages === null) {
            try {
                $rows = Database::fetchAll("SELECT * FROM pages");
                static::$cachedPages = [];
                foreach ($rows as $r) {
                    static::$cachedPages[$r['slug']] = $r;
                }
            } catch (\Throwable $e) {
                static::$cachedPages = [];
            }
        }
        return static::$cachedPages[$slug] ?? null;
    }

    /**
     * Get website settings
     */
    protected static function getSettings(): array
    {
        if (static::$cachedSettings === null) {
            try {
                $rows = Database::fetchAll("SELECT setting_key, setting_value FROM website_settings");
                static::$cachedSettings = [];
                foreach ($rows as $r) {
                    static::$cachedSettings[$r['setting_key']] = $r['setting_value'];
                }
            } catch (\Throwable $e) {
                static::$cachedSettings = [];
            }
        }
        return static::$cachedSettings;
    }

    /**
     * Invalidate runtime caches
     */
    public static function clearCache(): void
    {
        static::$cachedSettings = null;
        static::$cachedPages = null;
    }
}
