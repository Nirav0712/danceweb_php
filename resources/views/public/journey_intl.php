<?php
ob_start();

$pageTitle = !empty($page['title']) ? $page['title'] : 'International Journey';
$pageSubtitle = !empty($page['subtitle']) ? $page['subtitle'] : 'Participated in international folklore festivals in the last 12 years all over the world, representing Indian heritage with UNESCO partner affiliations.';

$sectionKey = 'international_map_showcase';
$mapSec = $sections[$sectionKey] ?? [];
$mapData = !empty($mapSec['content']) ? json_decode($mapSec['content'], true) : [];

$heroBadge = $mapData['hero_badge'] ?? ($mapSec['subheading'] ?? 'Global Representation Across 15+ Nations');

// 15 Countries Mapping with authentic flags from /assets/international/
$countryFlagsMap = [
    'ca' => ['name' => 'Canada', 'flag' => '/assets/international/ca.png', 'aliases' => ['canada', 'ca']],
    'gb' => ['name' => 'United Kingdom', 'flag' => '/assets/international/gb.png', 'aliases' => ['united kingdom', 'uk', 'gb', 'england', 'britain', 'london']],
    'fr' => ['name' => 'France', 'flag' => '/assets/international/fr.png', 'aliases' => ['france', 'fr', 'paris']],
    'es' => ['name' => 'Spain', 'flag' => '/assets/international/es.png', 'aliases' => ['spain', 'es', 'barcelona']],
    'cz' => ['name' => 'Czech Republic', 'flag' => '/assets/international/cz.png', 'aliases' => ['czech republic', 'czech', 'cz', 'prague']],
    'pl' => ['name' => 'Poland', 'flag' => '/assets/international/pl.png', 'aliases' => ['poland', 'pl', 'krakow']],
    'ch' => ['name' => 'Switzerland', 'flag' => '/assets/international/ch.png', 'aliases' => ['switzerland', 'ch', 'geneva', 'swiss']],
    'de' => ['name' => 'Germany', 'flag' => '/assets/international/de.png', 'aliases' => ['germany', 'de', 'berlin']],
    'tr' => ['name' => 'Turkey', 'flag' => '/assets/international/tr.png', 'aliases' => ['turkey', 'tr', 'istanbul']],
    'om' => ['name' => 'Oman', 'flag' => '/assets/international/om.png', 'aliases' => ['oman', 'om', 'muscat']],
    'ae' => ['name' => 'United Arab Emirates', 'flag' => '/assets/international/ae.png', 'aliases' => ['united arab emirates', 'uae', 'ae', 'dubai']],
    'cn' => ['name' => 'China', 'flag' => '/assets/international/cn.png', 'aliases' => ['china', 'cn', 'shanghai', 'beijing']],
    'th' => ['name' => 'Thailand', 'flag' => '/assets/international/th.png', 'aliases' => ['thailand', 'th', 'bangkok']],
    'my' => ['name' => 'Malaysia', 'flag' => '/assets/international/my.png', 'aliases' => ['malaysia', 'my', 'kuala lumpur']],
    'sg' => ['name' => 'Singapore', 'flag' => '/assets/international/sg.png', 'aliases' => ['singapore', 'sg']],
];

