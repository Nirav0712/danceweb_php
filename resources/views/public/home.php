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



<!-- Participated International Festivals / Tour Flags Carousel (SS 1 Reference Design) -->
<?php if (!empty($tourFlags)): ?>
<section id="tour-flags-showcase" class="py-14 sm:py-20 bg-[#c9175d] text-white relative overflow-hidden w-full shadow-md">
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <!-- Centered Heading & Subtitle (CMS-Managed) -->
        <div class="text-center max-w-4xl mx-auto mb-8 sm:mb-12 px-4 space-y-2">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-[40px] font-extrabold text-white tracking-tight leading-snug drop-shadow-sm">
                <?= htmlspecialchars($sections['tour_flags']['heading'] ?? 'Participated International Festivals in last 12 years All Over world', ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <p class="text-xs sm:text-sm text-pink-100 font-medium max-w-xl mx-auto leading-relaxed">
                <?= htmlspecialchars($sections['tour_flags']['subheading'] ?? 'Click any country flag to view live performance photos & festival achievements.', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>

        <!-- Flag Slider Carousel with Arrows -->
        <div class="relative w-full" id="tour-flags-slider-wrapper">
            <!-- Left Arrow Button -->
            <button
                type="button"
                id="tour-flags-prev-btn"
                class="absolute -left-2 sm:left-1 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-md border border-white/50 shadow-xl flex items-center justify-center transition-all hover:scale-110 cursor-pointer focus:outline-none"
                aria-label="Previous Flag"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Right Arrow Button -->
            <button
                type="button"
                id="tour-flags-next-btn"
                class="absolute -right-2 sm:right-1 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/50 hover:bg-black/80 text-white backdrop-blur-md border border-white/50 shadow-xl flex items-center justify-center transition-all hover:scale-110 cursor-pointer focus:outline-none"
                aria-label="Next Flag"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Scrolling Flags Track (No ugly browser scrollbar) -->
            <div
                id="tour-flags-track"
                class="flex items-center gap-4 sm:gap-6 overflow-x-auto py-5 px-6 sm:px-10 scroll-smooth"
                style="scrollbar-width: none; -ms-overflow-style: none;"
            >
                <?php foreach ($tourFlags as $flag):
                    $redirectUrl = !empty($flag['target_url']) ? $flag['target_url'] : (
                        ($flag['journey_type'] ?? '') === 'NATIONAL'
                            ? '/journey/national'
                            : '/journey/international?country=' . urlencode(strtolower($flag['country_code'] ?? ''))
                    );
                    $flagImg = !empty($flag['flag_url']) ? $flag['flag_url'] : '/assets/international/' . strtolower($flag['country_code'] ?? 'in') . '.png';
                ?>
                <a
                    href="<?= htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8') ?>"
                    title="<?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?> — Click to view stage photos"
                    class="group relative flex-none w-[130px] sm:w-[155px] md:w-[175px] aspect-[4/3] rounded-xl sm:rounded-2xl overflow-hidden bg-white p-1 shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-300 border-2 border-white/95 cursor-pointer block"
                >
                    <img
                        src="<?= htmlspecialchars($flagImg, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        class="w-full h-full object-cover rounded-lg sm:rounded-xl"
                        loading="lazy"
                        onerror="this.src='/assets/international/in.png';"
                    >

                    <!-- Subtle sheen glare -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-black/15 via-transparent to-white/30 pointer-events-none rounded-lg sm:rounded-xl"></div>

                    <!-- Tooltip on Hover showing Country Name -->
                    <div class="absolute inset-x-0 bottom-0 py-1 bg-black/85 backdrop-blur-xs text-[10px] sm:text-[11px] font-bold text-white text-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 truncate px-1">
                        <?= htmlspecialchars($flag['country_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Vanilla JS for Tour Flags Slider (Smooth scroll, arrows, auto-loop, pause on hover) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('tour-flags-track');
    const prevBtn = document.getElementById('tour-flags-prev-btn');
    const nextBtn = document.getElementById('tour-flags-next-btn');
    const wrapper = document.getElementById('tour-flags-slider-wrapper');
    if (!track) return;

    let isPaused = false;

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            track.scrollBy({ left: -260, behavior: 'smooth' });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            track.scrollBy({ left: 260, behavior: 'smooth' });
        });
    }

    if (wrapper) {
        wrapper.addEventListener('mouseenter', function () { isPaused = true; });
        wrapper.addEventListener('mouseleave', function () { isPaused = false; });
    }

    // Auto-scroll loop
    setInterval(function () {
        if (isPaused || !track) return;
        if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
            track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            track.scrollBy({ left: 200, behavior: 'smooth' });
        }
    }, 2600);
});
</script>
<?php endif; ?>

