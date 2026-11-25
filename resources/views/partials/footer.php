<?php
$footerMenus = \App\Services\ContentService::getFooterMenu();
$settings = \App\Services\ContentService::getSettings();
$branches = \App\Services\ContentService::getBranches();
?>
<!-- Footer -->
<footer class="bg-slate-950 text-slate-400 text-xs border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Academy Intro -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="/logodance.png" alt="Logo" class="h-10 w-auto brightness-200">
                    <div>
                        <span class="font-serif font-bold text-white text-base block leading-tight">Dynamice Children Academy</span>
                        <span class="text-[10px] text-amber-500 font-bold uppercase tracking-widest block">Est. 1998</span>
                    </div>
                </div>
                <p class="text-slate-400 leading-relaxed text-xs">
                    Pioneering traditional Indian folk, classical, and contemporary dance arts. Limca & Golden Book of World Records holder with global youth tour accolades across 15+ countries.
                </p>
                <div class="pt-2">
                    <span class="text-slate-300 font-semibold block mb-1">Director:</span>
                    <span class="text-amber-400 font-bold text-sm block"><?= htmlspecialchars($settings['director_name'] ?? 'Shri Tirthraj Trivedi', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>

            <!-- Quick Navigation Links -->
            <div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-4 border-l-2 border-amber-500 pl-3">Explore Academy</h3>
                <ul class="space-y-2">
                    <?php foreach ($footerMenus as $fm): ?>
                        <li>
                            <a href="<?= htmlspecialchars($fm['url'], ENT_QUOTES, 'UTF-8') ?>" class="hover:text-amber-400 transition-colors flex items-center gap-2">
                                <span class="text-slate-600">›</span>
                                <span><?= htmlspecialchars($fm['title'], ENT_QUOTES, 'UTF-8') ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Campuses & Studios -->
            <div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-4 border-l-2 border-amber-500 pl-3">Our Campuses</h3>
                <div class="space-y-4">
                    <?php foreach ($branches as $branch): ?>
                        <div class="bg-slate-900/60 p-3 rounded-xl border border-slate-800">
                            <span class="font-semibold text-white text-xs block mb-1"><?= htmlspecialchars($branch['branch_name'] ?? 'Branch', ENT_QUOTES, 'UTF-8') ?></span>
                            <p class="text-slate-400 text-[11px] leading-relaxed mb-1.5"><?= htmlspecialchars($branch['address_line1'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                            <span class="text-amber-400 font-medium text-[11px] block">📞 <?= htmlspecialchars($branch['phone_primary'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Newsletter Subscription -->
            <div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-4 border-l-2 border-amber-500 pl-3">Stay Connected</h3>
                <p class="text-slate-400 text-xs mb-4">Subscribe for dance recital announcements, workshop schedules, and tour reports.</p>
                <form action="/api/newsletter/subscribe" method="POST" class="space-y-2" id="footerNewsletterForm">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <input type="email" name="email" required placeholder="Enter your email address"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white placeholder-slate-500 text-xs focus:outline-none focus:border-amber-500 transition-colors">
                    <button type="submit" class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-500 text-white font-semibold rounded-xl text-xs transition-colors">
                        Subscribe Newsletter
                    </button>
                    <div id="newsletterMsg" class="text-[11px] hidden mt-1"></div>
                </form>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center gap-4 text-slate-500 text-[11px]">
            <p>© <?= date('Y') ?> Dynamice Children Academy. All Rights Reserved. Reg. Trust & Cultural Organization.</p>
            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                <a href="/privacy-policy" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                <span>•</span>
                <a href="/terms" class="hover:text-slate-400 transition-colors">Terms</a>
                <span>•</span>
                <a href="/faq" class="hover:text-slate-400 transition-colors">FAQ</a>
                <span>•</span>
                <a href="/admin/login" class="hover:text-slate-400 transition-colors">Admin Console</a>
                <span>•</span>
                <a href="/seo/sitemap.xml" class="hover:text-slate-400 transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
