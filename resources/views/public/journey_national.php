<?php
ob_start();

$pageTitle = !empty($page['title']) ? $page['title'] : 'Our National Journey';
$pageSubtitle = !empty($page['subtitle']) ? $page['subtitle'] : 'Showcasing the vibrant folk heritage of Gujarat on premier national stages, Rashtriya Lok Utsavs, and state festivals.';

// National Map & Showcase settings from CMS sections
$mapSec = $sections['national_map_showcase'] ?? [];
$mapData = !empty($mapSec['content']) ? json_decode($mapSec['content'], true) : [];
$heroBadge = $mapData['hero_badge'] ?? ($mapSec['subheading'] ?? 'Across India');
$mapHeading = $mapData['map_heading'] ?? ($mapSec['heading'] ?? 'Tours Across Major Indian States');
$mapBadge = $mapData['map_badge'] ?? 'National Map & Conclaves';
$mapBaseNote = $mapData['map_base_note'] ?? 'Base: Ahmedabad | Over 28+ National Festivals';
$ctaText = $mapData['cta_text'] ?? 'Want to see our international tours across 15+ world nations?';
$ctaUrl = $mapData['cta_url'] ?? '/journey/international';

// Key National Tour Destinations for SVG Map
$tourDestinations = [
    ['name' => 'Ahmedabad (HQ)', 'x' => 105, 'y' => 220, 'isHq' => true, 'state' => 'Gujarat'],
    ['name' => 'New Delhi', 'x' => 175, 'y' => 145, 'isHq' => false, 'state' => 'Delhi NCR'],
    ['name' => 'Surajkund', 'x' => 180, 'y' => 155, 'isHq' => false, 'state' => 'Haryana'],
    ['name' => 'Mumbai', 'x' => 125, 'y' => 275, 'isHq' => false, 'state' => 'Maharashtra'],
    ['name' => 'Jaipur', 'x' => 145, 'y' => 175, 'isHq' => false, 'state' => 'Rajasthan'],
    ['name' => 'Kolkata', 'x' => 295, 'y' => 225, 'isHq' => false, 'state' => 'West Bengal'],
    ['name' => 'Bengaluru', 'x' => 170, 'y' => 345, 'isHq' => false, 'state' => 'Karnataka'],
];

