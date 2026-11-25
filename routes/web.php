<?php

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PublicController;
use App\Controllers\Admin\UsersController;
use App\Controllers\Admin\PagesController;
use App\Controllers\Admin\SectionsController;
use App\Controllers\Admin\MenusController;
use App\Controllers\Admin\MediaController;
use App\Controllers\Admin\DanceCategoriesController;
use App\Controllers\Admin\DanceFormsController;
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\AwardsController;
use App\Controllers\Admin\AssociationsController;
use App\Controllers\Admin\JourneyEventsController;
use App\Controllers\Admin\NewsItemsController;
use App\Controllers\Admin\BlogsController;
use App\Controllers\Admin\TestimonialsController;
use App\Controllers\Admin\EnquiriesController;
use App\Controllers\Admin\NewsletterController;
use App\Controllers\Admin\BranchesController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\Admin\AuditLogsController;
use App\Controllers\Admin\TourFlagsController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

/** @var Router $router */

// ==============================================================================
// 1. PUBLIC WEBSITE ROUTES
// ==============================================================================

$router->get('/', [PublicController::class, 'home']);
$router->get('/about', [PublicController::class, 'about']);
$router->get('/gallery', [PublicController::class, 'gallery']);
$router->get('/awards', [PublicController::class, 'awards']);
$router->get('/award', [PublicController::class, 'awards']); // Legacy synonym
$router->get('/associations', [PublicController::class, 'associations']);
$router->get('/journey/national', [PublicController::class, 'nationalJourney']);
$router->get('/journey/international', [PublicController::class, 'internationalJourney']);
$router->get('/news/national', [PublicController::class, 'nationalNews']);
$router->get('/news/international', [PublicController::class, 'internationalNews']);
$router->get('/blogs', [PublicController::class, 'blogs']);
$router->get('/blog', [PublicController::class, 'blogs']); // Legacy synonym
$router->get('/blogs/{slug}', [PublicController::class, 'blogDetail']);
$router->get('/contact', [PublicController::class, 'contact']);

// Public Lead / Action Endpoints
$router->post('/api/enquiries', [PublicController::class, 'submitEnquiry']);
$router->post('/api/newsletter/subscribe', [PublicController::class, 'subscribeNewsletter']);

// SEO & Crawlers
$router->get('/seo/sitemap.xml', [PublicController::class, 'sitemapXml']);
$router->get('/sitemap.xml', [PublicController::class, 'sitemapXml']);
$router->get('/robots.txt', [PublicController::class, 'robotsTxt']);

// System / Health Check
$router->get('/health', function () {
    $dbOk = \App\Core\Database::checkHealth();
    return [
        'status' => $dbOk ? 'UP' : 'DOWN',
        'database' => $dbOk ? 'connected' : 'disconnected',
        'php_version' => PHP_VERSION,
        'timestamp' => date('c'),
    ];
});

// ==============================================================================
// 2. ADMIN AUTHENTICATION
// ==============================================================================

