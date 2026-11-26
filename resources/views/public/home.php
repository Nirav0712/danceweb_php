<?php
ob_start();
?>
<!-- Full-Width Image Hero Banner Slider -->
<section class="relative w-full overflow-hidden bg-slate-950" id="hero-slider-section">
    <?php
    $slides = !empty($heroImages) ? $heroImages : [
        ['url' => '/assets/banners/homebanner.jpg', 'title' => 'Dynamic Children Academy Showcase'],
        ['url' => '/assets/about/academy_group.jpg', 'title' => 'Cultural Dance Troupe'],
        ['url' => '/assets/about/founded-2002-stage.jpg', 'title' => 'Traditional Heritage Stage Showcase'],
        ['url' => '/assets/about/dance-teaching-steps.jpg', 'title' => 'Mastery & Technique Training'],
        ['url' => '/assets/gallery/1.jpg', 'title' => 'Folk Dance Troupe'],
        ['url' => '/assets/gallery/2.jpg', 'title' => 'Classical Garba & Raas'],
    ];
    ?>
    <!-- Full-Width Slider Container -->
    <div class="relative w-full h-[320px] sm:h-[450px] md:h-[550px] lg:h-[680px] select-none" id="hero-carousel-container" aria-label="Hero Image Banner">
        <!-- Slides Track -->
        <div id="hero-slider-track" class="w-full h-full relative overflow-hidden">
            <?php foreach ($slides as $index => $item): ?>
            <div class="hero-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out <?= $index === 0 ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none' ?>"
                 data-slide-index="<?= $index ?>">
                <img src="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"
                     alt="<?= htmlspecialchars($item['title'] ?? 'Dynamic Children Academy Performance', ENT_QUOTES, 'UTF-8') ?>"
                     loading="<?= $index === 0 ? 'eager' : 'lazy' ?>"
                     class="w-full h-full object-cover object-center block"
                     onerror="this.onerror=null;this.src='/assets/banners/homebanner.jpg';">
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Controls: Previous Button -->
        <button id="hero-prev-btn"
                type="button"
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/40 hover:bg-black/75 text-white/90 hover:text-white backdrop-blur-sm flex items-center justify-center transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50"
                aria-label="Previous Slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Navigation Controls: Next Button -->
        <button id="hero-next-btn"
                type="button"
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/40 hover:bg-black/75 text-white/90 hover:text-white backdrop-blur-sm flex items-center justify-center transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50"
                aria-label="Next Slide">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Pagination Dots -->
        <div id="hero-pagination-dots" class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2.5" role="tablist" aria-label="Carousel pagination">
            <!-- Injected via JavaScript based on slide count -->
        </div>
    </div>
</section>

