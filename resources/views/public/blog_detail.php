<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest"><?= htmlspecialchars($blog['category'] ?? 'Dance Story', ENT_QUOTES, 'UTF-8') ?></span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold max-w-3xl mx-auto"><?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <div class="flex items-center justify-center gap-3 text-xs text-slate-400 pt-2">
            <span>By <?= htmlspecialchars($blog['author_name'] ?? 'Dynamice Team', ENT_QUOTES, 'UTF-8') ?></span>
            <span>•</span>
            <span><?= htmlspecialchars(date('M d, Y', strtotime($blog['published_at'] ?? 'now')), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    </div>
</section>

<section class="py-16 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($blog['featured_image_url'])): ?>
            <div class="rounded-3xl overflow-hidden shadow-lg mb-10 border border-slate-100">
                <img src="<?= htmlspecialchars($blog['featured_image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-auto object-cover" loading="lazy">
            </div>
        <?php endif; ?>

        <div class="prose prose-slate lg:prose-lg max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-6">
            <?= nl2br(htmlspecialchars($blog['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-200 flex items-center justify-between">
            <a href="/blogs" class="inline-flex items-center gap-2 text-xs font-bold text-amber-600 hover:text-amber-700">
                <span>← Back to All Dance Stories</span>
            </a>
            <a href="/contact" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-all">
                Join a Dance Batch
            </a>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
