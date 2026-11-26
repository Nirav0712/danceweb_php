<?php
$headerMenus = \App\Services\ContentService::getHeaderMenu();
$settings = \App\Services\ContentService::getSettings();
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
?>
<!-- Top Notice / Contact Bar -->
<div class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800 w-full">
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 flex flex-col sm:flex-row justify-between items-center gap-2">
        <div class="flex items-center gap-4">
            <a href="tel:<?= htmlspecialchars($settings['phone_primary'] ?? '+91 91738 78750', ENT_QUOTES, 'UTF-8') ?>" class="hover:text-amber-400 flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span><?= htmlspecialchars($settings['phone_primary'] ?? '+91 91738 78750', ENT_QUOTES, 'UTF-8') ?></span>
            </a>
            <span class="hidden sm:inline text-slate-600">|</span>
            <a href="mailto:<?= htmlspecialchars($settings['email'] ?? 'dynamicechildrenacademy@gmail.com', ENT_QUOTES, 'UTF-8') ?>" class="hover:text-amber-400 hidden sm:flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span><?= htmlspecialchars($settings['email'] ?? 'dynamicechildrenacademy@gmail.com', ENT_QUOTES, 'UTF-8') ?></span>
            </a>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-[11px] text-amber-300 font-medium">✨ Admissions Open for New Batches</span>
            <div class="flex items-center gap-2 pl-3 border-l border-slate-700">
                <a href="<?= htmlspecialchars($settings['instagram_url'] ?? '#', ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" class="text-slate-400 hover:text-pink-400 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/80 shadow-xs w-full">
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <img src="/logodance.png" alt="Dynamice Children Academy Logo" class="h-12 w-auto object-contain transform group-hover:scale-105 transition-transform">
                <div class="hidden sm:block">
                    <span class="font-serif font-bold text-slate-900 text-lg leading-tight block">Dynamice Children Academy</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-amber-600 block">Excellence in Dance Since 1998</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                <?php foreach ($headerMenus as $item): ?>
                    <?php if (!empty($item['children'])): ?>
                        <!-- Dropdown -->
                        <div class="relative group" x-data="{ open: false }">
                            <button class="flex items-center gap-1 px-3 py-2 text-sm font-semibold text-slate-700 hover:text-amber-600 rounded-lg transition-colors">
                                <span><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?></span>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-slate-100 py-2 hidden group-hover:block transition-all animate-in fade-in">
                                <?php foreach ($item['children'] as $child): ?>
                                    <a href="<?= htmlspecialchars($child['url'], ENT_QUOTES, 'UTF-8') ?>" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
                                        <?= htmlspecialchars($child['title'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php $active = ($currentUri === $item['url']); ?>
                        <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>" class="px-3 py-2 text-sm font-semibold rounded-lg transition-colors <?= $active ? 'text-amber-600 bg-amber-50 font-bold' : 'text-slate-700 hover:text-amber-600 hover:bg-slate-50' ?>">
                            <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>

            <!-- CTA Button & Mobile Trigger -->
            <div class="flex items-center gap-3">
                <a href="/contact" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition-all transform hover:-translate-y-0.5">
                    Admission Enquiry
                </a>
                <button id="publicMobileBtn" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="publicMobileMenu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-1">
        <?php foreach ($headerMenus as $item): ?>
            <?php if (!empty($item['children'])): ?>
                <div class="py-1">
                    <span class="block px-3 py-1.5 text-xs font-bold text-slate-400 uppercase tracking-wider"><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?></span>
                    <div class="pl-3 space-y-1">
                        <?php foreach ($item['children'] as $child): ?>
                            <a href="<?= htmlspecialchars($child['url'], ENT_QUOTES, 'UTF-8') ?>" class="block px-3 py-2 text-sm font-medium text-slate-700 hover:bg-amber-50 hover:text-amber-600 rounded-lg">
                                <?= htmlspecialchars($child['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>" class="block px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-amber-50 hover:text-amber-600 rounded-lg">
                    <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="pt-3">
            <a href="/contact" class="block text-center py-2.5 px-4 bg-amber-600 text-white font-semibold text-sm rounded-xl">
                Admission Enquiry
            </a>
        </div>
    </div>
</header>
<script>
    document.getElementById('publicMobileBtn')?.addEventListener('click', function() {
        const menu = document.getElementById('publicMobileMenu');
        menu.classList.toggle('hidden');
    });
</script>