<!-- Heading Immediately Below Hero -->
<section class="bg-white py-8 sm:py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 text-center space-y-2">
        <?php
        $rawHeading = trim($sections['hero']['heading'] ?? 'Culture Is a Way of Life');
        // If the heading is "Culture Is a Way of Life", style "Way of Life" in amber
        if (stripos($rawHeading, 'Culture Is a Way of Life') !== false) {
            $formattedHeading = 'Culture Is a <span class="text-amber-500 font-extrabold">Way of Life</span>';
        } else {
            // General case: preserve custom heading entered in admin panel
            $parts = explode(' ', $rawHeading);
            if (count($parts) > 2) {
                $lastTwo = array_slice($parts, -2);
                $initial = array_slice($parts, 0, -2);
                $formattedHeading = htmlspecialchars(implode(' ', $initial), ENT_QUOTES, 'UTF-8') . ' <span class="text-amber-500 font-extrabold">' . htmlspecialchars(implode(' ', $lastTwo), ENT_QUOTES, 'UTF-8') . '</span>';
            } else {
                $formattedHeading = htmlspecialchars($rawHeading, ENT_QUOTES, 'UTF-8');
            }
        }
        ?>
        <h2 class="font-serif text-2xl sm:text-[26px] font-bold text-slate-800 tracking-tight leading-snug">
            <?= $formattedHeading ?>
        </h2>
        <?php if (!empty($sections['hero']['subheading'])): ?>
        <p class="text-xs sm:text-sm text-slate-500 max-w-2xl mx-auto">
            <?= htmlspecialchars($sections['hero']['subheading'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- Academy Stats Counter Bar -->
<section class="bg-amber-600 text-white py-8 border-y border-amber-700 shadow-inner">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
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

<!-- Academy Curriculum & Visual Archive (Services, Disciplines & Stage Moments) -->
<section id="curriculum-disciplines" class="py-12 sm:py-20 bg-slate-50 border-t border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 space-y-3">
            <span class="inline-block text-xs font-bold tracking-widest uppercase px-3 py-1 bg-amber-100 text-amber-800 rounded-full">
                ACADEMY CURRICULUM & VISUAL ARCHIVE
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 tracking-tight">
                Services, Disciplines & Stage Moments
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Explore our structured child-centric pedagogy, diverse genres, and authentic stage recitals.
            </p>
        </div>

        <!-- 7 Category Pill Tabs -->
        <div class="mb-8 sm:mb-10">
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5" role="tablist" aria-label="Curriculum & Discipline Categories" id="discipline-tablist">
                <?php
                $tabColors = [
                    'service' => ['active' => 'bg-rose-600 text-white shadow-rose-200 border-rose-600', 'hover' => 'hover:border-rose-300 hover:text-rose-600'],
                    'dance' => ['active' => 'bg-emerald-600 text-white shadow-emerald-200 border-emerald-600', 'hover' => 'hover:border-emerald-300 hover:text-emerald-600'],
                    'gymnastics' => ['active' => 'bg-amber-600 text-white shadow-amber-200 border-amber-600', 'hover' => 'hover:border-amber-300 hover:text-amber-600'],
                    'drama' => ['active' => 'bg-sky-600 text-white shadow-sky-200 border-sky-600', 'hover' => 'hover:border-sky-300 hover:text-sky-600'],
                    'modeling' => ['active' => 'bg-pink-600 text-white shadow-pink-200 border-pink-600', 'hover' => 'hover:border-pink-300 hover:text-pink-600'],
                    'drawing' => ['active' => 'bg-indigo-600 text-white shadow-indigo-200 border-indigo-600', 'hover' => 'hover:border-indigo-300 hover:text-indigo-600'],
                    'spiritual' => ['active' => 'bg-violet-600 text-white shadow-violet-200 border-violet-600', 'hover' => 'hover:border-violet-300 hover:text-violet-600'],
                ];
                $tabIndex = 0;
                foreach ($disciplines as $key => $d):
                    $isActive = ($tabIndex === 0);
                    $color = $tabColors[$key] ?? ['active' => 'bg-slate-900 text-white shadow-slate-200 border-slate-900', 'hover' => 'hover:border-slate-400 hover:text-slate-900'];
                ?>
                <button
                    type="button"
                    role="tab"
                    id="tab-btn-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    data-discipline="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    data-active-class="<?= htmlspecialchars($color['active'], ENT_QUOTES, 'UTF-8') ?>"
                    aria-controls="panel-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    aria-selected="<?= $isActive ? 'true' : 'false' ?>"
                    tabindex="<?= $isActive ? '0' : '-1' ?>"
                    class="discipline-tab-btn px-3.5 sm:px-4 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold tracking-wide uppercase transition-all duration-200 border shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 <?= $isActive ? $color['active'] . ' shadow-md' : 'bg-white text-slate-700 border-slate-200 ' . $color['hover'] ?>"
                >
                    <?= htmlspecialchars($d['tabLabel'], ENT_QUOTES, 'UTF-8') ?>
                </button>
                <?php
                    $tabIndex++;
                endforeach;
                ?>
            </div>
        </div>

        <!-- Dynamic Category Content Panels -->
        <div class="relative max-w-6xl mx-auto" id="discipline-panels-container">
            <?php
            $panelIndex = 0;
            foreach ($disciplines as $key => $d):
                $isPanelActive = ($panelIndex === 0);
            ?>
            <div
                id="panel-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                role="tabpanel"
                aria-labelledby="tab-btn-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                class="discipline-panel <?= $isPanelActive ? '' : 'hidden' ?> bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden transition-opacity duration-300"
            >
                <!-- Color Accent Bar -->
                <div class="h-2 w-full bg-gradient-to-r <?= htmlspecialchars($d['accentGradient'], ENT_QUOTES, 'UTF-8') ?>"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center p-5 sm:p-7 lg:p-8">
                    <!-- Left Column: Content -->
                    <div class="lg:col-span-7 space-y-5">
                        <div class="space-y-1.5">
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-amber-600">
                                <span>✦</span>
                                <span><?= htmlspecialchars($d['subtitle'], ENT_QUOTES, 'UTF-8') ?></span>
                            </span>
                            <h3 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                                <?= htmlspecialchars($d['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>
                        </div>

                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                            <?= htmlspecialchars($d['description'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <!-- Feature Badges -->
                        <?php if (!empty($d['badges'])): ?>
                        <div class="pt-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Curriculum Highlights:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($d['badges'] as $badge): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200/80">
                                    ✓ <?= htmlspecialchars($badge, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- CTA Button -->
                        <div class="pt-3">
                            <a
                                href="<?= htmlspecialchars($d['ctaUrl'], ENT_QUOTES, 'UTF-8') ?>"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white shadow-md transition-all duration-200 hover:scale-[1.02] hover:shadow-lg active:scale-[0.98] bg-gradient-to-r <?= htmlspecialchars($d['accentGradient'], ENT_QUOTES, 'UTF-8') ?>"
                            >
                                <span><?= htmlspecialchars($d['ctaText'], ENT_QUOTES, 'UTF-8') ?></span>
                                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Visual Stage Image -->
                    <div class="lg:col-span-5">
                        <div class="relative w-full aspect-[4/3] sm:aspect-[16/11] lg:aspect-square rounded-2xl overflow-hidden shadow-lg border border-slate-100 bg-slate-100 group">
                            <img
                                src="<?= htmlspecialchars($d['image'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($d['title'], ENT_QUOTES, 'UTF-8') ?>"
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            <div class="absolute bottom-3 left-3 right-3 text-white text-xs font-semibold px-3 py-1.5 rounded-lg bg-black/60 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none text-center">
                                <?= htmlspecialchars($d['tabLabel'], ENT_QUOTES, 'UTF-8') ?> • Dynamic Children Academy
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $panelIndex++;
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- Vanilla JS for Interactive Disciplines Tabs -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tablist = document.getElementById('discipline-tablist');
    if (!tablist) return;

    const tabs = Array.from(tablist.querySelectorAll('.discipline-tab-btn'));
    const panels = Array.from(document.querySelectorAll('.discipline-panel'));

    function selectTab(selectedBtn) {
        const targetKey = selectedBtn.getAttribute('data-discipline');
        if (!targetKey) return;

        tabs.forEach(btn => {
            const isMatch = btn === selectedBtn;
            btn.setAttribute('aria-selected', isMatch ? 'true' : 'false');
            btn.setAttribute('tabindex', isMatch ? '0' : '-1');

            const activeClass = btn.getAttribute('data-active-class');
            if (activeClass) {
                activeClass.split(' ').forEach(cls => {
                    if (cls) btn.classList.toggle(cls, isMatch);
                });
            }

            btn.classList.toggle('bg-white', !isMatch);
            btn.classList.toggle('text-slate-700', !isMatch);
            btn.classList.toggle('border-slate-200', !isMatch);
            btn.classList.toggle('shadow-md', isMatch);
            btn.classList.toggle('shadow-sm', !isMatch);
        });

        panels.forEach(panel => {
            const isPanelMatch = panel.id === 'panel-' + targetKey;
            if (isPanelMatch) {
                panel.classList.remove('hidden');
                panel.style.opacity = '0';
                setTimeout(() => {
                    panel.style.opacity = '1';
                }, 20);
            } else {
                panel.classList.add('hidden');
            }
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', function () {
            selectTab(this);
        });

        // Keyboard navigation (Left/Right arrow keys, Home, End)
        tab.addEventListener('keydown', function (e) {
            let newIndex = null;
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                newIndex = (index + 1) % tabs.length;
            } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                newIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (e.key === 'Home') {
                newIndex = 0;
            } else if (e.key === 'End') {
                newIndex = tabs.length - 1;
            }

            if (newIndex !== null) {
                e.preventDefault();
                tabs[newIndex].focus();
                selectTab(tabs[newIndex]);
            }
        });
    });
});
</script>

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
                        <img src="<?= htmlspecialchars($cat['cover_image_url'] ?? '/assets/homepage/default_cat.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
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
                <img src="<?= htmlspecialchars($flag['flag_image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-12 h-8 mx-auto object-cover rounded shadow-xs" loading="lazy">
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
                    <img src="<?= htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Performance Photo', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
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

<!-- Full-Width Hero Slider JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('hero-carousel-container');
    const track = document.getElementById('hero-slider-track');
    const prevBtn = document.getElementById('hero-prev-btn');
    const nextBtn = document.getElementById('hero-next-btn');
    const dotsContainer = document.getElementById('hero-pagination-dots');

    if (!container || !track) return;

    const slides = Array.from(track.getElementsByClassName('hero-slide'));
    const totalSlides = slides.length;
    if (totalSlides === 0) return;

    let currentIndex = 0;
    let autoPlayTimer = null;

    function renderDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'transition-all duration-300 rounded-full ' +
                (i === currentIndex
                    ? 'w-7 sm:w-8 h-2 sm:h-2.5 bg-amber-500 shadow-md'
                    : 'w-2 sm:w-2.5 h-2 sm:h-2.5 bg-white/60 hover:bg-white');
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.addEventListener('click', () => {
                goToSlide(i);
                restartAutoPlay();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateSlideVisibility() {
        slides.forEach((slide, idx) => {
            if (idx === currentIndex) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100', 'z-10', 'pointer-events-auto');
            } else {
                slide.classList.remove('opacity-100', 'z-10', 'pointer-events-auto');
                slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
            }
        });

        // Update dots styling
        if (dotsContainer) {
            const dots = dotsContainer.children;
            for (let i = 0; i < dots.length; i++) {
                if (i === currentIndex) {
                    dots[i].className = 'w-7 sm:w-8 h-2 sm:h-2.5 bg-amber-500 shadow-md transition-all duration-300 rounded-full';
                } else {
                    dots[i].className = 'w-2 sm:w-2.5 h-2 sm:h-2.5 bg-white/60 hover:bg-white transition-all duration-300 rounded-full';
                }
            }
        }
    }

    function goToSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;
        updateSlideVisibility();
    }

    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(nextSlide, 5000);
    }

    function stopAutoPlay() {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    function restartAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            restartAutoPlay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            restartAutoPlay();
        });
    }

    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    container.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoPlay();
    }, { passive: true });

    container.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
            if (diff > 0) nextSlide();
            else prevSlide();
        }
        startAutoPlay();
    }, { passive: true });

    renderDots();
    updateSlideVisibility();
    startAutoPlay();
});
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
