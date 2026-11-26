<?php
ob_start();

$pageTitle = !empty($page['title']) ? $page['title'] : 'Awards & World Records';
$pageSubtitle = !empty($page['subtitle']) ? $page['subtitle'] : 'Certified milestones honoring our child artists, Director Tirthraj Trivedi, and our mission to elevate Indian folk heritage.';
$badgeLabel = !empty($section['content']) && $section['content'] !== 'PRESTIGIOUS ACCREDITATIONS & HONORS' ? $section['content'] : 'ACHIEVEMENTS & ACCOLADES';

// Fallback awards if database is empty
$displayAwards = !empty($awards) ? $awards : [
    [
        'id' => 1,
        'title' => 'London Book of World Records Certificate',
        'issuer' => 'London Book of World Records',
        'category' => 'World Record',
        'year' => 2023,
        'description' => 'Official world record recognition for mass children cultural folk dance performance.',
        'certificate_image_url' => '/assets/awards/01.jpg',
        'is_record_book' => 1,
        'is_featured' => 1,
    ],
    [
        'id' => 2,
        'title' => 'World Records India Recognition',
        'issuer' => 'World Records India',
        'category' => 'World Record',
        'year' => 2022,
        'description' => 'Awarded for exceptional group choreography preserving Gujarati folk culture.',
        'certificate_image_url' => '/assets/awards/02.jpg',
        'is_record_book' => 1,
        'is_featured' => 1,
    ],
    [
        'id' => 3,
        'title' => 'Golden Book of World Records Honor',
        'issuer' => 'Golden Book of World Records',
        'category' => 'World Record',
        'year' => 2021,
        'description' => 'International recognition for youth dance excellence and traditional performing arts.',
        'certificate_image_url' => '/assets/awards/03.jpg',
        'is_record_book' => 1,
        'is_featured' => 1,
    ],
    [
        'id' => 4,
        'title' => 'National Cultural Heritage Excellence Award',
        'issuer' => 'Indian Cultural Association Partner',
        'category' => 'National Award',
        'year' => 2019,
        'description' => 'Best performing academy for youth traditional dance preservation.',
        'certificate_image_url' => '/assets/awards/04.jpg',
        'is_record_book' => 0,
        'is_featured' => 1,
    ],
];

