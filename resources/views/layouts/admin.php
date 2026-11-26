<?php
$userRole = $user['role'] ?? 'EDITOR';
$userName = $user['full_name'] ?? 'Admin User';
$userEmail = $user['email'] ?? '';
$initial = strtoupper(substr($userName, 0, 1));

// RBAC Navigation items mapping
$navSections = [
    'Overview' => [
        ['label' => 'Dashboard', 'url' => '/admin', 'icon' => 'layout-dashboard', 'permission' => 'dashboard:view'],
    ],
    'Homepage Hero' => [
        ['label' => 'Hero Banner & Heading', 'url' => '/admin/hero', 'icon' => 'sparkles', 'permission' => 'sections:manage'],
    ],
    'Content & Pages' => [
        ['label' => 'About Us Page', 'url' => '/admin/about', 'icon' => 'file-text', 'permission' => 'pages:view'],
        ['label' => 'Website Pages', 'url' => '/admin/pages', 'icon' => 'file-text', 'permission' => 'pages:view'],
        ['label' => 'Page Sections', 'url' => '/admin/sections', 'icon' => 'layers', 'permission' => 'sections:manage'],
        ['label' => 'Navigation Menus', 'url' => '/admin/navigation', 'icon' => 'menu', 'permission' => 'menus:manage'],
        ['label' => 'Media Library', 'url' => '/admin/media', 'icon' => 'image', 'permission' => 'media:view'],
    ],
    'Gallery & Records' => [
        ['label' => 'Photo Gallery', 'url' => '/admin/gallery', 'icon' => 'image', 'permission' => 'gallery:view'],
        ['label' => 'Awards & Records', 'url' => '/admin/awards', 'icon' => 'award', 'permission' => 'awards:manage'],
        ['label' => 'Affiliations', 'url' => '/admin/associations', 'icon' => 'heart-handshake', 'permission' => 'associations:manage'],
    ],
    'Tours & Media Press' => [
        ['label' => 'Tour Flags Slider', 'url' => '/admin/tour-flags', 'icon' => 'flag', 'permission' => 'journey:manage'],
        ['label' => 'National Journey', 'url' => '/admin/journey/national', 'icon' => 'globe', 'permission' => 'journey:manage'],
        ['label' => 'International Journey', 'url' => '/admin/journey/international', 'icon' => 'globe', 'permission' => 'journey:manage'],
        ['label' => 'National News', 'url' => '/admin/news/national', 'icon' => 'newspaper', 'permission' => 'news:manage'],
        ['label' => 'International News', 'url' => '/admin/news/international', 'icon' => 'newspaper', 'permission' => 'news:manage'],
        ['label' => 'Dance Stories (Blog)', 'url' => '/admin/blogs', 'icon' => 'book-open', 'permission' => 'blogs:manage'],
    ],
    'Audience & CRM' => [
        ['label' => 'Enquiries & Leads', 'url' => '/admin/enquiries', 'icon' => 'message-square', 'permission' => 'enquiries:view'],
        ['label' => 'Newsletter Subscribers', 'url' => '/admin/newsletter', 'icon' => 'mail', 'permission' => 'newsletter:manage'],
        ['label' => 'Testimonials', 'url' => '/admin/testimonials', 'icon' => 'shield-check', 'permission' => 'testimonials:manage'],
    ],
    'Operations & Settings' => [
        ['label' => 'Campuses / Branches', 'url' => '/admin/branches', 'icon' => 'building', 'permission' => 'branches:manage'],
        ['label' => 'Academy Settings', 'url' => '/admin/settings', 'icon' => 'settings', 'permission' => 'settings:manage'],
    ],
    'System Access' => [
        ['label' => 'Staff Management', 'url' => '/admin/users', 'icon' => 'users', 'superAdminOnly' => true],
        ['label' => 'Audit Activity Logs', 'url' => '/admin/audit-logs', 'icon' => 'history', 'permission' => 'audit_logs:view'],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Console', ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row">

    <!-- Mobile Header -->
    <div class="lg:hidden h-16 bg-white border-b border-slate-200/80 px-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">D</div>
            <span class="font-bold text-slate-900 text-sm">Dynamice CMS</span>
        </div>
        <button id="mobileMenuBtn" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200/90 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shadow-sm">
        <!-- Brand Header -->
        <div class="h-16 px-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-xs">D</div>
                <div>
                    <span class="font-bold text-slate-900 text-sm leading-tight block">Dynamice CMS</span>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-indigo-600 block">PHP Architecture</span>
                </div>
            </div>
            <button id="closeSidebarBtn" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 lg:hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-6 text-xs">
            <?php foreach ($navSections as $sectionTitle => $items): ?>
                <?php
                // Filter items by RBAC
                $visibleItems = array_filter($items, function($item) use ($userRole) {
                    if (!empty($item['superAdminOnly'])) {
                        return $userRole === 'SUPER_ADMIN';
                    }
                    if (!empty($item['permission'])) {
                        return \App\Services\Permissions::can($userRole, $item['permission']);
                    }
                    return true;
                });
                if (empty($visibleItems)) continue;
                ?>
                <div>
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        <?= htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="space-y-0.5">
                        <?php foreach ($visibleItems as $item): ?>
                            <?php $isActive = ($_SERVER['REQUEST_URI'] ?? '') === $item['url']; ?>
                            <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"
                               class="flex items-center gap-3 px-3 py-2 rounded-xl font-medium transition-all <?= $isActive ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $isActive ? 'bg-indigo-600' : 'bg-transparent' ?>"></span>
                                <span class="truncate"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </nav>

        <!-- User Profile Card -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="overflow-hidden">
                        <span class="text-xs font-semibold text-slate-800 block truncate"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-[10px] font-medium text-slate-400 block"><?= htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
                <form action="/admin/logout" method="POST" class="inline">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <button type="submit" title="Sign Out" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top App Bar -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-6 hidden lg:flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span>Dynamice Console</span>
                <span>/</span>
                <span class="text-slate-800 font-semibold"><?= htmlspecialchars($title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    MySQL Active
                </span>
                <span class="text-xs font-medium text-slate-500"><?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        </header>

        <!-- Content Body -->
        <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- Mobile Backdrop -->
    <div id="mobileBackdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const backdrop = document.getElementById('mobileBackdrop');

        function toggleSidebar(open) {
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        mobileMenuBtn?.addEventListener('click', () => toggleSidebar(true));
        closeSidebarBtn?.addEventListener('click', () => toggleSidebar(false));
        backdrop?.addEventListener('click', () => toggleSidebar(false));
    </script>
</body>
</html>
