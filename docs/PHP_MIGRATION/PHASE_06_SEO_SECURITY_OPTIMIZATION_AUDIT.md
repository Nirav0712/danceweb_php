# PHASE 06 — SEO, SECURITY & PERFORMANCE OPTIMIZATION AUDIT
## Dynamic Children Academy — PHP Migration Architecture

**Date:** November 2026  
**Target Environment:** Hostinger Shared Hosting (Apache / LiteSpeed, PHP 8.2+, MySQL / MariaDB)  
**Project Path:** `F:\Dance Web\Dance Web\php-version\`

---

## 1. Executive Summary

This audit evaluates the current PHP implementation of the **Dynamic Children Academy** web platform across three critical pillars:
1. **Search Engine Optimization (SEO)**: On-page metadata, dynamic fallbacks, canonical consistency, XML sitemaps, robots directives, and Schema.org JSON-LD structured data.
2. **Application & Infrastructure Security**: Session configuration, CSRF enforcement, input validation, SQL injection prevention, XSS mitigation, secure media uploads, and HTTP security headers.
3. **Runtime Performance**: Database query efficiency, public content caching, cache invalidation on CMS updates, and asset loading optimizations.

---

## 2. Public Route-by-Route SEO Audit

| Route | Page Name | Current Title | Current Meta Description | Canonical URL Logic | CMS Page Record | Audit Status & Deficiencies |
|---|---|---|---|---|---|---|
| `/` | Homepage | Dynamic from `pages.meta_title` with fallback | Dynamic from `pages.meta_description` with fallback | `$_SERVER['REQUEST_URI']` (Includes query strings) | `home` (ID: 1) | **Needs Improvement:** Canonical tag retains query params (`?ref=...`). Missing Twitter cards, JSON-LD Organization schema. |
| `/about` | About Academy | Dynamic from `pages.meta_title` with fallback | Dynamic from `pages.meta_description` with fallback | `$_SERVER['REQUEST_URI']` | `about` (ID: 2) | **Needs Improvement:** Missing Breadcrumbs, missing founder/EducationalOrganization structured data. |
| `/gallery` | Photo Gallery | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `gallery` (ID: 9) | **Deficiency:** Hardcoded in controller instead of loading from `pages` table! Category filtering `?category=2` duplicates canonical. |
| `/awards` | Awards & Honors | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `award` (ID: 5) | **Deficiency:** Controller hardcodes SEO. Table record `award` is ignored. |
| `/award` | Legacy Award URL | Duplicate route serving awards | Duplicate route serving awards | `/award` | `award` (ID: 5) | **Deficiency:** Duplicate content! Must issue HTTP 301 Permanent Redirect to canonical `/awards`. |
| `/associations` | Affiliations | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | None | **Deficiency:** No dynamic SEO engine integration. |
| `/journey/national` | National Tours | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `journey-national` (ID: 3) | **Deficiency:** Ignores `pages` record `journey-national`. |
| `/journey/international` | World Tours | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `journey-international` (ID: 4) | **Deficiency:** Ignores `pages` record `journey-international`. |
| `/news/national` | National Press | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `news-national` (ID: 7) | **Deficiency:** Ignores `pages` record `news-national`. |
| `/news/international` | World Press | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `news-international` (ID: 8) | **Deficiency:** Ignores `pages` record `news-international`. |
| `/blogs` | Dance Stories | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `blog` (ID: 6) | **Deficiency:** Ignores `pages` record `blog`. |
| `/blog` | Legacy Blog URL | Duplicate route serving stories | Duplicate route serving stories | `/blog` | `blog` (ID: 6) | **Deficiency:** Duplicate content! Must issue HTTP 301 Permanent Redirect to canonical `/blogs`. |
| `/blogs/{slug}` | Story Detail | Dynamic from `blog_posts` | Dynamic from `blog_posts` | `$_SERVER['REQUEST_URI']` | Dynamic | **Needs Improvement:** Missing Article/BlogPosting JSON-LD, missing author bio, missing published/modified timestamps in schema. |
| `/contact` | Contact & Studios | Hardcoded in controller | Hardcoded in controller | `$_SERVER['REQUEST_URI']` | `contact` (ID: 10) | **Deficiency:** Ignores `pages` record `contact`. Missing LocalBusiness schema for Nikol & Bapunagar branches. |
| `/page/{slug}` | Custom CMS Pages | Not routed | Not routed | N/A | Variable | **Deficiency:** Missing public dynamic route for custom pages created in CMS. |

---

## 3. SEO Engine & Technical SEO Gaps

1. **Hierarchy of SEO Resolution:**
   - Priority 1: Specific CMS Page record (`pages` table where `slug = :slug`).
   - Priority 2: Entity-specific metadata (e.g. `blog_posts.meta_title`, `dance_forms.meta_title`).
   - Priority 3: Global Website Settings (`website_settings.site_name`, `website_settings.default_meta_description`).
   - Priority 4: Safe, branded hardcoded fallback.
   *Currently, controllers bypass Priority 1 and 3 on most listing pages.*

2. **Canonical URLs:**
   - Current template uses `$_SERVER['REQUEST_URI']` which causes duplicate content issues when URLs carry query strings (`?category=1`, `?page=2`, `?utm_source=...`).
   - Canonical URLs must resolve to the clean absolute URL using `APP_URL` + path (without trailing slash, except root `/`).

3. **OpenGraph & Twitter Card Metadata:**
   - `og:image` is currently hardcoded to `/assets/banners/home_hero.jpg` across all pages.
   - Missing Twitter Card tags (`twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`).
   - Missing `og:url` and `og:site_name`.

4. **Structured Data (Schema.org / JSON-LD):**
   - Zero JSON-LD tags currently exist in `public.php` layout.
   - Required Schemas:
     - `EducationalOrganization` / `DanceSchool`
     - `WebSite` with SearchAction
     - `BreadcrumbList` on subpages
     - `BlogPosting` / `Article` on `/blogs/{slug}`
     - `LocalBusiness` for Nikol and Bapunagar branch studios

5. **XML Sitemap & Robots.txt:**
   - Domain is hardcoded to `https://dynamicechildrenacademy.com` in `PublicController::sitemapXml()`. It must read from `APP_URL` or configuration.
   - Static routes lack `lastmod` timestamps.
   - Custom published CMS pages from `pages` table are omitted from sitemap.
   - Robots.txt should dynamically reference the full canonical sitemap URL and explicitly disallow private routes (`/admin`, `/health`, `/api/health`).

