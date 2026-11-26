<?php
$userRole = $user['role'] ?? 'EDITOR';
$userName = $user['full_name'] ?? 'Admin User';
$userEmail = $user['email'] ?? '';
$initial = strtoupper(substr($userName, 0, 1));
$currentUri = explode('?', $_SERVER['REQUEST_URI'] ?? '/admin')[0];

// Clean, structured navigation matching exact website hierarchy
$navGroups = [
    'Main' => [
        [
            'label' => 'Dashboard Overview',
            'url' => '/admin',
            'publicUrl' => null,
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>',
            'badge' => null,
        ],
    ],
    'Homepage Sections (Top to Bottom)' => [
        [
            'label' => '1. Hero Banner & Slider',
            'url' => '/admin/hero',
            'publicUrl' => '/',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>',
            'desc' => 'Header slides, video, tagline',
        ],
        [
            'label' => '2. Dance Curriculum',
            'url' => '/admin/dance-categories',
            'publicUrl' => '/#curriculum',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>',
            'desc' => 'Kathak, Folk, Bollywood, Western',
        ],
        [
            'label' => '3. Tour Flags Carousel',
            'url' => '/admin/tour-flags',
            'publicUrl' => '/#tours',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>',
            'desc' => '15+ International nations & states',
        ],
        [
            'label' => '4. Awards Showcase',
            'url' => '/admin/awards',
            'publicUrl' => '/#awards',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>',
            'desc' => 'World records & accolades',
        ],
        [
            'label' => '5. Words From Families',
            'url' => '/admin/testimonials',
            'publicUrl' => '/#reviews',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
            'desc' => 'Parent reflections & reviews',
        ],
    ],
    'Navbar Pages (Full Pages)' => [
        [
            'label' => 'About Us',
            'url' => '/admin/about',
            'publicUrl' => '/about',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'desc' => 'Heritage, history, technique, values',
        ],
        [
            'label' => 'National Journey',
            'url' => '/admin/journey/national',
            'publicUrl' => '/journey/national',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>',
            'desc' => 'Tours across major Indian states',
        ],
        [
            'label' => 'International Journey',
            'url' => '/admin/journey/international',
            'publicUrl' => '/journey/international',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'desc' => '15+ Nations, UNESCO partner festivals',
        ],
        [
            'label' => 'Awards & Records',
            'url' => '/admin/awards',
            'publicUrl' => '/award',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>',
            'desc' => 'World records & state honours',
        ],
        [
            'label' => 'Dance Stories (Blog)',
            'url' => '/admin/blogs',
            'publicUrl' => '/blog',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>',
            'desc' => 'Pedagogy, traditions & insights',
        ],
        [
            'label' => 'National News & Media',
            'url' => '/admin/news/national',
            'publicUrl' => '/news/national',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>',
            'desc' => 'Print press clippings & coverage',
        ],
        [
            'label' => 'International News',
            'url' => '/admin/news/international',
            'publicUrl' => '/news/international',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>',
            'desc' => 'Foreign press features & reviews',
        ],
        [
            'label' => 'Photo Gallery',
            'url' => '/admin/gallery',
            'publicUrl' => '/gallery',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
            'desc' => '140+ Performance photographs',
        ],
        [
            'label' => 'Contact & Campuses',
            'url' => '/admin/branches',
            'publicUrl' => '/contact',
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
            'desc' => 'Nikol & Bapunagar studios, inquiries',
        ],
    ],
    'Inquiries & Settings' => [
        [
            'label' => 'Admission Enquiries',
            'url' => '/admin/enquiries',
            'publicUrl' => null,
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>',
            'desc' => 'Manage leads & parents requests',
        ],
        [
            'label' => 'Website Global Settings',
            'url' => '/admin/settings',
            'publicUrl' => null,
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
            'desc' => 'Phones, emails, logos, SEO',
        ],
        [
            'label' => 'Staff & Admin Users',
            'url' => '/admin/users',
            'publicUrl' => null,
            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'superAdminOnly' => true,
            'desc' => 'Access control & editors',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Console — Dynamice Children Academy', ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .dragover {
            border-color: #6366f1 !important;
            background-color: #eef2ff !important;
            transform: scale(1.01);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row">

    <!-- Mobile Header -->
    <div class="lg:hidden h-16 bg-white border-b border-slate-200/80 px-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-pink-500 via-rose-500 to-indigo-600 text-white flex items-center justify-center font-extrabold text-sm shadow-sm">D</div>
            <div>
                <span class="font-bold text-slate-900 text-sm leading-tight block">Dynamice CMS</span>
                <span class="text-[10px] text-slate-400 block">Website Admin Console</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="/" target="_blank" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold flex items-center gap-1">
                <span>Site ↗</span>
            </a>
            <button id="mobileMenuBtn" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-slate-200/90 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-0 shadow-sm">
        
        <!-- Brand Header -->
        <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between">
            <a href="/admin" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-pink-500 via-rose-500 to-indigo-600 text-white flex items-center justify-center font-extrabold text-base shadow-md shadow-pink-500/20 group-hover:scale-105 transition-transform">
                    D
                </div>
                <div>
                    <span class="font-extrabold text-slate-900 text-sm tracking-tight block">Dynamice CMS</span>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-pink-600 block">Academy Control Hub</span>
                </div>
            </a>
            <button id="closeSidebarBtn" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 lg:hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Quick Live Website Pill -->
        <div class="px-4 pt-3 pb-2">
            <a href="/" target="_blank" class="w-full px-3 py-2 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-slate-800 hover:to-slate-700 text-white rounded-xl text-xs font-semibold flex items-center justify-between transition-all shadow-xs group">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>View Public Website</span>
                </span>
                <span class="text-slate-400 group-hover:text-white transition-colors">↗</span>
            </a>
        </div>

        <!-- Navigation Groups -->
        <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-5 text-xs">
            <?php foreach ($navGroups as $groupTitle => $items): ?>
                <?php
                // Filter items by RBAC
                $visibleItems = array_filter($items, function($item) use ($userRole) {
                    if (!empty($item['superAdminOnly'])) {
                        return $userRole === 'SUPER_ADMIN';
                    }
                    return true;
                });
                if (empty($visibleItems)) continue;
                ?>
                <div>
                    <div class="px-3 mb-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 flex items-center justify-between">
                        <span><?= htmlspecialchars($groupTitle, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="space-y-0.5">
                        <?php foreach ($visibleItems as $item): ?>
                            <?php 
                            $isActive = ($currentUri === $item['url']) || 
                                        ($item['url'] !== '/admin' && str_starts_with($currentUri, $item['url']));
                            ?>
                            <div class="relative group flex items-center">
                                <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"
                                   class="flex-1 flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all <?= $isActive ? 'bg-indigo-50/80 text-indigo-700 font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>">
                                    <span class="<?= $isActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' ?> shrink-0">
                                        <?= $item['icon'] ?>
                                    </span>
                                    <span class="truncate"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                </a>

                                <?php if (!empty($item['publicUrl'])): ?>
                                    <a href="<?= htmlspecialchars($item['publicUrl'], ENT_QUOTES, 'UTF-8') ?>" 
                                       target="_blank" 
                                       title="View live section on public website"
                                       class="opacity-0 group-hover:opacity-100 p-1.5 text-slate-400 hover:text-pink-600 hover:bg-slate-100 rounded-lg transition-all ml-1 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </nav>

        <!-- User Profile Card -->
        <div class="p-3.5 border-t border-slate-100 bg-slate-50/60">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-pink-500 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="overflow-hidden">
                        <span class="text-xs font-bold text-slate-800 block truncate"><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-[10px] font-medium text-slate-500 block truncate"><?= htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
                <form action="/admin/logout" method="POST" class="inline shrink-0">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <button type="submit" title="Sign Out from CMS" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top App Bar -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-6 hidden lg:flex items-center justify-between sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-2.5 text-xs text-slate-500 font-medium">
                <span class="text-slate-400 font-semibold">Dynamice Admin</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-900 font-bold"><?= htmlspecialchars($title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="flex items-center gap-4">
                <a href="/" target="_blank" class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>View Live Site</span>
                    <span class="text-slate-400 text-[10px]">↗</span>
                </a>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Ready
                </span>
                <span class="text-xs font-medium text-slate-600"><?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        </header>

        <!-- Content Body -->
        <main class="flex-1 p-5 sm:p-7 lg:p-8 overflow-y-auto">
            <?= $content ?? '' ?>
        </main>
    </div>

    <!-- Mobile Backdrop -->
    <div id="mobileBackdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-30 hidden lg:hidden"></div>

    <!-- Universal Drag & Drop Image Uploader Component Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Sidebar Mobile Toggle
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

        // 2. Universal Drag & Drop File Enhancement for all file inputs
        function enhanceFileInputs() {
            const fileInputs = document.querySelectorAll('input[type="file"]:not([data-enhanced])');
            fileInputs.forEach(input => {
                input.setAttribute('data-enhanced', 'true');
                
                // If it already is inside a nice dropzone, enhance drag events
                const parent = input.closest('.dropzone-container') || input.parentElement;
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    parent.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        parent.classList.add('dragover');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    parent.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        parent.classList.remove('dragover');
                    }, false);
                });

                parent.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files.length > 0) {
                        input.files = files;
                        const event = new Event('change', { bubbles: true });
                        input.dispatchEvent(event);
                    }
                }, false);

                // Auto Live Preview
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            let previewImg = parent.querySelector('.live-image-preview');
                            if (!previewImg) {
                                previewImg = document.createElement('img');
                                previewImg.className = 'live-image-preview mt-2 w-28 h-28 object-cover rounded-xl border border-indigo-200 shadow-sm';
                                parent.appendChild(previewImg);
                            }
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('hidden');

                            let fileNameBadge = parent.querySelector('.live-file-badge');
                            if (!fileNameBadge) {
                                fileNameBadge = document.createElement('div');
                                fileNameBadge.className = 'live-file-badge text-[11px] font-semibold text-emerald-600 mt-1';
                                parent.appendChild(fileNameBadge);
                            }
                            fileNameBadge.textContent = '✓ Selected: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        }

        enhanceFileInputs();
        // Re-run for dynamically added modals
        const observer = new MutationObserver(enhanceFileInputs);
        observer.observe(document.body, { childList: true, subtree: true });
    });
    </script>
</body>
</html>