// Fallback international events from React archive
$allFallbackEvents = [
    [
        'id' => 101,
        'event_type' => 'INTERNATIONAL',
        'title' => 'London Book of World Records Cultural Tour',
        'festival_name' => 'UK International Youth Dance Conclave',
        'country' => 'United Kingdom',
        'country_code' => 'GB',
        'city' => 'London',
        'year' => 2023,
        'description' => 'Historical performance at premier auditoriums in London, officially recognized in the London Book of World Records for mass youth synchronization in traditional Gujarati Garba and Folk attire.',
        'participants_count' => 35,
        'cover_image_url' => '/assets/homepage/2025UK.jpeg',
    ],
    [
        'id' => 102,
        'event_type' => 'INTERNATIONAL',
        'title' => 'International Youth Folklore Festival',
        'festival_name' => 'UNESCO CIOFF World Folklore Utsav',
        'country' => 'Turkey',
        'country_code' => 'TR',
        'city' => 'Istanbul',
        'year' => 2022,
        'description' => 'Performed authentic Gujarati Garba and Bhavai on European stages representing India in collaboration with CIOFF UNESCO accredited partners.',
        'participants_count' => 25,
        'cover_image_url' => '/assets/international/turkey.jpg',
    ],
    [
        'id' => 103,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Paris International Folklore Rendezvous',
        'festival_name' => 'Festival International de Folklore CIOFF France',
        'country' => 'France',
        'country_code' => 'FR',
        'city' => 'Paris',
        'year' => 2021,
        'description' => 'Represented Indian folk arts and mythological mudras before international delegations and European cultural institutions.',
        'participants_count' => 22,
        'cover_image_url' => '/assets/gallery/2.jpg',
    ],
    [
        'id' => 104,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Indo-Arab Cultural Heritage Conclave',
        'festival_name' => 'Dubai International Dance Meet',
        'country' => 'United Arab Emirates',
        'country_code' => 'AE',
        'city' => 'Dubai',
        'year' => 2019,
        'description' => 'Showcased traditional Indian folk dance before the international diaspora, earning accolades for precision coordination.',
        'participants_count' => 20,
        'cover_image_url' => '/assets/international/dubai.jpg',
    ],
    [
        'id' => 105,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Toronto International Children Folk Festival',
        'festival_name' => 'Canada World Folk Utsav',
        'country' => 'Canada',
        'country_code' => 'CA',
        'city' => 'Toronto',
        'year' => 2023,
        'description' => 'Presented authentic Gujarati Garba, Dandiya, and Bhavai at Toronto and Vancouver community amphitheaters to standing ovations.',
        'participants_count' => 30,
        'cover_image_url' => '/assets/gallery/1.jpg',
    ],
    [
        'id' => 106,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Barcelona Mediterranean Folk Arts Festival',
        'festival_name' => 'Festival de Danza Infantil de Espana',
        'country' => 'Spain',
        'country_code' => 'ES',
        'city' => 'Barcelona',
        'year' => 2020,
        'description' => 'Vibrant inter-cultural presentation celebrating rhythm, hand-prop choreography, and Indian folk traditions on Mediterranean stages.',
        'participants_count' => 24,
        'cover_image_url' => '/assets/gallery/3.jpg',
    ],
    [
        'id' => 107,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Prague Folklore Days Festival',
        'festival_name' => 'International Folklore Assembly',
        'country' => 'Czech Republic',
        'country_code' => 'CZ',
        'city' => 'Prague',
        'year' => 2019,
        'description' => 'Showcasing authentic Gujarati costumes, brass pot balances, and rhythmic footwork to thousands of international attendees in Prague.',
        'participants_count' => 26,
        'cover_image_url' => '/assets/gallery/4.jpg',
    ],
    [
        'id' => 108,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Krakow International Folklore Gala',
        'festival_name' => 'Polonia Cultural Exchange',
        'country' => 'Poland',
        'country_code' => 'PL',
        'city' => 'Krakow',
        'year' => 2019,
        'description' => 'Ensemble recitals demonstrating India’s unity in diversity and traditional folk expressions with certified accolades.',
        'participants_count' => 22,
        'cover_image_url' => '/assets/gallery/5.jpg',
    ],
    [
        'id' => 109,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Geneva Inter-Cultural Peace Assembly',
        'festival_name' => 'Swiss Global Folklore Forum',
        'country' => 'Switzerland',
        'country_code' => 'CH',
        'city' => 'Geneva',
        'year' => 2019,
        'description' => 'Special invitation presentation highlighting the spiritual and meditative dimensions of traditional Indian dance.',
        'participants_count' => 18,
        'cover_image_url' => '/assets/gallery/6.jpg',
    ],
    [
        'id' => 110,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Berlin International Youth Carnival of Cultures',
        'festival_name' => 'Karneval der Kulturen',
        'country' => 'Germany',
        'country_code' => 'DE',
        'city' => 'Berlin',
        'year' => 2018,
        'description' => 'High-energy Bollywood and traditional Dandiya performances acclaimed for precision and exuberant stage dynamism.',
        'participants_count' => 28,
        'cover_image_url' => '/assets/gallery/7.jpg',
    ],
    [
        'id' => 111,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Muscat Cultural Heritage Conclave',
        'festival_name' => 'Indo-Oman Heritage Festival',
        'country' => 'Oman',
        'country_code' => 'OM',
        'city' => 'Muscat',
        'year' => 2017,
        'description' => 'Cultural diplomatic performance before community leaders and international delegations in Muscat.',
        'participants_count' => 16,
        'cover_image_url' => '/assets/gallery/8.jpg',
    ],
    [
        'id' => 112,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Beijing & Shanghai Youth Dance Forum',
        'festival_name' => 'Asian International Folk Festival',
        'country' => 'China',
        'country_code' => 'CN',
        'city' => 'Shanghai',
        'year' => 2016,
        'description' => 'A milestone tour bridging Asian heritage arts through dynamic group Garba and semi-classical choreographies.',
        'participants_count' => 20,
        'cover_image_url' => '/assets/gallery/bd10.JPG',
    ],
    [
        'id' => 113,
        'event_type' => 'INTERNATIONAL',
        'title' => 'South-East Asian Youth Dance Assembly',
        'festival_name' => 'Bangkok International Arts Forum',
        'country' => 'Thailand',
        'country_code' => 'TH',
        'city' => 'Bangkok',
        'year' => 2018,
        'description' => 'Cultural exchange program presenting Gujarati folk artistry and Rajasthani Ghoomar to Asian cultural delegations.',
        'participants_count' => 18,
        'cover_image_url' => '/assets/international/thailand.jpg',
    ],
    [
        'id' => 114,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Kuala Lumpur Asian Folklore Gala',
        'festival_name' => 'Malaysian Heritage Arts Festival',
        'country' => 'Malaysia',
        'country_code' => 'MY',
        'city' => 'Kuala Lumpur',
        'year' => 2015,
        'description' => 'Celebrating shared cultural rhythms with youth ensembles across South-East Asia.',
        'participants_count' => 16,
        'cover_image_url' => '/assets/gallery/fd1.jpg',
    ],
    [
        'id' => 115,
        'event_type' => 'INTERNATIONAL',
        'title' => 'Singapore Asian Youth Arts Conclave',
        'festival_name' => 'Global Singapore Arts Exchange',
        'country' => 'Singapore',
        'country_code' => 'SG',
        'city' => 'Singapore',
        'year' => 2015,
        'description' => 'International platform showcasing Indian folk expressions to an enthusiastic global audience in Singapore.',
        'participants_count' => 18,
        'cover_image_url' => '/assets/gallery/cd1.jpg',
    ],
];