$router->get('/admin/login', [AuthController::class, 'showLogin']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/logout', [AuthController::class, 'logout']);

$router->get('/admin/setup', [AuthController::class, 'showSetup']);
$router->post('/admin/setup', [AuthController::class, 'setup']);

// ==============================================================================
// 3. ADMIN CMS DASHBOARD & 21 MODULES
// ==============================================================================

$auth = new AuthMiddleware();
$superAdminOnly = new RoleMiddleware(['SUPER_ADMIN']);
$adminOrSuper = new RoleMiddleware(['SUPER_ADMIN', 'ADMIN']);
$editorAccess = new RoleMiddleware(['SUPER_ADMIN', 'ADMIN', 'EDITOR']);

// Overview / Dashboard
$router->get('/admin', [DashboardController::class, 'index'], [$auth]);
$router->get('/admin/dashboard', [DashboardController::class, 'index'], [$auth]);

// Module 01: Staff & RBAC (SUPER_ADMIN only)
$router->get('/admin/users', [UsersController::class, 'index'], [$auth, $superAdminOnly]);
$router->post('/admin/users', [UsersController::class, 'store'], [$auth, $superAdminOnly]);
$router->post('/admin/users/{id}/update', [UsersController::class, 'update'], [$auth, $superAdminOnly]);
$router->post('/admin/users/{id}/delete', [UsersController::class, 'delete'], [$auth, $superAdminOnly]);

// Module 02: Website Pages
$router->get('/admin/pages', [PagesController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/pages', [PagesController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/pages/{id}/update', [PagesController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/pages/{id}/delete', [PagesController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 03: Page Sections
$router->get('/admin/sections', [SectionsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/sections', [SectionsController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/sections/{id}/update', [SectionsController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/sections/{id}/delete', [SectionsController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 04: Navigation Menus
$router->get('/admin/navigation', [MenusController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/navigation', [MenusController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/navigation/{id}/update', [MenusController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/navigation/{id}/delete', [MenusController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 05: Media Library
$router->get('/admin/media', [MediaController::class, 'index'], [$auth, $editorAccess]);
$router->post('/admin/media/upload', [MediaController::class, 'upload'], [$auth, $editorAccess]);
$router->post('/admin/media/{id}/delete', [MediaController::class, 'delete'], [$auth, $editorAccess]);

// Module 06: Dance Categories
$router->get('/admin/dance-categories', [DanceCategoriesController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-categories', [DanceCategoriesController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-categories/{id}/update', [DanceCategoriesController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-categories/{id}/delete', [DanceCategoriesController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 07: Dance Forms
$router->get('/admin/dance-forms', [DanceFormsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-forms', [DanceFormsController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-forms/{id}/update', [DanceFormsController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/dance-forms/{id}/delete', [DanceFormsController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 08: Photo Gallery
$router->get('/admin/gallery', [GalleryController::class, 'index'], [$auth, $editorAccess]);
$router->post('/admin/gallery', [GalleryController::class, 'store'], [$auth, $editorAccess]);
$router->post('/admin/gallery/{id}/update', [GalleryController::class, 'update'], [$auth, $editorAccess]);
$router->post('/admin/gallery/{id}/delete', [GalleryController::class, 'delete'], [$auth, $editorAccess]);

// Module 09: Awards & Records
$router->get('/admin/awards', [AwardsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/awards', [AwardsController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/awards/{id}/update', [AwardsController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/awards/{id}/delete', [AwardsController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 10: Affiliations
$router->get('/admin/associations', [AssociationsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/associations', [AssociationsController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/associations/{id}/update', [AssociationsController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/associations/{id}/delete', [AssociationsController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 11: National Journey
$router->get('/admin/journey/national', function($req) {
    return (new JourneyEventsController('NATIONAL'))->index($req);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/national', function($req) {
    return (new JourneyEventsController('NATIONAL'))->store($req);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/national/{id}/update', function($req, $p) {
    return (new JourneyEventsController('NATIONAL'))->update($req, $p);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/national/{id}/delete', function($req, $p) {
    return (new JourneyEventsController('NATIONAL'))->delete($req, $p);
}, [$auth, $adminOrSuper]);

// Module 12: International Journey
$router->get('/admin/journey/international', function($req) {
    return (new JourneyEventsController('INTERNATIONAL'))->index($req);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/international', function($req) {
    return (new JourneyEventsController('INTERNATIONAL'))->store($req);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/international/{id}/update', function($req, $p) {
    return (new JourneyEventsController('INTERNATIONAL'))->update($req, $p);
}, [$auth, $adminOrSuper]);
$router->post('/admin/journey/international/{id}/delete', function($req, $p) {
    return (new JourneyEventsController('INTERNATIONAL'))->delete($req, $p);
}, [$auth, $adminOrSuper]);

// Module 13: National News
$router->get('/admin/news/national', function($req) {
    return (new NewsItemsController('NATIONAL'))->index($req);
}, [$auth, $editorAccess]);
$router->post('/admin/news/national', function($req) {
    return (new NewsItemsController('NATIONAL'))->store($req);
}, [$auth, $editorAccess]);
$router->post('/admin/news/national/{id}/update', function($req, $p) {
    return (new NewsItemsController('NATIONAL'))->update($req, $p);
}, [$auth, $editorAccess]);
$router->post('/admin/news/national/{id}/delete', function($req, $p) {
    return (new NewsItemsController('NATIONAL'))->delete($req, $p);
}, [$auth, $editorAccess]);

// Module 14: International News
$router->get('/admin/news/international', function($req) {
    return (new NewsItemsController('INTERNATIONAL'))->index($req);
}, [$auth, $editorAccess]);
$router->post('/admin/news/international', function($req) {
    return (new NewsItemsController('INTERNATIONAL'))->store($req);
}, [$auth, $editorAccess]);
$router->post('/admin/news/international/{id}/update', function($req, $p) {
    return (new NewsItemsController('INTERNATIONAL'))->update($req, $p);
}, [$auth, $editorAccess]);
$router->post('/admin/news/international/{id}/delete', function($req, $p) {
    return (new NewsItemsController('INTERNATIONAL'))->delete($req, $p);
}, [$auth, $editorAccess]);

// Module 15: Dance Stories (Blog)
$router->get('/admin/blogs', [BlogsController::class, 'index'], [$auth, $editorAccess]);
$router->post('/admin/blogs', [BlogsController::class, 'store'], [$auth, $editorAccess]);
$router->post('/admin/blogs/{id}/update', [BlogsController::class, 'update'], [$auth, $editorAccess]);
$router->post('/admin/blogs/{id}/delete', [BlogsController::class, 'delete'], [$auth, $editorAccess]);

// Module 16: Testimonials
$router->get('/admin/testimonials', [TestimonialsController::class, 'index'], [$auth, $editorAccess]);
$router->post('/admin/testimonials', [TestimonialsController::class, 'store'], [$auth, $editorAccess]);
$router->post('/admin/testimonials/{id}/update', [TestimonialsController::class, 'update'], [$auth, $editorAccess]);
$router->post('/admin/testimonials/{id}/delete', [TestimonialsController::class, 'delete'], [$auth, $editorAccess]);

// Module 17: Admission Enquiries CRM
$router->get('/admin/enquiries', [EnquiriesController::class, 'index'], [$auth, $adminOrSuper]);
$router->get('/admin/enquiries/export', [EnquiriesController::class, 'exportCsv'], [$auth, $adminOrSuper]);
$router->post('/admin/enquiries/{id}/status', [EnquiriesController::class, 'updateStatus'], [$auth, $adminOrSuper]);
$router->post('/admin/enquiries/{id}/delete', [EnquiriesController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 18: Newsletter Subscribers
$router->get('/admin/newsletter', [NewsletterController::class, 'index'], [$auth, $adminOrSuper]);
$router->get('/admin/newsletter/export', [NewsletterController::class, 'exportCsv'], [$auth, $adminOrSuper]);
$router->post('/admin/newsletter/{id}/toggle', [NewsletterController::class, 'toggle'], [$auth, $adminOrSuper]);
$router->post('/admin/newsletter/{id}/delete', [NewsletterController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 19: Campuses / Branches
$router->get('/admin/branches', [BranchesController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/branches', [BranchesController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/branches/{id}/update', [BranchesController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/branches/{id}/delete', [BranchesController::class, 'delete'], [$auth, $adminOrSuper]);

// Module 20: Settings & Global SEO
$router->get('/admin/settings', [SettingsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/settings', [SettingsController::class, 'update'], [$auth, $adminOrSuper]);

// Module 21: Audit Activity Logs
$router->get('/admin/audit-logs', [AuditLogsController::class, 'index'], [$auth, $adminOrSuper]);

// Supplemental Module: Tour Flags Carousel
$router->get('/admin/tour-flags', [TourFlagsController::class, 'index'], [$auth, $adminOrSuper]);
$router->post('/admin/tour-flags', [TourFlagsController::class, 'store'], [$auth, $adminOrSuper]);
$router->post('/admin/tour-flags/{id}/update', [TourFlagsController::class, 'update'], [$auth, $adminOrSuper]);
$router->post('/admin/tour-flags/{id}/delete', [TourFlagsController::class, 'delete'], [$auth, $adminOrSuper]);