<!-- Awards & World Records Showcase (SS 1 Reference Design) -->
<?php
$awardsHeading = $sections['awards']['heading'] ?? 'Awards & World Records';
$awardsSubheading = $sections['awards']['subheading'] ?? 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.';
$awardsBadge = !empty($sections['awards']['content']) ? $sections['awards']['content'] : 'PRESTIGIOUS ACCREDITATIONS & HONORS';
$awardsBtnText = $sections['awards']['button_text'] ?? 'View All Records & Honors';
$awardsBtnUrl = $sections['awards']['button_url'] ?? '/awards';
?>
<section id="awards-showcase-section" class="py-16 sm:py-24 bg-slate-950 text-white relative overflow-hidden select-none w-full" aria-label="Awards and World Records Slider">
    <!-- Ambient background glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 left-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-pink-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 sm:mb-12 gap-6 border-b border-gray-800/80 pb-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs font-bold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span><?= htmlspecialchars($awardsBadge, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mt-1">
                    <?= htmlspecialchars($awardsHeading, ENT_QUOTES, 'UTF-8') ?>
                </h2>
                <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-xl leading-relaxed">
                    <?= htmlspecialchars($awardsSubheading, ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>

            <!-- Navigation Controls & View All Link -->
            <div class="flex items-center gap-4 shrink-0">
                <a
                    href="<?= htmlspecialchars($awardsBtnUrl, ENT_QUOTES, 'UTF-8') ?>"
                    class="hidden sm:inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-pink-400 hover:text-white transition-colors mr-2"
                >
                    <span><?= htmlspecialchars($awardsBtnText, ENT_QUOTES, 'UTF-8') ?></span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>

                <!-- Slider Navigation Arrows -->
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        id="awards-prev-btn"
                        class="p-2.5 sm:p-3 rounded-full bg-gray-900 hover:bg-pink-600 text-white border border-gray-800 hover:border-pink-500 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed hover:scale-105 active:scale-95 shadow-lg cursor-pointer"
                        aria-label="Previous awards slide"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <button
                        type="button"
                        id="awards-next-btn"
                        class="p-2.5 sm:p-3 rounded-full bg-gray-900 hover:bg-pink-600 text-white border border-gray-800 hover:border-pink-500 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed hover:scale-105 active:scale-95 shadow-lg cursor-pointer"
                        aria-label="Next awards slide"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <!-- Pause / Play Button -->
                    <button
                        type="button"
                        id="awards-pause-btn"
                        class="p-2.5 sm:p-3 rounded-full bg-gray-900/80 hover:bg-white/20 text-gray-300 hover:text-white border border-gray-800 transition-colors cursor-pointer"
                        title="Pause / Resume auto-slider"
                        aria-label="Pause / Resume auto-slider"
                    >
                        <svg id="awards-pause-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                        <svg id="awards-play-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- 4-Card Slide Window Container -->
        <div class="relative overflow-hidden w-full py-2" id="awards-slider-window">
            <div
                id="awards-slider-track"
                class="flex transition-transform duration-500 ease-out"
                style="transform: translateX(0%);"
            >
                <?php foreach ($awards as $award): ?>
                <div class="awards-slide-item flex-none px-2.5 sm:px-3" style="width: 25%;">
                    <div class="h-full bg-gray-900/95 border border-gray-800 hover:border-pink-500/60 rounded-2xl sm:rounded-3xl p-5 sm:p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-pink-500/10 group relative overflow-hidden">
                        <!-- Top rainbow accent border on hover -->
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 via-pink-500 to-rose-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Top Badges Row -->
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <?php if (!empty($award['is_record_book'])): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[11px] font-extrabold uppercase tracking-wider shadow-xs">
                                        <span>🏆</span>
                                        <span>World Record</span>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-500/20 text-pink-300 border border-pink-500/40 text-[11px] font-extrabold uppercase tracking-wider shadow-xs">
                                        <span>🏅</span>
                                        <span>National Honor</span>
                                    </span>
                                <?php endif; ?>

                                <span class="text-xs font-bold text-gray-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10 shrink-0">
                                    <?= (int)$award['year'] ?>
                                </span>
                            </div>

                            <!-- Certificate Image Preview -->
                            <div class="relative aspect-[16/10] w-full rounded-xl overflow-hidden bg-black/60 border border-white/10 mb-4 group-hover:border-pink-500/40 transition-colors">
                                <img
                                    src="<?= htmlspecialchars($award['certificate_image_url'] ?: '/assets/awards/01.jpg', ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($award['title'] ?? 'Award Certificate', ENT_QUOTES, 'UTF-8') ?>"
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy"
                                    onerror="this.src='/assets/awards/01.jpg';"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent pointer-events-none"></div>
                            </div>

                            <!-- Award Title -->
                            <h3 class="text-base sm:text-lg font-bold text-white group-hover:text-pink-300 transition-colors leading-snug line-clamp-2 mb-2">
                                <?= htmlspecialchars($award['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </h3>

                            <!-- Issuer / Authority -->
                            <p class="text-xs font-medium text-gray-400 flex items-center gap-1.5 mb-3">
                                <span class="text-pink-400 font-bold shrink-0">🏅</span>
                                <span class="truncate"><?= htmlspecialchars($award['issuer'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                            </p>

                            <!-- Description -->
                            <p class="text-xs text-gray-300/90 leading-relaxed line-clamp-3 font-normal">
                                <?= htmlspecialchars($award['description'] ?: 'Inscribed for historic mass child classical dance recital and world-class choreography synchronization.', ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <!-- Card Bottom CTA -->
                        <div class="pt-5 mt-5 border-t border-gray-800/80 flex items-center justify-between text-xs">
                            <a
                                href="<?= htmlspecialchars($awardsBtnUrl, ENT_QUOTES, 'UTF-8') ?>"
                                class="inline-flex items-center gap-1.5 font-bold text-pink-400 group-hover:text-white transition-colors"
                            >
                                <span>Explore Archive</span>
                                <span class="transition-transform group-hover:translate-x-1">→</span>
                            </a>

                            <span class="text-[11px] text-gray-400 font-mono">
                                #<?= (int)$award['id'] ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Bottom Pagination Dots & Counter -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Indicator dots -->
            <div id="awards-dots-container" class="flex items-center gap-1.5">
                <!-- Injected via JavaScript -->
            </div>

            <div class="text-xs text-gray-400 font-medium">
                Showing <strong id="awards-showing-count">4</strong> of <strong><?= count($awards) ?></strong> records &amp; honors
            </div>

            <a
                href="<?= htmlspecialchars($awardsBtnUrl, ENT_QUOTES, 'UTF-8') ?>"
                class="sm:hidden inline-flex items-center gap-2 text-xs font-semibold text-pink-400 hover:text-white transition-colors"
            >
                <span><?= htmlspecialchars($awardsBtnText, ENT_QUOTES, 'UTF-8') ?></span>
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Vanilla JS for Awards & World Records Carousel Slider -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('awards-slider-track');
    const prevBtn = document.getElementById('awards-prev-btn');
    const nextBtn = document.getElementById('awards-next-btn');
    const pauseBtn = document.getElementById('awards-pause-btn');
    const pauseIcon = document.getElementById('awards-pause-icon');
    const playIcon = document.getElementById('awards-play-icon');
    const dotsContainer = document.getElementById('awards-dots-container');
    const showingCount = document.getElementById('awards-showing-count');
    const section = document.getElementById('awards-showcase-section');
    const slides = document.querySelectorAll('.awards-slide-item');
    const totalSlides = slides.length;

    if (!track || totalSlides === 0) return;

    let currentIndex = 0;
    let itemsPerView = 4;
    let isPaused = false;
    let autoSlideTimer = null;

    function calculateItemsPerView() {
        const width = window.innerWidth;
        if (width >= 1024) {
            itemsPerView = 4;
        } else if (width >= 640) {
            itemsPerView = 2;
        } else {
            itemsPerView = 1;
        }

        // Update width style of each slide
        slides.forEach(slide => {
            slide.style.width = (100 / itemsPerView) + '%';
        });

        const maxIndex = Math.max(0, totalSlides - itemsPerView);
        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        renderDots();
        updateSlider();
    }

    function getMaxIndex() {
        return Math.max(0, totalSlides - itemsPerView);
    }

    function renderDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        const maxIndex = getMaxIndex();

        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = (i === currentIndex)
                ? 'h-2 w-8 rounded-full bg-pink-500 shadow-md shadow-pink-500/50 transition-all duration-300 cursor-pointer'
                : 'h-2 w-2 rounded-full bg-gray-700 hover:bg-gray-500 transition-all duration-300 cursor-pointer';
            dot.setAttribute('aria-label', 'Go to slide page ' + (i + 1));
            dot.addEventListener('click', function () {
                currentIndex = i;
                updateSlider();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateSlider() {
        const maxIndex = getMaxIndex();
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const shiftPercentage = currentIndex * (100 / itemsPerView);
        track.style.transform = 'translateX(-' + shiftPercentage + '%)';

        // Update dots
        if (dotsContainer) {
            const dots = dotsContainer.querySelectorAll('button');
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.className = 'h-2 w-8 rounded-full bg-pink-500 shadow-md shadow-pink-500/50 transition-all duration-300 cursor-pointer';
                } else {
                    dot.className = 'h-2 w-2 rounded-full bg-gray-700 hover:bg-gray-500 transition-all duration-300 cursor-pointer';
                }
            });
        }

        // Update showing count
        if (showingCount) {
            showingCount.textContent = Math.min(itemsPerView, totalSlides);
        }

        // Update disabled state on buttons if needed
        if (prevBtn) prevBtn.disabled = (totalSlides <= itemsPerView);
        if (nextBtn) nextBtn.disabled = (totalSlides <= itemsPerView);
    }

    function nextSlide() {
        const maxIndex = getMaxIndex();
        if (maxIndex <= 0) return;
        currentIndex = (currentIndex >= maxIndex) ? 0 : currentIndex + 1;
        updateSlider();
    }

    function prevSlide() {
        const maxIndex = getMaxIndex();
        if (maxIndex <= 0) return;
        currentIndex = (currentIndex <= 0) ? maxIndex : currentIndex - 1;
        updateSlider();
    }

    function startAutoSlide() {
        stopAutoSlide();
        autoSlideTimer = setInterval(function () {
            if (!isPaused) {
                nextSlide();
            }
        }, 4200);
    }

    function stopAutoSlide() {
        if (autoSlideTimer) {
            clearInterval(autoSlideTimer);
            autoSlideTimer = null;
        }
    }

    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prevSlide();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            nextSlide();
        });
    }

    if (pauseBtn) {
        pauseBtn.addEventListener('click', function () {
            isPaused = !isPaused;
            if (isPaused) {
                pauseIcon.classList.add('hidden');
                playIcon.classList.remove('hidden');
                pauseBtn.title = 'Resume auto-slider';
            } else {
                pauseIcon.classList.remove('hidden');
                playIcon.classList.add('hidden');
                pauseBtn.title = 'Pause auto-slider';
            }
        });
    }

    if (section) {
        section.addEventListener('mouseenter', function () {
            isPaused = true;
        });
        section.addEventListener('mouseleave', function () {
            if (!pauseBtn || pauseIcon.classList.contains('hidden') === false) {
                isPaused = false;
            }
        });
    }

    // Initialize
    calculateItemsPerView();
    window.addEventListener('resize', calculateItemsPerView);
    startAutoSlide();
});
</script>

<!-- Words From Our Families / Parent Reflections (SS 1 Reference Design) -->
<?php if (!empty($testimonials)):
$testHeading = $sections['testimonials']['heading'] ?? 'Words From Our Families';
$testSubheading = $sections['testimonials']['subheading'] ?? '';
$testBadge = !empty($sections['testimonials']['content']) ? $sections['testimonials']['content'] : 'PARENT REFLECTIONS';
?>
<section id="parent-reflections-section" class="py-16 sm:py-24 bg-[#fafbfc] relative overflow-hidden select-none w-full">
    <!-- Ambient Dreamy Glows matching SS 1 -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 right-1/12 w-[480px] h-[480px] bg-amber-200/30 rounded-full blur-[140px]"></div>
        <div class="absolute -bottom-24 left-1/12 w-[480px] h-[480px] bg-purple-200/30 rounded-full blur-[140px]"></div>
    </div>

    <!-- Padding exactly matching Services, Disciplines & Stage Moments section -->
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14 space-y-2">
            <div class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-white border border-slate-200/90 text-[10px] sm:text-[11px] font-bold text-slate-600 uppercase tracking-widest shadow-xs">
                <span><?= htmlspecialchars($testBadge, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-snug">
                <?= htmlspecialchars($testHeading, ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <?php if (!empty($testSubheading)): ?>
            <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto leading-relaxed">
                <?= htmlspecialchars($testSubheading, ENT_QUOTES, 'UTF-8') ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- 3-Column Testimonial Cards Grid (3x2 6 Cards matching SS 1) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-7">
            <?php foreach ($testimonials as $t): ?>
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-[0_4px_24px_-4px_rgba(0,0,0,0.06)] hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between relative group">
                    <div>
                        <!-- Pink Quote Mark Icon in Top-Left -->
                        <div class="mb-3">
                            <svg class="w-7 h-7 text-pink-400 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>

                        <!-- Review Text -->
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal mb-6">
                            "<?= htmlspecialchars($t['review_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        </p>
                    </div>

                    <!-- Bottom Row: Person Details on Left, 5 Stars on Right -->
                    <div class="pt-4 border-t border-slate-100 flex items-end justify-between gap-3 mt-auto">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm leading-snug">
                                <?= htmlspecialchars($t['person_name'] ?? 'Parent', ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                            <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                                <?= htmlspecialchars($t['relation_or_role'] ?? 'Student', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                        <div class="flex items-center gap-0.5 text-amber-400 shrink-0 select-none">
                            <?php
                            $rating = (int)($t['rating'] ?? 5);
                            for ($i = 0; $i < $rating; $i++): ?>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Common Call to Action -->
<!-- <section class="py-16 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-center">
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
</section> -->

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