// Combine DB events with fallbacks to guarantee rich 15-nation tour showcase
$dbCodes = [];
foreach ($events as $dbEvt) {
    if (!empty($dbEvt['country_code'])) {
        $dbCodes[] = strtolower($dbEvt['country_code']);
    } elseif (!empty($dbEvt['country'])) {
        $dbCodes[] = strtolower($dbEvt['country']);
    }
}

$displayEvents = $events;
foreach ($allFallbackEvents as $fb) {
    $fbCode = strtolower($fb['country_code'] ?? '');
    $fbCountry = strtolower($fb['country'] ?? '');
    if (!in_array($fbCode, $dbCodes, true) && !in_array($fbCountry, $dbCodes, true)) {
        $displayEvents[] = $fb;
    }
}
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-white">
    <!-- =========================================================================
        HERO BANNER: International Journey & Global Representation (SS 1 Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                <?= htmlspecialchars($heroBadge, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-300 max-w-3xl mx-auto font-normal">
                <?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 1: GLOBAL ACCREDITATIONS BAR (SS 1 Matching)
        ========================================================================= -->
    <section class="bg-gradient-to-r from-amber-50/60 via-white to-amber-50/60 text-slate-800 py-5 border-b border-rose-100/80 shadow-xs relative z-20">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-[11px] sm:text-xs font-black uppercase tracking-wider text-slate-700">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-pink-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span>CIOFF - OFFICIAL PARTNER OF UNESCO</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span>IOV - INTERNATIONAL ORGANIZATION OF FOLK ART</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span>IAF - INTERNATIONAL ASSOCIATION OF FOLKLORE</span>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 2: 15 COUNTRIES QUICK FILTER SELECTOR BAR (SS 1 Matching)
        ========================================================================= -->
    <section class="py-6 bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-16 z-30 shadow-xs">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex items-center justify-between gap-4 mb-3">
                <div class="flex items-center gap-2 text-xs font-black uppercase tracking-wider text-pink-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>SELECT COUNTRY TO FILTER TOUR PHOTOS:</span>
                </div>

                <button
                    type="button"
                    id="resetFilterBtn"
                    onclick="filterByCountry(null)"
                    class="hidden inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100 text-pink-700 hover:bg-pink-200 text-xs font-bold transition-colors cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Show All 15 Countries</span>
                </button>
            </div>

            <!-- Horizontal Country Pills Slider -->
            <div class="flex items-center gap-2.5 overflow-x-auto pb-2 scrollbar-none">
                <button
                    type="button"
                    id="btn-all-tours"
                    onclick="filterByCountry(null)"
                    class="country-filter-pill px-4 py-2 rounded-xl text-xs font-bold tracking-wider shrink-0 transition-all cursor-pointer bg-pink-600 text-white shadow-md scale-105"
                >
                    All Tours (<span id="visible-count"><?= count($displayEvents) ?></span>)
                </button>

                <?php foreach ($countryFlagsMap as $code => $cData): ?>
                    <button
                        type="button"
                        id="btn-country-<?= $code ?>"
                        onclick="filterByCountry('<?= $code ?>', '<?= htmlspecialchars($cData['name'], ENT_QUOTES, 'UTF-8') ?>', '<?= $cData['flag'] ?>')"
                        class="country-filter-pill inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl shrink-0 transition-all text-xs font-bold cursor-pointer bg-white hover:bg-slate-50 text-slate-800 border border-slate-200/80 shadow-xs"
                    >
                        <img
                            src="<?= $cData['flag'] ?>"
                            alt="<?= htmlspecialchars($cData['name'], ENT_QUOTES, 'UTF-8') ?>"
                            class="w-5 h-3.5 object-cover rounded-xs border border-slate-200 shrink-0"
                            onerror="this.src='/assets/about/founded-2002-stage.jpg';"
                        >
                        <span><?= htmlspecialchars($cData['name'], ENT_QUOTES, 'UTF-8') ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Active Country Filter Notification Banner (Revealed via JS) -->
    <div id="activeCountryBanner" class="hidden w-full px-3 sm:px-6 lg:px-8 xl:px-12 pt-8">
        <div class="max-w-5xl mx-auto p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-pink-50 via-white to-purple-50 border-2 border-pink-400 shadow-xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img
                    id="activeCountryFlag"
                    src=""
                    alt=""
                    class="w-12 h-8 rounded-lg object-cover shadow-sm border border-white/80 shrink-0"
                >
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-pink-600">Active Country Filter</p>
                    <h3 id="activeCountryTitle" class="text-lg font-black text-slate-900">
                        International Tour Archive
                    </h3>
                </div>
            </div>

            <button
                type="button"
                onclick="filterByCountry(null)"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-slate-900 text-white text-xs font-bold hover:bg-pink-600 transition-colors shadow-sm cursor-pointer shrink-0"
            >
                <span>View All Countries</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <!-- =========================================================================
        SECTION 3: 3-COLUMN INTERNATIONAL TOURS GRID (SS 1 & SS 2 Matching)
        ========================================================================= -->
    <section class="py-12 sm:py-20 relative overflow-hidden bg-gradient-to-b from-amber-50/40 via-rose-50/30 to-purple-50/30">
        <!-- Ambient Blooms -->
        <div class="absolute top-1/4 -left-24 w-[500px] h-[500px] bg-cyan-400/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-24 w-[500px] h-[500px] bg-purple-500/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div id="intlTourGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($displayEvents as $index => $evt): ?>
                    <?php
                    $countryName = !empty($evt['country']) ? $evt['country'] : 'International';
                    $countryCode = !empty($evt['country_code']) ? strtolower($evt['country_code']) : '';
                    if (empty($countryCode)) {
                        // Attempt to resolve from country name
                        $cLower = strtolower($countryName);
                        foreach ($countryFlagsMap as $cKey => $cMeta) {
                            foreach ($cMeta['aliases'] as $alias) {
                                if (strpos($cLower, $alias) !== false) {
                                    $countryCode = $cKey;
                                    break 2;
                                }
                            }
                        }
                    }

                    $displayImage = !empty($evt['cover_image_url']) ? $evt['cover_image_url'] : '/assets/gallery/' . (($index % 8) + 1) . '.jpg';
                    $locationLabel = !empty($evt['city']) ? "{$evt['city']}, " . ($evt['country'] ?? '') : ($evt['country'] ?? '');
                    if (empty($evt['city']) && !empty($evt['country'])) {
                        $locationLabel = ", " . strtoupper($evt['country']);
                    }
                    $yearText = !empty($evt['year']) ? $evt['year'] : '2026';
                    $participantsCount = !empty($evt['participants_count']) ? (int)$evt['participants_count'] : null;
                    ?>
                    <div
                        class="intl-tour-card group relative rounded-3xl p-6 flex flex-col justify-between transition-all duration-500 hover:-translate-y-2.5 hover:shadow-[0_25px_50px_-12px_rgba(236,72,153,0.35)] border border-white/90 overflow-hidden bg-white/95 backdrop-blur-md shadow-md"
                        data-country-code="<?= htmlspecialchars($countryCode, ENT_QUOTES, 'UTF-8') ?>"
                        data-country-name="<?= htmlspecialchars(strtolower($countryName), ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <!-- Top Color Accent Bar (SS 2 Matching pink/purple gradient) -->
                        <div class="absolute top-0 inset-x-0 h-2.5 bg-gradient-to-r from-pink-500 via-rose-400 to-purple-600 rounded-t-3xl shadow-xs"></div>

                        <div class="space-y-4 relative z-10 pt-1">
                            <!-- Stage Image with Zoom Lightbox -->
                            <div
                                onclick="openTourLightbox('<?= htmlspecialchars($displayImage, ENT_QUOTES, 'UTF-8') ?>')"
                                class="relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border-2 border-white/80 shadow-md cursor-pointer group/img"
                            >
                                <img
                                    src="<?= htmlspecialchars($displayImage, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($evt['title'] ?? 'International Tour', ENT_QUOTES, 'UTF-8') ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-108"
                                    onerror="this.src='/assets/gallery/<?= ($index % 8) + 1 ?>.jpg';"
                                >

                                <!-- Country / Location badge on image -->
                                <div class="absolute top-3 left-3 p-1 rounded-lg bg-gray-950/75 backdrop-blur-xs border border-white/30 shadow-md flex items-center gap-1.5 px-2 z-10">
                                    <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
                                    <span class="text-[10px] font-black text-white uppercase"><?= htmlspecialchars($countryName, ENT_QUOTES, 'UTF-8') ?></span>
                                </div>

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gray-950/50 backdrop-blur-xs opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white gap-2 font-bold text-xs">
                                    <svg class="h-5 w-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    <span>View Photo</span>
                                </div>
                            </div>

                            <!-- Metadata Badges Row (SS 2 Matching) -->
                            <div class="flex items-center justify-between text-xs pt-1">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-bold uppercase tracking-wider text-[11px] border backdrop-blur-md bg-pink-50 text-pink-700 border-pink-200">
                                    <svg class="h-3 w-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span><?= htmlspecialchars($locationLabel, ENT_QUOTES, 'UTF-8') ?></span>
                                </span>
                                <span class="flex items-center gap-1 font-bold text-gray-600">
                                    <svg class="h-3.5 w-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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
                                    FESTIVAL: <?= htmlspecialchars($evt['festival_name'], ENT_QUOTES, 'UTF-8') ?>
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
                            <?php if (!empty($participantsCount)): ?>
                                <span class="text-[11px] font-bold text-gray-500 bg-gray-100/80 px-2.5 py-0.5 rounded-full border border-gray-200">
                                    <?= $participantsCount ?> Delegates
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty Filter State -->
            <div id="noToursFound" class="hidden text-center py-16">
                <div class="w-16 h-16 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center mx-auto mb-4 text-2xl font-bold">🌍</div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Tours Found for this Country</h3>
                <p class="text-xs text-slate-500 mb-4">We are expanding our international archive constantly.</p>
                <button type="button" onclick="filterByCountry(null)" class="px-4 py-2 bg-pink-600 text-white rounded-xl text-xs font-bold shadow-md cursor-pointer">
                    View All Countries
                </button>
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
                alt="International Tour Photo Preview"
                class="w-full h-auto max-h-[80vh] object-contain rounded-2xl mx-auto"
            >
        </div>
    </div>
</div>

<script>
// Interactive Country Filter
function filterByCountry(code, name, flag) {
    var cards = document.querySelectorAll('.intl-tour-card');
    var activeBanner = document.getElementById('activeCountryBanner');
    var resetBtn = document.getElementById('resetFilterBtn');
    var noFound = document.getElementById('noToursFound');
    var countEl = document.getElementById('visible-count');

    // Update pill styles
    document.querySelectorAll('.country-filter-pill').forEach(function(btn) {
        btn.classList.remove('bg-pink-600', 'text-white', 'shadow-md', 'scale-105', 'border-2', 'border-white');
        btn.classList.add('bg-white', 'hover:bg-slate-50', 'text-slate-800', 'border', 'border-slate-200/80', 'shadow-xs');
    });

    var visibleCount = 0;

    if (!code) {
        // Show all
        cards.forEach(function(card) {
            card.classList.remove('hidden');
            visibleCount++;
        });

        var allBtn = document.getElementById('btn-all-tours');
        if (allBtn) {
            allBtn.classList.remove('bg-white', 'text-slate-800');
            allBtn.classList.add('bg-pink-600', 'text-white', 'shadow-md', 'scale-105');
        }

        if (activeBanner) activeBanner.classList.add('hidden');
        if (resetBtn) resetBtn.classList.add('hidden');
        if (noFound) noFound.classList.add('hidden');

        // Update URL query
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({path:newurl}, '', newurl);
        }
    } else {
        var lowerCode = code.toLowerCase();
        cards.forEach(function(card) {
            var cCode = (card.getAttribute('data-country-code') || '').toLowerCase();
            var cName = (card.getAttribute('data-country-name') || '').toLowerCase();
            if (cCode === lowerCode || cName.indexOf(lowerCode) !== -1 || (name && cName.indexOf(name.toLowerCase()) !== -1)) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        var activeBtn = document.getElementById('btn-country-' + lowerCode);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'text-slate-800');
            activeBtn.classList.add('bg-pink-600', 'text-white', 'shadow-md', 'scale-105', 'border-2', 'border-white');
        }

        if (activeBanner) {
            activeBanner.classList.remove('hidden');
            document.getElementById('activeCountryFlag').src = flag || '';
            document.getElementById('activeCountryTitle').textContent = (name || code.toUpperCase()) + ' International Tour Archive';
        }

        if (resetBtn) resetBtn.classList.remove('hidden');
        if (noFound) {
            if (visibleCount === 0) noFound.classList.remove('hidden');
            else noFound.classList.add('hidden');
        }

        // Update URL query
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?country=' + encodeURIComponent(lowerCode);
            window.history.pushState({path:newurl}, '', newurl);
        }
    }

    if (countEl) countEl.textContent = visibleCount;
}

// Check initial query parameter
(function() {
    var params = new URLSearchParams(window.location.search);
    var country = params.get('country');
    if (country) {
        var targetBtn = document.getElementById('btn-country-' + country.toLowerCase());
        if (targetBtn) {
            targetBtn.click();
        }
    }
})();

// Lightbox
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