---

## 4. Security Audit Findings

1. **Session & Authentication:**
   - Session starts must enforce `cookie_httponly = 1`, `use_only_cookies = 1`, `cookie_samesite = 'Lax'`, and `cookie_secure` when on HTTPS.
   - Session lifetime and idle timeout must be enforced.
2. **CSRF Protection:**
   - Centralized CSRF validation implemented in `BaseAdminController`. Must ensure all API POST routes (`/api/enquiries`, `/api/newsletter/subscribe`) validate tokens or handle rate limiting.
3. **SVG Upload Security:**
   - `UploadService` allows `image/svg+xml`. Uploaded SVGs must be sanitized to strip `<script>`, `onload=`, `onerror=`, and embedded JavaScript to prevent stored XSS.
4. **Upload Directory Execution Prevention:**
   - An `.htaccess` in `public/uploads/` is required to disable PHP script execution (`php_flag engine off`, `SetHandler none`, blocking `.php`, `.phtml`, `.cgi`, etc.).
5. **Security Headers:**
   - Headers need to be declared in both `public/.htaccess` and programmatically via `Response::class` or global middleware:
     - `X-Content-Type-Options: nosniff`
     - `X-Frame-Options: SAMEORIGIN`
     - `Referrer-Policy: strict-origin-when-cross-origin`
     - `Permissions-Policy: geolocation=(), microphone=(), camera=()`
     - Compatible `Content-Security-Policy` allowing Google Fonts, Tailwind CDN, and YouTube/Google Maps embeds.

---

## 5. Performance & Database Optimization

1. **Public Content Caching:**
   - Public pages query categories, forms, awards, gallery, branches, and website settings repeatedly.
   - A lightweight, file-based/in-memory cache for public content (`ContentService`) will reduce database queries to 0 for static reads.
   - Automated cache invalidation on any admin CRUD action (`store`, `update`, `delete` in all admin controllers).
2. **Asset Optimization:**
   - Public images must feature `loading="lazy"` on below-the-fold content.
   - Explicit `alt` attributes must be added across all image tags in public views.
3. **Database Indexing:**
   - Verify indexes on `slug`, `is_published`, `status`, and `sort_order` across `pages`, `blog_posts`, `dance_categories`, and `gallery_items`.

---

## 6. Actionable Implementation Roadmap

1. **SEO Service (`app/Services/SeoService.php`)**:
   - Centralized metadata resolution with cascading priority.
   - Dynamic OpenGraph, Twitter Cards, Canonical URLs.
   - JSON-LD generators for Organization, WebSite, Breadcrumbs, Article, and LocalBusiness.
2. **Update Public Layout (`resources/views/layouts/public.php`)**:
   - Render dynamic SEO tags, social cards, and JSON-LD blocks.
3. **Enhance `PublicController` & Routes**:
   - Refactor all public methods to use `SeoService`.
   - Add 301 redirects for `/award` -> `/awards` and `/blog` -> `/blogs`.
   - Add `/page/{slug}` route for custom CMS pages.
   - Update `sitemapXml` with dynamic domain, `pages` inclusion, and valid ISO dates.
4. **Security Hardening**:
   - Harden `UploadService` with SVG script stripping.
   - Place `.htaccess` inside `public/uploads/` disabling script handlers.
   - Add session cookie security parameters in `Session::start()`.
   - Add Content Security Policy and security headers.
5. **Performance & Caching (`app/Services/CacheService.php`)**:
   - Implement file cache in `storage/cache/` with instant invalidation on CMS updates.
   - Add `loading="lazy"` and descriptive `alt` tags across all public templates.
6. **Automated Verification**:
   - Create `tests/seo-security-verification.php` testing SEO tags, JSON-LD validity, 301 redirects, upload protection, and cache invalidation.
