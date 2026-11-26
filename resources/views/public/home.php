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
<section id="curriculum-disciplines" class="py-12 sm:py-20 bg-slate-50 border-t border-b border-slate-200/60 w-full overflow-hidden">
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-4xl mx-auto mb-10 space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/90 border border-slate-200/80 shadow-xs text-xs font-black uppercase tracking-widest text-slate-800">
                <span class="text-amber-500">✦</span>
                <span>ACADEMY CURRICULUM & VISUAL ARCHIVE</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Services, Disciplines & Stage Moments
            </h2>
            <p class="text-sm sm:text-base text-slate-600 font-medium max-w-2xl mx-auto">
                Explore our structured child-centric pedagogy, diverse genres, and authentic stage recitals.
            </p>
        </div>

        <!-- 7 Category Selector Tabs -->
        <div class="w-full flex items-center justify-center pb-6">
            <div class="flex items-center justify-center flex-wrap gap-2 sm:gap-3 p-2 rounded-full bg-white/95 border-2 border-slate-200/80 shadow-lg max-w-full" role="tablist" aria-label="Curriculum & Discipline Categories" id="discipline-tablist">
                <?php
                $activeTabKey = 'dance'; // Default to dance tab as shown in user screenshot
                foreach ($disciplines as $key => $d):
                    $isSelected = ($key === $activeTabKey);
                ?>
                <button
                    type="button"
                    role="tab"
                    id="tab-btn-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    data-discipline="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    data-pill-color="<?= htmlspecialchars($d['pillColor'], ENT_QUOTES, 'UTF-8') ?>"
                    data-active-bg="<?= htmlspecialchars($d['activeBg'], ENT_QUOTES, 'UTF-8') ?>"
                    aria-controls="panel-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    aria-selected="<?= $isSelected ? 'true' : 'false' ?>"
                    tabindex="<?= $isSelected ? '0' : '-1' ?>"
                    class="discipline-tab-btn px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-black tracking-wider transition-all duration-300 transform active:scale-95 <?= $isSelected ? 'bg-gradient-to-r ' . $d['activeBg'] . ' text-white shadow-xl scale-105 border-2 border-white ring-2 ring-white/60' : $d['pillColor'] . ' opacity-85 hover:opacity-100 hover:scale-102 border border-white/70 shadow-xs' ?>"
                >
                    <?= htmlspecialchars($d['tabLabel'], ENT_QUOTES, 'UTF-8') ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Dynamic Category Content Panels -->
        <div class="w-full" id="discipline-panels-container">
            <?php
            foreach ($disciplines as $key => $d):
                $isPanelActive = ($key === $activeTabKey);
            ?>
            <div
                id="panel-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                role="tabpanel"
                aria-labelledby="tab-btn-<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                class="discipline-panel <?= $isPanelActive ? '' : 'hidden' ?> w-full bg-white rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden relative transition-opacity duration-300"
            >
                <!-- Top Iridescent Accent Strip -->
                <div class="absolute top-0 inset-x-0 h-2.5 bg-gradient-to-r <?= htmlspecialchars($d['activeBg'], ENT_QUOTES, 'UTF-8') ?> shadow-sm z-20"></div>

                <!-- TOP HALF: 50/50 Split (Left: Content, Right: Edge-to-Edge Flush Image) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch min-h-[460px] lg:min-h-[520px]">
                    <!-- Left Side: Generous Padding, Title & Exact Paragraphs -->
                    <div class="p-8 sm:p-12 lg:p-14 xl:p-16 flex flex-col justify-center space-y-5 bg-white">
                        <h3 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                            <?= htmlspecialchars($d['title'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <!-- Exact paragraphs -->
                        <div class="text-xs sm:text-sm lg:text-[15px] text-slate-700 leading-relaxed space-y-4 font-normal">
                            <?php foreach ($d['paragraphs'] as $p): ?>
                                <p><?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endforeach; ?>
                        </div>

                        <!-- Enroll CTA Button -->
                        <div class="pt-2">
                            <a
                                href="/contact?service=<?= urlencode($key) ?>"
                                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-xs sm:text-sm font-black uppercase tracking-wider text-white bg-gradient-to-r <?= htmlspecialchars($d['activeBg'], ENT_QUOTES, 'UTF-8') ?> shadow-lg hover:shadow-xl transition-all hover:scale-102"
                            >
                                <span>Enroll for Free Trial Session</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right Side: Flush Full-Bleed Image (Touches top, bottom, right edge) -->
                    <div class="relative w-full h-[360px] sm:h-[440px] lg:h-full min-h-[360px] lg:min-h-full overflow-hidden bg-slate-100">
                        <img
                            src="<?= htmlspecialchars($d['image'], ENT_QUOTES, 'UTF-8') ?>"
                            alt="<?= htmlspecialchars($d['title'], ENT_QUOTES, 'UTF-8') ?>"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    </div>
                </div>

                <!-- BOTTOM HALF: Full-Width 6-Item Grid Underneath -->
                <div class="border-t border-slate-200/60 p-6 sm:p-10 lg:p-12 xl:p-14 bg-slate-50/50 relative z-10 w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-pink-600 mb-1">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span><?= htmlspecialchars($d['title'], ENT_QUOTES, 'UTF-8') ?> Visual Showcase</span>
                            </div>
                            <h4 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">
                                <?= htmlspecialchars($d['subItemsHeader'], ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                        </div>

                        <!-- Explore Full Academy Gallery Link -->
                        <a
                            href="/gallery"
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-black uppercase tracking-wider text-amber-600 hover:text-amber-700 transition-colors"
                        >
                            <span>Explore Full Academy Gallery →</span>
                        </a>
                    </div>

                    <!-- 6 Sub-Items Grid: 1 Image for each item, spreading across full width -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5 xl:gap-6 w-full">
                        <?php foreach ($d['subItems'] as $idx => $item): ?>
                        <div class="group/card rounded-2xl bg-white border border-slate-200/80 p-3 sm:p-3.5 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <!-- Item Image -->
                                <div class="relative aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-100 mb-3 group/img">
                                    <img
                                        src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                                        loading="lazy"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-110"
                                    >
                                    <div class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-slate-900/70 text-[9px] font-black text-white">
                                        #<?= $idx + 1 ?>
                                    </div>
                                </div>

                                <!-- Title -->
                                <h5 class="text-xs sm:text-sm font-black text-slate-900 leading-snug line-clamp-1 mb-1">
                                    <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h5>

                                <!-- Detail -->
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed line-clamp-2">
                                    <?= htmlspecialchars($item['detail'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            </div>

                            <!-- More button -->
                            <div class="pt-3 mt-3 border-t border-slate-100">
                                <a
                                    href="/gallery"
                                    class="inline-flex items-center gap-1 text-[11px] font-bold text-pink-600 hover:text-pink-700 transition-colors"
                                >
                                    <span>More</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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

            const pillColor = btn.getAttribute('data-pill-color') || '';
            const activeBg = btn.getAttribute('data-active-bg') || '';

            // Clean active / inactive classes
            btn.className = 'discipline-tab-btn px-4 sm:px-6 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-black tracking-wider transition-all duration-300 transform active:scale-95 ';

            if (isMatch) {
                btn.className += 'bg-gradient-to-r ' + activeBg + ' text-white shadow-xl scale-105 border-2 border-white ring-2 ring-white/60';
            } else {
                btn.className += pillColor + ' opacity-85 hover:opacity-100 hover:scale-102 border border-white/70 shadow-xs';
            }
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
