<?php
ob_start();

$pageTitle = !empty($page['title']) ? $page['title'] : (!empty($section['heading']) ? $section['heading'] : 'National News & Media');
$pageSubtitle = !empty($page['subtitle']) ? $page['subtitle'] : (!empty($section['subheading']) ? $section['subheading'] : 'Press clippings and national print media coverage celebrating our performances and world record events.');
$badgeLabel = !empty($section['content']) ? $section['content'] : 'IN THE HEADLINES';

// Fallback news items matching screenshot if database is empty
$displayNews = !empty($news) ? $news : [
    [
        'id' => 1,
        'headline' => 'Test Press Release',
        'publication_name' => 'Punjab Kesari',
        'publish_date' => '2026-11-25',
        'summary' => 'Dynamice Children Academy child artists recognized for premier national cultural folk performances.',
        'image_url' => '/assets/gallery/5.jpg',
    ],
    [
        'id' => 2,
        'headline' => 'Test Press Release',
        'publication_name' => 'Punjab Kesari',
        'publish_date' => '2026-11-25',
        'summary' => 'Dynamice Children Academy child artists recognized for premier national cultural folk performances.',
        'image_url' => '/assets/gallery/6.jpg',
    ],
    [
        'id' => 3,
        'headline' => 'Test Press Release',
        'publication_name' => 'Punjab Kesari',
        'publish_date' => '2026-11-25',
        'summary' => 'Dynamice Children Academy child artists recognized for premier national cultural folk performances.',
        'image_url' => '/assets/gallery/1.jpg',
    ],
];
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/40 to-[#fffbeb]/30">
    <!-- Ambient glowing backgrounds matching other pages -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-amber-400/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        HERO BANNER: In The Headlines (100% Screenshot Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
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
        MAIN NEWS LIST: 3-Column Newspaper Clippings Grid
        ========================================================================= -->
    <section class="py-16 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <?php if (!empty($displayNews)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($displayNews as $idx => $item): 
                        $imgUrl = !empty($item['image_url']) ? $item['image_url'] : '/assets/gallery/' . (($idx % 8) + 1) . '.jpg';
                        $pubName = !empty($item['publication_name']) ? $item['publication_name'] : 'Punjab Kesari';
                        $pubDate = !empty($item['publish_date']) ? date('M j, Y', strtotime($item['publish_date'])) : date('M j, Y');
                        $headline = !empty($item['headline']) ? $item['headline'] : 'Test Press Release';
                    ?>
                        <article class="bg-white/95 backdrop-blur-md rounded-3xl border border-white/90 shadow-xl hover:shadow-2xl hover:shadow-pink-500/15 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group overflow-hidden relative">
                            <div>
                                <!-- Newspaper Clipping Preview with Lightbox Zoom -->
                                <div
                                    onclick="openLightbox('<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars(addslashes($headline), ENT_QUOTES, 'UTF-8') ?>')"
                                    class="aspect-[4/3] bg-slate-100 overflow-hidden relative cursor-pointer group/img border-b border-white/80"
                                >
                                    <img
                                        src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>"
                                        onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                                        alt="<?= htmlspecialchars($headline, ENT_QUOTES, 'UTF-8') ?>"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-105"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-xs opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center text-white gap-2 font-bold text-xs">
                                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        <span>View Newspaper Clipping</span>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6 sm:p-7 space-y-3">
                                    <div class="flex items-center justify-between text-xs text-slate-500">
                                        <span class="inline-flex items-center gap-1.5 font-bold text-pink-600 bg-pink-50 px-3 py-1 rounded-full border border-pink-200 text-xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            <?= htmlspecialchars($pubName, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                        <span class="flex items-center gap-1 font-semibold text-slate-500">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <?= htmlspecialchars($pubDate, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </div>

                                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-pink-600 transition-colors leading-snug">
                                        <?= htmlspecialchars($headline, ENT_QUOTES, 'UTF-8') ?>
                                    </h2>

                                    <?php if (!empty($item['summary'])): ?>
                                        <p class="text-sm text-slate-600 leading-relaxed font-normal line-clamp-3">
                                            <?= htmlspecialchars($item['summary'], ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!empty($item['external_link'])): ?>
                                <div class="p-6 sm:p-7 pt-0">
                                    <a
                                        href="<?= htmlspecialchars($item['external_link'], ENT_QUOTES, 'UTF-8') ?>"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-pink-600 hover:text-pink-700 transition-colors"
                                    >
                                        <span>Read Original Source</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-white/80 rounded-3xl border border-slate-200 max-w-2xl mx-auto p-8 space-y-4">
                    <svg class="h-12 w-12 text-pink-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <h3 class="text-xl font-bold text-slate-900">National Press Coverage Archive</h3>
                    <p class="text-sm text-slate-600">
                        Newspaper articles and national press coverage clippings are being digitized and uploaded. Check back soon!
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- =========================================================================
    IMAGE LIGHTBOX MODAL (For Full Clipping View)
    ========================================================================= -->
<div id="imageLightboxModal" class="hidden fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-8" onclick="closeLightbox()">
    <div onclick="event.stopPropagation()" class="relative max-w-4xl max-h-[90vh] bg-slate-900 rounded-3xl overflow-hidden shadow-2xl p-2 border border-slate-800">
        <button
            type="button"
            onclick="closeLightbox()"
            class="absolute top-4 right-4 z-10 p-2 rounded-full bg-slate-950/70 text-white hover:bg-pink-600 transition-colors"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img
            id="lightboxImage"
            src=""
            alt="Press Clipping Preview"
            class="w-full h-auto max-h-[85vh] object-contain rounded-2xl"
        >
        <div id="lightboxCaption" class="text-center text-xs text-slate-300 py-2 font-medium"></div>
    </div>
</div>

<script>
function openLightbox(url, title) {
    const modal = document.getElementById('imageLightboxModal');
    const img = document.getElementById('lightboxImage');
    const cap = document.getElementById('lightboxCaption');
    if (modal && img) {
        img.src = url;
        img.onerror = function() { this.src = '/assets/gallery/5.jpg'; };
        if (cap) cap.textContent = title || '';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeLightbox() {
    const modal = document.getElementById('imageLightboxModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
