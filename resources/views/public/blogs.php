<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Articles & Insights</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">Dance Stories</h1>
        <p class="text-slate-300 text-sm">Educational perspectives on folk tradition, child wellness, and dance discipline.</p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($blogs as $b): ?>
                <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col">
                    <?php if (!empty($b['featured_image_url'])): ?>
                        <div class="h-48 bg-slate-100 overflow-hidden">
                            <img src="<?= htmlspecialchars($b['featured_image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block"><?= htmlspecialchars($b['category'] ?? 'Dance Education', ENT_QUOTES, 'UTF-8') ?></span>
                            <h2 class="font-serif font-bold text-lg text-slate-900 leading-snug">
                                <a href="/blogs/<?= htmlspecialchars($b['slug'], ENT_QUOTES, 'UTF-8') ?>" class="hover:text-amber-600 transition-colors">
                                    <?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h2>
                            <p class="text-slate-600 text-xs leading-relaxed line-clamp-3">
                                <?= htmlspecialchars(strip_tags($b['excerpt'] ?? $b['content']), ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>By <?= htmlspecialchars($b['author_name'] ?? 'Academy Team', ENT_QUOTES, 'UTF-8') ?></span>
                            <a href="/blogs/<?= htmlspecialchars($b['slug'], ENT_QUOTES, 'UTF-8') ?>" class="font-bold text-amber-600 hover:text-amber-700">Read Article →</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
