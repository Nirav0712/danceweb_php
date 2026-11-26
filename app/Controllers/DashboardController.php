<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Core\Database;

class DashboardController
{
    public function index(Request $request): Response
    {
        $user = AuthService::user();

        // Safe metric counts from existing database tables
        $metrics = [
            'pages' => 0,
            'gallery' => 0,
            'blogs' => 0,
            'news' => 0,
            'awards' => 0,
            'enquiries' => 0,
            'categories' => 0,
            'branches' => 0,
            'testimonials' => 0,
        ];
        $recentEnquiries = [];

        try {
            $metrics['pages'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM pages')['c'] ?? 0);
            $metrics['gallery'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM gallery_items')['c'] ?? 0);
            $metrics['blogs'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM blog_posts')['c'] ?? 0);
            $metrics['news'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM news_items')['c'] ?? 0);
            $metrics['awards'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM awards')['c'] ?? 0);
            $metrics['enquiries'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM enquiries')['c'] ?? 0);
            $metrics['categories'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM dance_categories')['c'] ?? 0);
            $metrics['branches'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM branches')['c'] ?? 0);
            $metrics['testimonials'] = (int) (Database::fetchOne('SELECT COUNT(*) as c FROM testimonials')['c'] ?? 0);

            $recentEnquiries = Database::fetchAll('SELECT * FROM enquiries ORDER BY id DESC LIMIT 5');
        } catch (\Throwable $e) {
            // Graceful fallback if database tables are in migration
        }

        return (new Response())->html(View::render('admin.dashboard', [
            'title' => 'Admin Dashboard — Dynamice Children Academy',
            'user' => $user,
            'metrics' => $metrics,
            'recentEnquiries' => $recentEnquiries,
        ]));
    }
}
