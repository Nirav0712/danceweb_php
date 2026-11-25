<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Media Clippings</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">National Press Coverage</h1>
        <p class="text-slate-300 text-sm">Newspaper reports and media features covering academy performances in India.</p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($news as $item): ?>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-shadow">
                    <?php if (!empty($item['image_url'])): ?>
                        <div class="h-64 bg-slate-100 overflow-hidden">
                            <img src="<?= htmlspecialchars($item['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['headline'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-xs font-semibold text-amber-600">
                            <span><?= htmlspecialchars($item['publication_name'] ?? 'Newspaper', ENT_QUOTES, 'UTF-8') ?></span>
                            <span><?= htmlspecialchars(date('M Y', strtotime($item['publish_date'] ?? 'now')), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <h3 class="font-serif font-bold text-lg text-slate-900"><?= htmlspecialchars($item['headline'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-slate-600 text-xs leading-relaxed"><?= htmlspecialchars($item['summary'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
