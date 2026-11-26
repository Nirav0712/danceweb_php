<?php
ob_start();

$imgUrl = !empty($blog['featured_image_url']) ? $blog['featured_image_url'] : '/assets/gallery/5.jpg';
$category = !empty($blog['category']) ? $blog['category'] : 'Culture';
$author = !empty($blog['author_name']) ? $blog['author_name'] : 'Director Tirthraj Trivedi';
$publishedDate = !empty($blog['published_at']) ? date('F j, Y', strtotime($blog['published_at'])) : date('F j, Y');
?>

<article class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/30 to-[#fffbeb]/20 pb-24">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-amber-400/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        ARTICLE HERO HEADER: Matching React BlogDetailPage
        ========================================================================= -->
    <header class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-16 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 max-w-4xl mx-auto text-center space-y-6 relative z-10">
            <div>
                <a
                    href="/blog"
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-pink-300 hover:text-white transition-colors border border-white/20 bg-white/10 backdrop-blur-md"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>All Articles</span>
                </a>
            </div>

            <div class="flex justify-center items-center gap-2">
                <span class="px-3.5 py-1 rounded-full text-xs font-extrabold tracking-wide bg-gradient-to-r from-pink-500/30 to-purple-500/30 text-pink-200 border border-pink-400/40">
                    <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                <?= htmlspecialchars($blog['title'] ?? 'Story Title', ENT_QUOTES, 'UTF-8') ?>
            </h1>

            <div class="flex items-center justify-center gap-6 text-xs text-gray-300 pt-2 font-medium">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <?= htmlspecialchars($author, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <?= htmlspecialchars($publishedDate, ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>
        </div>
    </header>

    <!-- =========================================================================
        FEATURED COVER IMAGE
        ========================================================================= -->
    <?php if (!empty($imgUrl)): ?>
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 max-w-4xl mx-auto -mt-10 relative z-20">
            <div class="aspect-[16/9] rounded-3xl overflow-hidden shadow-2xl p-2 border-2 border-white/80 bg-white/40 backdrop-blur-xl">
                <img
                    src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>"
                    onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                    alt="<?= htmlspecialchars($blog['title'] ?? 'Article Cover', ENT_QUOTES, 'UTF-8') ?>"
                    class="w-full h-full object-cover rounded-2xl"
                >
            </div>
        </div>
    <?php endif; ?>

    <!-- =========================================================================
        ARTICLE CONTENT BODY
        ========================================================================= -->
    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 max-w-4xl mx-auto pt-12 relative z-10">
        <?php if (!empty($blog['excerpt'])): ?>
            <div class="p-6 rounded-2xl bg-white/80 border-l-4 border-pink-500 shadow-xs mb-8">
                <p class="text-base sm:text-lg font-medium text-slate-700 italic leading-relaxed">
                    <?= htmlspecialchars($blog['excerpt'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="prose prose-slate lg:prose-lg max-w-none text-slate-800 leading-relaxed space-y-6 text-base sm:text-lg">
            <?= nl2br(htmlspecialchars($blog['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
        </div>

        <!-- =========================================================================
            BOTTOM NAVIGATION & CTA
            ========================================================================= -->
        <div class="mt-14 pt-8 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a
                href="/blog"
                class="inline-flex items-center gap-2 text-sm font-bold text-pink-600 hover:text-pink-700 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Return to All Dance Stories</span>
            </a>
            <a
                href="/contact"
                class="px-6 py-3 rounded-full bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 hover:opacity-95 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-pink-500/20 transition-all"
            >
                Enquire for Batch Admission →
            </a>
        </div>
    </div>
</article>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
