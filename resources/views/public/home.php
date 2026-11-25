<?php
ob_start();
?>
<!-- Hero Section — Image-Focused Responsive Carousel -->
<section class="relative bg-slate-50/70 py-6 sm:py-8 overflow-hidden border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php
        $slides = !empty($heroImages) ? $heroImages : [
            ['url' => '/assets/banners/homebanner.jpg', 'title' => 'Dynamic Children Academy Performance'],
            ['url' => '/assets/about/academy_group.jpg', 'title' => 'Cultural Dance Troupe'],
            ['url' => '/assets/about/founded-2002-stage.jpg', 'title' => 'Traditional Heritage Stage Showcase'],
            ['url' => '/assets/about/dance-teaching-steps.jpg', 'title' => 'Mastery & Technique Training'],
            ['url' => '/assets/gallery/1.jpg', 'title' => 'Folk Dance Troupe'],
            ['url' => '/assets/gallery/2.jpg', 'title' => 'Classical Garba & Raas'],
        ];
        // Ensure at least 3 slides for desktop display
        while (count($slides) < 3) {
            $slides = array_merge($slides, $slides);
        }
        ?>
        <div class="relative group" id="hero-carousel-container" aria-label="Hero Image Carousel">
            <!-- Carousel Track Window -->
            <div class="overflow-hidden rounded-2xl shadow-sm">
                <div id="hero-slider-track" class="flex transition-transform duration-700 ease-out" style="transform: translateX(0%);">
                    <?php foreach ($slides as $index => $item): ?>
                    <div class="hero-carousel-item flex-shrink-0 px-2 box-border transition-all duration-300">
                        <!-- Elegant Purple-to-Pink Gradient Border Wrapper -->
                        <div class="p-[2.5px] rounded-2xl bg-gradient-to-r from-purple-600 via-fuchsia-500 to-pink-500 shadow-md hover:shadow-xl transition-shadow duration-300 h-[280px] sm:h-[350px] md:h-[390px] lg:h-[420px]">
                            <div class="w-full h-full bg-slate-900 rounded-[14px] overflow-hidden relative">
                                <img src="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"
                                     alt="<?= htmlspecialchars($item['title'] ?? 'Dynamic Children Academy', ENT_QUOTES, 'UTF-8') ?>"
                                     loading="<?= $index < 3 ? 'eager' : 'lazy' ?>"
                                     class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                                     onerror="this.onerror=null;this.src='/assets/banners/homebanner.jpg';">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation Controls: Previous Button -->
            <button id="hero-prev-btn"
                    type="button"
                    class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-purple-600 shadow-lg border border-slate-200/80 flex items-center justify-center transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-400 opacity-90 hover:opacity-100"
                    aria-label="Previous Slide">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Navigation Controls: Next Button -->
            <button id="hero-next-btn"
                    type="button"
                    class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-30 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/90 hover:bg-white text-slate-700 hover:text-purple-600 shadow-lg border border-slate-200/80 flex items-center justify-center transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-400 opacity-90 hover:opacity-100"
                    aria-label="Next Slide">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Pagination Dots -->
            <div id="hero-pagination-dots" class="flex justify-center items-center gap-2 mt-4 sm:mt-5" role="tablist" aria-label="Carousel pagination">
                <!-- Injected via JavaScript based on page count -->
            </div>
        </div>
    </div>
</section>

<!-- Heading Immediately Below Hero -->
<section class="bg-white py-8 sm:py-12 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-2xl sm:text-[26px] font-bold text-slate-800 tracking-tight leading-snug">
            Culture Is a <span class="text-amber-500 font-extrabold">Way of Life</span>
        </h2>
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
                    <img src="<?= htmlspecialchars($sections['about_intro']['image_url'] ?? '/assets/about/director.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="Director Shri Tirthraj Trivedi" class="w-full h-auto object-cover" loading="lazy">
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

<!-- Hero Section Responsive Carousel JavaScript & Dynamic Styling -->
<style>
/* Hero Carousel Layout Proportions */
/* Desktop: 3 images (Left smaller ~28%, Center smaller ~28%, Right wider ~44%) */
@media (min-width: 1024px) {
    .hero-carousel-item.pos-0 { width: 28%; }
    .hero-carousel-item.pos-1 { width: 28%; }
    .hero-carousel-item.pos-2 { width: 44%; }
    .hero-carousel-item.pos-other { width: 28%; }
}
/* Tablet: 2 images (50% each) */
@media (min-width: 640px) and (max-width: 1023px) {
    .hero-carousel-item { width: 50% !important; }
}
/* Mobile: 1 image (100% full width) */
@media (max-width: 639px) {
    .hero-carousel-item { width: 100% !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('hero-slider-track');
    const container = document.getElementById('hero-carousel-container');
    const prevBtn = document.getElementById('hero-prev-btn');
    const nextBtn = document.getElementById('hero-next-btn');
    const dotsContainer = document.getElementById('hero-pagination-dots');

    if (!track || !container) return;

    const items = Array.from(track.getElementsByClassName('hero-carousel-item'));
    const totalItems = items.length;
    if (totalItems === 0) return;

    let currentIndex = 0;
    let autoPlayTimer = null;

    function getVisibleCount() {
        const w = window.innerWidth;
        if (w >= 1024) return 3;
        if (w >= 640) return 2;
        return 1;
    }

    function applyItemClasses() {
        const visible = getVisibleCount();
        items.forEach((item, idx) => {
            item.classList.remove('pos-0', 'pos-1', 'pos-2', 'pos-other');
            if (visible === 3) {
                const rel = (idx - currentIndex + totalItems) % totalItems;
                if (rel === 0) item.classList.add('pos-0');
                else if (rel === 1) item.classList.add('pos-1');
                else if (rel === 2) item.classList.add('pos-2');
                else item.classList.add('pos-other');
            }
        });
    }

    function renderDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalItems; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'w-2.5 h-2.5 rounded-full transition-all duration-300 ' +
                (i === currentIndex ? 'bg-gradient-to-r from-purple-600 to-pink-500 w-7' : 'bg-slate-300 hover:bg-slate-400');
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.addEventListener('click', () => {
                goToSlide(i);
                restartAutoPlay();
            });
            dotsContainer.appendChild(dot);
        }
    }

    function updateTrack() {
        const visible = getVisibleCount();
        applyItemClasses();

        // Calculate translation offset based on the current slide's offsetLeft
        if (items[currentIndex]) {
            const offset = items[currentIndex].offsetLeft;
            track.style.transform = `translateX(-${offset}px)`;
        }

        // Update dots
        if (dotsContainer) {
            const dots = dotsContainer.children;
            for (let i = 0; i < dots.length; i++) {
                if (i === currentIndex) {
                    dots[i].className = 'w-7 h-2.5 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 transition-all duration-300';
                } else {
                    dots[i].className = 'w-2.5 h-2.5 rounded-full bg-slate-300 hover:bg-slate-400 transition-all duration-300';
                }
            }
        }
    }

    function goToSlide(index) {
        currentIndex = (index + totalItems) % totalItems;
        updateTrack();
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

    window.addEventListener('resize', () => {
        updateTrack();
    });

    renderDots();
    updateTrack();
    startAutoPlay();
});
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
