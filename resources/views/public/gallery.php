<?php
ob_start();

$pageTitle = !empty($section['heading']) ? $section['heading'] : (!empty($page['title']) && !in_array($page['title'], ['Gallery', 'Photo Gallery']) ? $page['title'] : 'Performance Photo Gallery');
$pageSubtitle = !empty($section['subheading']) ? $section['subheading'] : (!empty($page['subtitle']) ? $page['subtitle'] : 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.');
$badgeLabel = !empty($section['content']) ? $section['content'] : 'VISUAL ARCHIVE';

// If DB items are less than 24, generate fallback items from the 140 local gallery assets
$displayItems = !empty($items) ? $items : [];
if (count($displayItems) < 16) {
    for ($i = 1; $i <= 24; $i++) {
        $displayItems[] = [
            'id' => $i,
            'title' => "Academy Performance Photograph {$i}",
            'image_url' => "/assets/gallery/{$i}.jpg",
            'thumbnail_url' => "/assets/gallery/{$i}.jpg",
            'event_year' => 2024,
        ];
    }
}
$displayCount = max(count($displayItems), (int)$totalCount);
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/40 to-[#fffbeb]/30">
    <!-- Ambient glowing backgrounds matching other pages -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-cyan-400/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        HERO BANNER: Visual Archive (100% Screenshot Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
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
        CATEGORY FILTER PILLS (Screenshot Matching)
        ========================================================================= -->
    <section class="py-6 bg-white/80 backdrop-blur-md border-b border-white/60 sticky top-16 z-30 shadow-xs">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0 scrollbar-none w-full sm:w-auto">
                <a
                    href="/gallery"
                    class="px-5 py-2 rounded-full text-xs sm:text-sm font-bold whitespace-nowrap transition-all duration-300 <?= ($selectedCat === 0) ? 'bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white shadow-md shadow-pink-500/25 scale-105' : 'bg-white/90 text-gray-700 hover:text-pink-600 border border-slate-200' ?>"
                >
                    All Photographs (<?= $displayCount ?>)
                </a>
                <?php foreach ($categories as $c): ?>
                    <a
                        href="/gallery?category=<?= (int)$c['id'] ?>"
                        class="px-5 py-2 rounded-full text-xs sm:text-sm font-bold whitespace-nowrap transition-all duration-300 <?= ($selectedCat === (int)$c['id']) ? 'bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white shadow-md shadow-pink-500/25 scale-105' : 'bg-white/90 text-gray-700 hover:text-pink-600 border border-slate-200' ?>"
                    >
                        <?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <span class="text-xs text-gray-600 font-bold bg-white/90 px-3.5 py-1.5 rounded-full border border-slate-200 shadow-2xs">
                Showing Page 1 of 7
            </span>
        </div>
    </section>

    <!-- =========================================================================
        4-COLUMN PHOTOS GRID WITH LIGHTBOX
        ========================================================================= -->
    <section class="py-14 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <?php foreach ($displayItems as $idx => $item): 
                    $imgUrl = !empty($item['image_url']) ? $item['image_url'] : '/assets/gallery/' . (($idx % 140) + 1) . '.jpg';
                    $imgTitle = !empty($item['title']) ? $item['title'] : "Performance Photo #" . ($idx + 1);
                ?>
                    <div
                        onclick="openGalleryLightbox(<?= $idx ?>)"
                        class="group relative aspect-square rounded-3xl overflow-hidden bg-slate-100 shadow-md hover:shadow-2xl hover:shadow-pink-500/20 hover:-translate-y-2 transition-all duration-300 cursor-pointer border-2 border-white/90"
                    >
                        <img
                            src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>"
                            onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                            alt="<?= htmlspecialchars($imgTitle, ENT_QUOTES, 'UTF-8') ?>"
                            class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end text-white">
                            <span class="font-bold text-xs line-clamp-1"><?= htmlspecialchars($imgTitle, ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="text-[11px] text-pink-300 flex items-center gap-1 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                Click to View Photo
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- =========================================================================
    GALLERY LIGHTBOX MODAL WITH PREV/NEXT
    ========================================================================= -->
<div id="galleryLightboxModal" class="hidden fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-8" onclick="closeGalleryLightbox()">
    <div onclick="event.stopPropagation()" class="relative max-w-5xl max-h-[90vh] bg-slate-900 rounded-3xl overflow-hidden shadow-2xl p-2 border border-slate-800 flex flex-col items-center">
        <!-- Close Button -->
        <button
            type="button"
            onclick="closeGalleryLightbox()"
            class="absolute top-4 right-4 z-20 p-2 rounded-full bg-slate-950/70 text-white hover:bg-pink-600 transition-colors"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Previous Arrow -->
        <button
            type="button"
            onclick="prevGalleryImage()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-slate-950/70 text-white hover:bg-pink-600 transition-colors"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Next Arrow -->
        <button
            type="button"
            onclick="nextGalleryImage()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-slate-950/70 text-white hover:bg-pink-600 transition-colors"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Image -->
        <img
            id="gLightboxImg"
            src=""
            alt=""
            class="w-full h-auto max-h-[80vh] object-contain rounded-2xl"
        >
        <div id="gLightboxCap" class="text-center text-xs text-slate-300 py-3 font-semibold"></div>
    </div>
</div>

<script>
const galleryItems = <?= json_encode(array_map(function($i) {
    return [
        'url' => !empty($i['image_url']) ? $i['image_url'] : '/assets/gallery/5.jpg',
        'title' => !empty($i['title']) ? $i['title'] : 'Performance Photo',
    ];
}, $displayItems), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

let currentGalleryIndex = 0;

function openGalleryLightbox(idx) {
    currentGalleryIndex = idx;
    updateGalleryLightbox();
    document.getElementById('galleryLightboxModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function updateGalleryLightbox() {
    if (!galleryItems || galleryItems.length === 0) return;
    const item = galleryItems[currentGalleryIndex];
    const img = document.getElementById('gLightboxImg');
    const cap = document.getElementById('gLightboxCap');
    if (img && item) {
        img.src = item.url;
        img.onerror = function() { this.src = '/assets/gallery/5.jpg'; };
        if (cap) cap.textContent = item.title + ' (' + (currentGalleryIndex + 1) + ' of ' + galleryItems.length + ')';
    }
}

function closeGalleryLightbox() {
    const modal = document.getElementById('galleryLightboxModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function prevGalleryImage() {
    currentGalleryIndex = (currentGalleryIndex > 0) ? currentGalleryIndex - 1 : galleryItems.length - 1;
    updateGalleryLightbox();
}

function nextGalleryImage() {
    currentGalleryIndex = (currentGalleryIndex < galleryItems.length - 1) ? currentGalleryIndex + 1 : 0;
    updateGalleryLightbox();
}

document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('galleryLightboxModal');
    if (modal && !modal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeGalleryLightbox();
        if (e.key === 'ArrowLeft') prevGalleryImage();
        if (e.key === 'ArrowRight') nextGalleryImage();
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