// Fallback events if database is empty
$displayEvents = !empty($events) ? $events : [
    [
        'id' => 1,
        'event_type' => 'NATIONAL',
        'title' => 'Delhi Republic Day National Cultural Conclave',
        'festival_name' => 'Rashtriya Lok Utsav',
        'country' => 'India',
        'city' => 'New Delhi',
        'year' => 2023,
        'description' => 'Represented Gujarat state folk traditions with 40 child artists at the National Cultural Conclave in the presence of national dignitaries.',
        'participants_count' => 40,
        'cover_image_url' => '/assets/national/year1.jpg',
    ],
    [
        'id' => 2,
        'event_type' => 'NATIONAL',
        'title' => 'All India Inter-State Folk Dance Festival',
        'festival_name' => 'Surajkund Crafts & Folk Mela',
        'country' => 'India',
        'city' => 'Haryana',
        'year' => 2022,
        'description' => 'Award-winning Gujarati Garba and Bhavai dance showcase featuring intricate footwork and traditional brass headgear.',
        'participants_count' => 32,
        'cover_image_url' => '/assets/national/year2.jpg',
    ],
    [
        'id' => 3,
        'event_type' => 'NATIONAL',
        'title' => 'Mumbai Cultural Conclave & Heritage Meet',
        'festival_name' => 'Maharashtra Cultural Exchange',
        'country' => 'India',
        'city' => 'Mumbai',
        'year' => 2019,
        'description' => 'Grand folk presentation demonstrating unity in diversity through collaborative child performances.',
        'participants_count' => 28,
        'cover_image_url' => '/assets/national/year3.jpg',
    ],
];
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-white">
    <!-- =========================================================================
        HERO BANNER: Across India & Our National Journey (SS 1 Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                <?= htmlspecialchars($heroBadge, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-300 max-w-2xl mx-auto font-normal">
                <?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 1: INDIA MAP & NATIONAL HERITAGE CONCLAVES (SS 1 & SS 2 Matching)
        ========================================================================= -->
    <section class="py-12 relative z-20 -mt-8 sm:-mt-12">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="max-w-5xl mx-auto rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden border-2 border-white/90 bg-gradient-to-br from-slate-900 via-gray-900 to-slate-950 text-white">
                
                <!-- Card Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 relative z-10">
                    <div class="space-y-1">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-[11px] font-black uppercase tracking-widest border border-amber-400/30">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            <?= htmlspecialchars($mapBadge, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-white">
                            <?= htmlspecialchars($mapHeading, ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                    </div>

                    <!-- Indian Flag Badge -->
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20 shrink-0">
                        <img
                            src="/assets/international/in.png"
                            alt="Indian Tricolor Flag"
                            class="w-12 h-8 rounded-lg object-cover shadow-sm border border-white/40"
                            onerror="this.src='/assets/about/founded-2002-stage.jpg';"
                        >
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-wider text-amber-300">Proudly Indian</p>
                            <p class="text-xs font-bold text-white">Gujarat Representation</p>
                        </div>
                    </div>
                </div>

                <!-- India Map Interactive SVG Container -->
                <div class="relative w-full h-[280px] sm:h-[320px] rounded-2xl bg-gradient-to-b from-slate-950/80 to-slate-900/80 border border-white/15 p-4 flex items-center justify-center overflow-hidden shadow-inner mb-6 relative z-10">
                    <svg
                        viewBox="0 0 400 450"
                        class="w-full h-full max-h-[300px] drop-shadow-[0_0_15px_rgba(245,158,11,0.25)]"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <defs>
                            <linearGradient id="natIndiaMapGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f59e0b" stop-opacity="0.45" />
                                <stop offset="50%" stop-color="#ffffff" stop-opacity="0.25" />
                                <stop offset="100%" stop-color="#10b981" stop-opacity="0.45" />
                            </linearGradient>
                        </defs>

                        <!-- India Stylized Map Path -->
                        <path
                            d="M 180,30 
                               C 185,25 195,20 200,28 
                               C 205,35 220,40 225,50 
                               C 230,60 215,75 210,85 
                               C 215,95 240,110 250,115 
                               C 265,120 280,125 305,130 
                               C 320,135 345,120 365,125 
                               C 380,130 385,145 375,155 
                               C 360,165 330,160 320,170 
                               C 310,180 300,200 290,215 
                               C 285,230 270,240 260,255 
                               C 245,280 230,310 215,350 
                               C 205,375 195,405 185,430 
                               C 180,435 175,430 170,415 
                               C 155,370 145,330 135,290 
                               C 125,260 115,245 95,240 
                               C 75,235 60,230 65,215 
                               C 70,200 95,190 105,180 
                               C 115,170 120,150 135,135 
                               C 145,120 160,95 165,70 
                               Z"
                            fill="url(#natIndiaMapGrad)"
                            stroke="rgba(255, 255, 255, 0.45)"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />

                        <!-- Connection lines radiating from Ahmedabad HQ (105, 220) -->
                        <?php foreach ($tourDestinations as $dest): ?>
                            <?php if (!$dest['isHq']): ?>
                                <line
                                    x1="105"
                                    y1="220"
                                    x2="<?= $dest['x'] ?>"
                                    y2="<?= $dest['y'] ?>"
                                    stroke="#f59e0b"
                                    stroke-width="1.5"
                                    stroke-dasharray="4,4"
                                    class="animate-pulse opacity-70"
                                />
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- Tour Pins & Labels -->
                        <?php foreach ($tourDestinations as $idx => $dest): ?>
                            <g class="cursor-pointer group">
                                <circle
                                    cx="<?= $dest['x'] ?>"
                                    cy="<?= $dest['y'] ?>"
                                    r="<?= $dest['isHq'] ? '10' : '6' ?>"
                                    fill="<?= $dest['isHq'] ? '#ec4899' : '#f59e0b' ?>"
                                    class="animate-ping opacity-60"
                                />
                                <circle
                                    cx="<?= $dest['x'] ?>"
                                    cy="<?= $dest['y'] ?>"
                                    r="<?= $dest['isHq'] ? '6' : '4' ?>"
                                    fill="<?= $dest['isHq'] ? '#f43f5e' : '#10b981' ?>"
                                    stroke="#ffffff"
                                    stroke-width="1.5"
                                />
                                <text
                                    x="<?= $dest['x'] + 8 ?>"
                                    y="<?= $dest['y'] + 4 ?>"
                                    fill="#ffffff"
                                    font-size="<?= $dest['isHq'] ? '11' : '9' ?>"
                                    font-weight="<?= $dest['isHq'] ? '900' : '700' ?>"
                                    class="drop-shadow-md select-none"
                                >
                                    <?= htmlspecialchars($dest['name'], ENT_QUOTES, 'UTF-8') ?>
                                </text>
                            </g>
                        <?php endforeach; ?>
                    </svg>

                    <!-- Base note bottom pill -->
                    <div class="absolute bottom-2.5 left-3 px-3 py-1 rounded-lg bg-gray-950/80 backdrop-blur-sm border border-white/20 text-[10px] font-bold text-gray-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span><?= htmlspecialchars($mapBaseNote, ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>

                <!-- Bottom CTA row -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/15 pt-5 relative z-10">
                    <p class="text-xs text-gray-300 text-center sm:text-left">
                        <?= htmlspecialchars($ctaText, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <a
                        href="<?= htmlspecialchars($ctaUrl, ENT_QUOTES, 'UTF-8') ?>"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-900 text-xs font-black uppercase tracking-wider hover:bg-gray-100 transition-all hover:scale-105 shadow-md shrink-0"
                    >
                        <span>View International Journey</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 2: 3-COLUMN NATIONAL TOURS GRID (SS 2 & SS 3 Matching)
        ========================================================================= -->
    <section class="py-12 sm:py-20 relative overflow-hidden bg-gradient-to-b from-amber-50/40 via-rose-50/30 to-slate-50">
        <!-- Ambient Blooms -->
        <div class="absolute top-1/4 -left-24 w-[500px] h-[500px] bg-amber-400/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-24 w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($displayEvents as $index => $evt): ?>
                    <?php
                    $displayImage = !empty($evt['cover_image_url']) ? $evt['cover_image_url'] : '/assets/gallery/' . (($index % 8) + 1) . '.jpg';
                    $cityName = !empty($evt['city']) ? $evt['city'] : 'India';
                    $locationLabel = !empty($evt['city']) ? "{$evt['city']}, " . ($evt['country'] ?? 'India') : ($evt['country'] ?? 'India');
                    if (empty($evt['city']) && !empty($evt['country'])) {
                        $locationLabel = ", " . $evt['country'];
                    }
                    $yearText = !empty($evt['year']) ? $evt['year'] : '2026';
                    ?>
                    <div class="group relative rounded-3xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2.5 hover:shadow-[0_25px_50px_-12px_rgba(245,158,11,0.35)] border border-white/90 overflow-hidden bg-white/95 backdrop-blur-md shadow-md">
                        
                        <!-- Top Color Accent Bar -->
                        <div class="absolute top-0 inset-x-0 h-2.5 bg-gradient-to-r from-amber-500 via-orange-400 to-pink-500 rounded-t-3xl shadow-xs"></div>

                        <div class="space-y-4 relative z-10 pt-1">
                            <!-- Stage Image with Zoom Lightbox -->
                            <div
                                onclick="openTourLightbox('<?= htmlspecialchars($displayImage, ENT_QUOTES, 'UTF-8') ?>')"
                                class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border-2 border-white/80 shadow-md cursor-pointer group/img"
                            >
                                <img
                                    src="<?= htmlspecialchars($displayImage, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($evt['title'] ?? 'National Tour', ENT_QUOTES, 'UTF-8') ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-108"
                                    onerror="this.src='/assets/gallery/<?= ($index % 8) + 1 ?>.jpg';"
                                >

                                <!-- State / India badge on image -->
                                <div class="absolute top-3 left-3 p-1 rounded-lg bg-gray-950/75 backdrop-blur-xs border border-white/30 shadow-md flex items-center gap-1.5 px-2 z-10">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                    <span class="text-[10px] font-black text-white"><?= htmlspecialchars($cityName, ENT_QUOTES, 'UTF-8') ?></span>
                                </div>

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gray-950/50 backdrop-blur-xs opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white gap-2 font-bold text-xs">
                                    <svg class="h-5 w-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    <span>View Photo</span>
                                </div>
                            </div>

                            <!-- Metadata Badges Row -->
                            <div class="flex items-center justify-between text-xs pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-bold uppercase tracking-wider text-[11px] border backdrop-blur-md bg-amber-100/90 text-amber-800 border-amber-300">
                                    <svg class="h-3 w-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span><?= htmlspecialchars($locationLabel, ENT_QUOTES, 'UTF-8') ?></span>
                                </span>
                                <span class="flex items-center gap-1 font-bold text-gray-600">
                                    <svg class="h-3.5 w-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <?= htmlspecialchars((string)$yearText, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>

                            <!-- Event Title -->
                            <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-pink-600 transition-colors leading-snug line-clamp-2">
                                <?= htmlspecialchars($evt['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>

                            <!-- Event Subtitle / Festival Name -->
                            <?php if (!empty($evt['festival_name'])): ?>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider truncate">
                                    EVENT: <?= htmlspecialchars($evt['festival_name'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 leading-relaxed font-normal line-clamp-3">
                                <?= htmlspecialchars($evt['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-4 mt-4 border-t border-gray-100/80 flex items-center justify-between relative z-10">
                            <button
                                type="button"
                                onclick="openTourLightbox('<?= htmlspecialchars($displayImage, ENT_QUOTES, 'UTF-8') ?>')"
                                class="inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-pink-600 hover:text-pink-800 transition-colors cursor-pointer"
                            >
                                <span>View Photo</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </button>
                            <?php if (!empty($evt['participants_count'])): ?>
                                <span class="text-[11px] font-bold text-gray-500 bg-gray-100/80 px-2.5 py-0.5 rounded-full border border-gray-200">
                                    <?= (int)$evt['participants_count'] ?> Artists
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        LIGHTBOX PHOTO PREVIEW MODAL
        ========================================================================= -->
    <div
        id="tourLightboxModal"
        onclick="closeTourLightbox()"
        class="hidden fixed inset-0 z-50 bg-gray-950/90 backdrop-blur-sm flex items-center justify-center p-4 sm:p-8"
    >
        <div
            onclick="event.stopPropagation()"
            class="relative max-w-4xl max-h-[90vh] bg-gray-900 rounded-3xl overflow-hidden shadow-2xl p-2 border border-gray-800"
        >
            <button
                type="button"
                onclick="closeTourLightbox()"
                class="absolute top-4 right-4 z-10 p-2 rounded-full bg-gray-950/70 text-white hover:bg-pink-600 transition-colors cursor-pointer"
                title="Close Lightbox"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img
                id="tourLightboxImg"
                src=""
                alt="National Tour Photo Preview"
                class="w-full h-auto max-h-[80vh] object-contain rounded-2xl mx-auto"
            >
        </div>
    </div>
</div>

<script>
function openTourLightbox(src) {
    var modal = document.getElementById('tourLightboxModal');
    var img = document.getElementById('tourLightboxImg');
    if (modal && img) {
        img.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeTourLightbox() {
    var modal = document.getElementById('tourLightboxModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTourLightbox();
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