$recordCount = 0;
$nationalCount = 0;
foreach ($displayAwards as $a) {
    if (!empty($a['is_record_book'])) {
        $recordCount++;
    } else {
        $nationalCount++;
    }
}
$totalCount = count($displayAwards);
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-white">
    <!-- =========================================================================
        HERO BANNER: Achievements & Accolades (Screenshot Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                <?= htmlspecialchars($badgeLabel, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-300 max-w-2xl mx-auto font-normal">
                <?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 1: 3 FILTER TABS (All Accolades / World Records / National Honors)
        ========================================================================= -->
    <section class="py-8 bg-gradient-to-b from-amber-50/70 via-rose-50/40 to-slate-50 relative z-20 border-b border-rose-100/60">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 flex justify-center flex-wrap gap-3">
            <button
                type="button"
                id="filter-btn-all"
                onclick="filterAwards('all')"
                class="award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white shadow-lg shadow-pink-500/30 scale-105"
            >
                All Accolades (<?= $totalCount ?>)
            </button>
            <button
                type="button"
                id="filter-btn-records"
                onclick="filterAwards('records')"
                class="award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-white hover:bg-slate-50 text-slate-700 border border-slate-200/80 shadow-xs"
            >
                World Records (<?= $recordCount ?>)
            </button>
            <button
                type="button"
                id="filter-btn-national"
                onclick="filterAwards('national')"
                class="award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-white hover:bg-slate-50 text-slate-700 border border-slate-200/80 shadow-xs"
            >
                National Honors (<?= $nationalCount ?>)
            </button>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 2: 3-COLUMN AWARDS & WORLD RECORDS GRID
        ========================================================================= -->
    <section class="py-12 sm:py-20 relative overflow-hidden bg-gradient-to-b from-slate-50 via-rose-50/20 to-amber-50/30">
        <!-- Ambient Blooms -->
        <div class="absolute top-1/4 -left-24 w-96 h-96 bg-amber-400/25 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-24 w-96 h-96 bg-pink-500/25 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div id="awardsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($displayAwards as $idx => $item): ?>
                    <?php
                    $isRecord = !empty($item['is_record_book']);
                    $cardType = $isRecord ? 'records' : 'national';
                    $certImg = !empty($item['certificate_image_url']) ? $item['certificate_image_url'] : '/assets/awards/' . sprintf('%02d', ($idx % 16) + 1) . '.jpg';
                    ?>
                    <div
                        class="award-card group relative rounded-3xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2.5 border border-white/90 overflow-hidden bg-white/95 backdrop-blur-md shadow-md <?= $isRecord ? 'hover:shadow-[0_25px_50px_-12px_rgba(245,158,11,0.4)]' : 'hover:shadow-[0_25px_50px_-12px_rgba(236,72,153,0.4)]' ?>"
                        data-type="<?= $cardType ?>"
                    >
                        <!-- Top Color Accent Bar (Amber/Gold for World Record, Pink/Purple for National Award) -->
                        <div class="absolute top-0 inset-x-0 h-2.5 rounded-t-3xl shadow-xs <?= $isRecord ? 'bg-gradient-to-r from-amber-500 via-yellow-400 to-orange-500' : 'bg-gradient-to-r from-pink-500 via-rose-400 to-purple-600' ?>"></div>

                        <div class="space-y-4 relative z-10 pt-1">
                            <!-- Certificate preview with Lightbox trigger -->
                            <div
                                onclick="openCertificateLightbox('<?= htmlspecialchars($certImg, ENT_QUOTES, 'UTF-8') ?>')"
                                class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border-2 border-white/80 shadow-md cursor-pointer group/img"
                            >
                                <img
                                    src="<?= htmlspecialchars($certImg, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-108"
                                    onerror="this.src='/assets/awards/01.jpg';"
                                >
                                <div class="absolute inset-0 bg-gray-950/50 backdrop-blur-xs opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white gap-2 font-bold text-xs">
                                    <svg class="h-5 w-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    <span>View Certificate</span>
                                </div>
                            </div>

                            <!-- Badges Row -->
                            <div class="flex items-center justify-between text-xs pt-1">
                                <span class="px-3 py-1 rounded-full font-bold uppercase tracking-wider text-[11px] border backdrop-blur-md <?= $isRecord ? 'bg-amber-100/90 text-amber-800 border-amber-300' : 'bg-pink-100/90 text-pink-700 border-pink-300' ?>">
                                    <?= $isRecord ? '🏆 World Record' : '🎖️ National Award' ?>
                                </span>
                                <span class="flex items-center gap-1 font-bold text-gray-600">
                                    <svg class="h-3.5 w-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <?= htmlspecialchars((string)($item['year'] ?? $item['year_awarded'] ?? '2026'), ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-pink-600 transition-colors leading-snug">
                                <?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>

                            <!-- Conferred by -->
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Conferred by: <?= htmlspecialchars($item['issuer'] ?? 'Council of Traditional Arts', ENT_QUOTES, 'UTF-8') ?>
                            </p>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 leading-relaxed font-normal">
                                <?= htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        CERTIFICATE LIGHTBOX PREVIEW MODAL
        ========================================================================= -->
    <div
        id="certLightboxModal"
        onclick="closeCertificateLightbox()"
        class="hidden fixed inset-0 z-50 bg-gray-950/90 backdrop-blur-sm flex items-center justify-center p-4 sm:p-8"
    >
        <div
            onclick="event.stopPropagation()"
            class="relative max-w-4xl max-h-[90vh] bg-gray-900 rounded-3xl overflow-hidden shadow-2xl p-2 border border-gray-800"
        >
            <button
                type="button"
                onclick="closeCertificateLightbox()"
                class="absolute top-4 right-4 z-10 p-2 rounded-full bg-gray-950/70 text-white hover:bg-pink-600 transition-colors cursor-pointer"
                title="Close Certificate"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img
                id="certLightboxImg"
                src=""
                alt="Certificate Preview"
                class="w-full h-auto max-h-[85vh] object-contain rounded-2xl mx-auto"
            >
        </div>
    </div>
</div>

<script>
// Filter Awards in Real-Time
function filterAwards(type) {
    var cards = document.querySelectorAll('.award-card');
    cards.forEach(function(card) {
        var cardType = card.getAttribute('data-type');
        if (type === 'all' || cardType === type) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });

    // Reset button styles
    var btnAll = document.getElementById('filter-btn-all');
    var btnRecords = document.getElementById('filter-btn-records');
    var btnNational = document.getElementById('filter-btn-national');

    [btnAll, btnRecords, btnNational].forEach(function(b) {
        if (!b) return;
        b.className = 'award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-white hover:bg-slate-50 text-slate-700 border border-slate-200/80 shadow-xs';
    });

    if (type === 'all' && btnAll) {
        btnAll.className = 'award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white shadow-lg shadow-pink-500/30 scale-105';
    } else if (type === 'records' && btnRecords) {
        btnRecords.className = 'award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30 scale-105';
    } else if (type === 'national' && btnNational) {
        btnNational.className = 'award-filter-btn px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 cursor-pointer bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-500/30 scale-105';
    }
}

// Certificate Lightbox
function openCertificateLightbox(src) {
    var modal = document.getElementById('certLightboxModal');
    var img = document.getElementById('certLightboxImg');
    if (modal && img) {
        img.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeCertificateLightbox() {
    var modal = document.getElementById('certLightboxModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertificateLightbox();
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
