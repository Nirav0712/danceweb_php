<?php
ob_start();
?>
<div class="space-y-8">
    <!-- Top Welcome & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500 animate-pulse"></span>
                    Admin Control Center
                </span>
                <span class="text-xs text-slate-400 font-medium">|</span>
                <span class="text-xs text-slate-500 font-medium">Logged in as <strong><?= htmlspecialchars($user['full_name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars($user['role'] ?? 'EDITOR', ENT_QUOTES, 'UTF-8') ?>)</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Website Content Management</h1>
            <p class="text-xs text-slate-500 mt-1">Select any homepage section or navbar page below to edit content, manage photos, or view live on site.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="/" target="_blank" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold flex items-center gap-2 transition shadow-xs">
                <span>View Live Site</span>
                <span class="text-slate-400">↗</span>
            </a>
            <a href="/admin/hero" class="px-4 py-2.5 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Hero Banner</span>
            </a>
        </div>
    </div>

    <!-- Quick Metrics Overview -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
        <a href="/admin/gallery" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-sm transition-all group">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-indigo-600">Performance Photos</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900"><?= (int) ($metrics['gallery'] ?? 0) ?></span>
                <span class="text-xs text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
            </div>
        </a>
        <a href="/admin/dance-categories" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-sm transition-all group">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-indigo-600">Dance Genres</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900"><?= (int) ($metrics['categories'] ?? 0) ?></span>
                <span class="text-xs text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
            </div>
        </a>
        <a href="/admin/awards" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-sm transition-all group">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-indigo-600">World Records</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900"><?= (int) ($metrics['awards'] ?? 0) ?></span>
                <span class="text-xs text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
            </div>
        </a>
        <a href="/admin/blogs" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-sm transition-all group">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-indigo-600">Dance Stories</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900"><?= (int) ($metrics['blogs'] ?? 0) ?></span>
                <span class="text-xs text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
            </div>
        </a>
        <a href="/admin/news/national" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-indigo-300 hover:shadow-sm transition-all group">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-indigo-600">Press Clippings</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-slate-900"><?= (int) ($metrics['news'] ?? 0) ?></span>
                <span class="text-xs text-indigo-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">View →</span>
            </div>
        </a>
        <a href="/admin/enquiries" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-pink-300 hover:shadow-sm transition-all group bg-gradient-to-br from-white to-pink-50/30">
            <span class="text-[10px] font-bold text-slate-400 block mb-1 uppercase tracking-wider group-hover:text-pink-600">Admission Leads</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-pink-600"><?= (int) ($metrics['enquiries'] ?? 0) ?></span>
                <span class="text-xs text-pink-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">Review →</span>
            </div>
        </a>
    </div>

    <!-- =========================================================================
        1. HOMEPAGE SECTIONS FLOW (TOP TO BOTTOM EXACT ORDER)
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-pink-100 text-pink-700 flex items-center justify-center font-extrabold text-xs">🏠</span>
                    <h2 class="text-base font-extrabold text-slate-900">Homepage Sections Flow (Top to Bottom)</h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Click any section to edit its content or view it live on the homepage</p>
            </div>
            <a href="/" target="_blank" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                <span>Preview Full Homepage</span>
                <span>↗</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 1. Hero Banner -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-indigo-100 text-indigo-800 uppercase tracking-wide">Section 01</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Hero Banner &amp; Heading</h3>
                    <p class="text-xs text-slate-500 mt-1">Manage main headline, subtext, video button, and background slideshow images.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/hero" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Edit Slides &amp; Text →</a>
                    <a href="/" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>

            <!-- 2. Dance Curriculum -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-indigo-100 text-indigo-800 uppercase tracking-wide">Section 02</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Services &amp; Dance Disciplines</h3>
                    <p class="text-xs text-slate-500 mt-1">Kathak Classical, Gujarat Folk Dance, Bollywood, and Western dance forms curriculum tabs.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/dance-categories" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Edit Disciplines →</a>
                    <a href="/#curriculum" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>

            <!-- 3. Tour Flags Carousel -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-indigo-100 text-indigo-800 uppercase tracking-wide">Section 03</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Tour Flags Carousel</h3>
                    <p class="text-xs text-slate-500 mt-1">Country flags and state badges showcasing 15+ nations toured by our child artists.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/tour-flags" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Edit Tour Flags →</a>
                    <a href="/#tours" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>

            <!-- 4. Awards & Records Showcase -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-indigo-100 text-indigo-800 uppercase tracking-wide">Section 04</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Awards &amp; Records Showcase</h3>
                    <p class="text-xs text-slate-500 mt-1">London Book of World Records, Chief Minister felicitations, and national trophies.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/awards" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Manage Awards →</a>
                    <a href="/#awards" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>

            <!-- 5. Words From Families -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-indigo-100 text-indigo-800 uppercase tracking-wide">Section 05</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Words From Our Families</h3>
                    <p class="text-xs text-slate-500 mt-1">Parent reviews, testimonials, 5-star student feedback ratings and citations.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/testimonials" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Manage Reviews →</a>
                    <a href="/#reviews" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>

            <!-- Contact & Studio Campuses -->
            <div class="border border-slate-200 rounded-2xl p-4 hover:border-indigo-300 hover:shadow-xs transition bg-slate-50/30 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-pink-100 text-pink-800 uppercase tracking-wide">Campuses</span>
                        <span class="text-[11px] font-bold text-emerald-600">● Live on Home</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Studio Campuses &amp; Inquiry</h3>
                    <p class="text-xs text-slate-500 mt-1">Nikol HQ and Bapunagar branch addresses, phones, timings, and map embeds.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="/admin/branches" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Manage Campuses →</a>
                    <a href="/contact" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-slate-700">View ↗</a>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
        2. NAVBAR PAGES MANAGER (FULL DEDICATED PAGES)
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-extrabold text-xs">📑</span>
                    <h2 class="text-base font-extrabold text-slate-900">Main Website Pages (Navbar Sequence)</h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Edit headers, visual galleries, blogs, news clippings, and branch details for every top-level page</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 1. About Us -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 01</span>
                        <a href="/about" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/about ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">About Us Page</h3>
                    <p class="text-xs text-slate-500 mt-1">Founded in 2002, Director Tirthraj Trivedi heritage, 4 simple steps teaching technique, vision &amp; mission.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/about" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage About CMS →</a>
                </div>
            </div>

            <!-- 2. National Journey -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 02</span>
                        <a href="/journey/national" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/journey/national ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">National Journey</h3>
                    <p class="text-xs text-slate-500 mt-1">Tours across Indian states, interactive India route map, Rashtriya Lok Utsav performance memories.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/journey/national" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage National →</a>
                </div>
            </div>

            <!-- 3. International Journey -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 03</span>
                        <a href="/journey/international" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/journey/international ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">International Journey</h3>
                    <p class="text-xs text-slate-500 mt-1">Global tours across 15+ countries, CIOFF UNESCO affiliations, country photo filter buttons.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/journey/international" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage International →</a>
                </div>
            </div>

            <!-- 4. Awards & Records -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 04</span>
                        <a href="/award" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/award ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Awards &amp; World Records</h3>
                    <p class="text-xs text-slate-500 mt-1">London Book of World Records certificate uploads, national awards, and accolade filter tabs.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/awards" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage Awards →</a>
                </div>
            </div>

            <!-- 5. Dance Stories (Blog) -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 05</span>
                        <a href="/blog" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/blog ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Dance Stories &amp; Insights</h3>
                    <p class="text-xs text-slate-500 mt-1">Write, publish, and edit pedagogical articles on Indian dance, traditions, and student growth.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/blogs" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage Blog Posts →</a>
                </div>
            </div>

            <!-- 6. National News -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 06</span>
                        <a href="/news/national" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/news/national ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">National News &amp; Media</h3>
                    <p class="text-xs text-slate-500 mt-1">Print media clippings, newspaper headlines (Punjab Kesari, Gujarat Samachar, Sandesh).</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/news/national" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage National News →</a>
                </div>
            </div>

            <!-- 7. International News -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 07</span>
                        <a href="/news/international" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/news/international ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">International News &amp; Media</h3>
                    <p class="text-xs text-slate-500 mt-1">Foreign press reviews, international festival coverage clippings (Istanbul Daily, Europe press).</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/news/international" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage Intl News →</a>
                </div>
            </div>

            <!-- 8. Photo Gallery -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 08</span>
                        <a href="/gallery" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/gallery ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Performance Photo Gallery</h3>
                    <p class="text-xs text-slate-500 mt-1">Visual archive with 140+ high-res stage photos, category filters, and full-screen lightbox modal.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/gallery" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage Gallery →</a>
                </div>
            </div>

            <!-- 9. Contact & Campuses -->
            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-indigo-400 transition shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-indigo-600 uppercase">Page 09</span>
                        <a href="/contact" target="_blank" class="text-[11px] text-slate-400 hover:text-indigo-600 font-semibold flex items-center gap-1">/contact ↗</a>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">Contact &amp; Admissions</h3>
                    <p class="text-xs text-slate-500 mt-1">HQ admission phone, email, hours, Nikol &amp; Bapunagar studios switcher, and enquiry form.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <a href="/admin/branches" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl transition">Manage Contact CMS →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- =========================================================================
        3. RECENT ADMISSION INQUIRIES & LEADS
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Recent Admission Inquiries (Leads)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Parents and students who requested admission or course guidance via the website</p>
            </div>
            <a href="/admin/enquiries" class="px-3 py-1.5 bg-pink-50 hover:bg-pink-100 text-pink-700 text-xs font-bold rounded-xl transition">
                View All Leads (<?= (int)($metrics['enquiries'] ?? 0) ?>) →
            </a>
        </div>

        <?php if (!empty($recentEnquiries)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-100 font-bold uppercase text-[10px]">
                            <th class="py-2.5 px-3">Student / Parent</th>
                            <th class="py-2.5 px-3">Contact</th>
                            <th class="py-2.5 px-3">Campus Branch</th>
                            <th class="py-2.5 px-3">Subject</th>
                            <th class="py-2.5 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($recentEnquiries as $eq): ?>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3 font-bold text-slate-900">
                                    <?= htmlspecialchars($eq['name'] ?? $eq['student_name'] ?? 'Inquiry Lead', ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td class="py-3 px-3 text-slate-600">
                                    <div>📞 <?= htmlspecialchars($eq['phone'] ?? '-', ENT_QUOTES, 'UTF-8') ?></div>
                                    <div class="text-[11px] text-slate-400"><?= htmlspecialchars($eq['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                </td>
                                <td class="py-3 px-3 text-slate-600">
                                    <span class="px-2 py-0.5 bg-slate-100 rounded-md font-medium text-[11px]">
                                        <?= htmlspecialchars($eq['preferred_branch'] ?? 'Nikol Branch', ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-slate-600 max-w-xs truncate">
                                    <?= htmlspecialchars($eq['subject'] ?? 'New Admission Enquiry', ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-pink-100 text-pink-700">
                                        <?= htmlspecialchars($eq['status'] ?? 'NEW', ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="py-8 text-center text-xs text-slate-400">
                No new admission enquiries yet. When parents submit the contact form on <a href="/contact" class="text-indigo-600 underline">/contact</a>, they will appear here.
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
