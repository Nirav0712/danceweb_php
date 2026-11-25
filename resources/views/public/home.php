<?php
ob_start();
?>
<!-- Hero Section -->
<section class="relative bg-slate-950 text-white overflow-hidden py-24 sm:py-32">
    <div class="absolute inset-0 z-0 opacity-40">
        <img src="<?= htmlspecialchars($sections['hero']['image_url'] ?? ($page['banner_image_url'] ?? '/assets/banners/homebanner.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt="Dynamice Dance Performance" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent z-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <div class="max-w-2xl space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-semibold">
                <span><?= htmlspecialchars($sections['hero']['subheading'] ?? '🏆 Limca & Golden Book World Records', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                <?= htmlspecialchars($sections['hero']['heading'] ?? ($page['title'] ?? 'Cultivating Heritage, Inspiring Rhythm'), ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                <?= htmlspecialchars($sections['hero']['content'] ?? ($page['subtitle'] ?? 'Welcome to Dynamice Children Academy — Gujarat\'s premier dance institute nurturing children in traditional Indian folk arts, classical disciplines, and global cultural tours since 1998.'), ENT_QUOTES, 'UTF-8') ?>
            </p>
            <div class="flex flex-wrap items-center gap-4 pt-4">
                <a href="<?= htmlspecialchars($sections['hero']['button_url'] ?? '/contact', ENT_QUOTES, 'UTF-8') ?>" class="px-6 py-3.5 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-bold text-sm rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">
                    <?= htmlspecialchars($sections['hero']['button_text'] ?? 'Enroll for Admissions', ENT_QUOTES, 'UTF-8') ?>
                </a>
                <a href="/about" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold text-sm rounded-xl border border-white/20 transition-all">
                    Discover Our Story
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Academy Stats Counter Bar -->
<section class="bg-amber-600 text-white py-8 border-y border-amber-700 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-amber-500/40">
            <div class="pt-2 md:pt-0">
                <span class="font-serif text-3xl sm:text-4xl font-bold block mb-1">25+</span>
                <span class="text-xs font-medium uppercase tracking-wider text-amber-100">Years of Legacy</span>
            </div>
            <div class="pt-2 md:pt-0">
                <span class="font-serif text-3xl sm:text-4xl font-bold block mb-1">15,000+</span>
                <span class="text-xs font-medium uppercase tracking-wider text-amber-100">Students Mentored</span>
            </div>
            <div class="pt-2 md:pt-0">
                <span class="font-serif text-3xl sm:text-4xl font-bold block mb-1">15+</span>
                <span class="text-xs font-medium uppercase tracking-wider text-amber-100">Countries Toured</span>
            </div>
            <div class="pt-2 md:pt-0">
                <span class="font-serif text-3xl sm:text-4xl font-bold block mb-1">50+</span>
                <span class="text-xs font-medium uppercase tracking-wider text-amber-100">State & World Honors</span>
            </div>
        </div>
    </div>
</section>

<!-- Director Address & Vision -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5 relative">
                <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                    <img src="<?= htmlspecialchars($sections['about_intro']['image_url'] ?? '/assets/about/director.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="Director Shri Tirthraj Trivedi" class="w-full h-auto object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white p-5 rounded-2xl shadow-lg border border-slate-100 hidden sm:block max-w-xs">
                    <span class="text-xs font-bold text-slate-900 block"><?= htmlspecialchars($settings['director_name'] ?? 'Shri Tirthraj Trivedi', ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="text-[11px] text-amber-600 font-semibold block">Founder Director & Choreographer</span>
                </div>
            </div>
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 text-xs font-bold text-amber-600 uppercase tracking-widest">
                    <span><?= htmlspecialchars($sections['about_intro']['subheading'] ?? 'Message from the Founder', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900 leading-snug">
                    "<?= htmlspecialchars($sections['about_intro']['heading'] ?? 'Dance is not merely movement; it is the heartbeat of cultural heritage.', ENT_QUOTES, 'UTF-8') ?>"
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    <?= htmlspecialchars($sections['about_intro']['content'] ?? 'For over two decades, Dynamice Children Academy has fostered discipline, poise, and cultural self-expression in thousands of young girls and boys. Our mission is to take the authentic folk rhythms of Gujarat and India to the world\'s most prestigious stages.', ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="pt-4 flex items-center gap-4">
                    <a href="<?= htmlspecialchars($sections['about_intro']['button_url'] ?? '/about', ENT_QUOTES, 'UTF-8') ?>" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-bold text-sm">
                        <span><?= htmlspecialchars($sections['about_intro']['button_text'] ?? 'Read Director\'s Full Profile', ENT_QUOTES, 'UTF-8') ?></span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dance Categories & Curriculum -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Training Curriculum</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">Disciplines We Teach</h2>
            <p class="text-slate-500 text-sm">From traditional Raas-Garba to classical foundations and contemporary fusion.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($categories as $cat): ?>
                <div class="group bg-slate-50 rounded-2xl border border-slate-200/80 overflow-hidden hover:shadow-lg transition-all transform hover:-translate-y-1">
                    <div class="h-48 overflow-hidden bg-slate-200">
                        <img src="<?= htmlspecialchars($cat['cover_image_url'] ?? '/assets/homepage/default_cat.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 space-y-3">
                        <h3 class="font-serif font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors">
                            <?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            <?= htmlspecialchars($cat['description'] ?? 'Comprehensive training modules structured for beginner and advanced students.', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- World Tour Flags Carousel -->
<?php if (!empty($tourFlags)): ?>
<section class="py-16 bg-slate-900 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 text-center">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Global Footprint</span>
        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white mt-1">Countries Our Dancers Have Toured</h2>
    </div>
    <div class="flex items-center gap-6 overflow-x-auto py-4 px-4 no-scrollbar">
        <?php foreach ($tourFlags as $flag): ?>
            <div class="flex-shrink-0 bg-slate-800/80 border border-slate-700 p-4 rounded-xl text-center w-36 space-y-2">
                <img src="<?= htmlspecialchars($flag['flag_image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-12 h-8 mx-auto object-cover rounded shadow-xs">
                <span class="font-semibold text-xs text-white block truncate"><?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                <span class="text-[10px] text-amber-400 font-medium block"><?= htmlspecialchars($flag['tour_year'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Featured Stage Gallery -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-12">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Visual Chronicle</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900 mt-1">Glimpses of Performances</h2>
            </div>
            <a href="/gallery" class="text-amber-600 hover:text-amber-700 font-semibold text-xs flex items-center gap-1">
                <span>View Full 140+ Photo Gallery</span>
                <span>→</span>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($gallery as $item): ?>
                <div class="group relative rounded-xl overflow-hidden aspect-square bg-slate-200 shadow-xs">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Performance Photo', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end text-white">
                        <span class="font-semibold text-xs truncate"><?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials & Reviews -->
<?php if (!empty($testimonials)): ?>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Voices of Appreciation</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">What Parents & Students Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($testimonials as $t): ?>
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-1 text-amber-400">
                        <?php for ($i = 0; $i < (int) ($t['rating'] ?? 5); $i++): ?>★<?php endfor; ?>
                    </div>
                    <p class="text-slate-700 text-sm leading-relaxed italic">
                        "<?= htmlspecialchars($t['review_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    </p>
                    <div class="pt-2 border-t border-slate-200/60">
                        <span class="font-bold text-slate-900 text-sm block"><?= htmlspecialchars($t['person_name'] ?? 'Parent', ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-xs text-slate-500 block"><?= htmlspecialchars($t['relation_or_role'] ?? 'Student', ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Common Call to Action -->
<section class="py-16 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold">Start Your Dance Journey Today</h2>
        <p class="text-amber-100 text-sm max-w-xl mx-auto leading-relaxed">
            New training batches are now open across our Nikol and Bapunagar studios. Join our vibrant community of aspiring performers.
        </p>
        <div class="pt-2">
            <a href="/contact" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-950 hover:bg-slate-900 text-white font-bold text-sm rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">
                Contact Admissions Team
            </a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
