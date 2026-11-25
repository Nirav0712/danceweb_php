<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Visual Portfolio</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">Photo & Performance Gallery</h1>
        <p class="text-slate-300 text-sm">Glimpses of stage performances, state competitions, and international tours.</p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category Filter Tabs -->
        <div class="flex items-center justify-center gap-2 flex-wrap mb-12">
            <a href="/gallery" class="px-4 py-2 rounded-xl text-xs font-bold transition-all <?= ($selectedCat === 0) ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' ?>">
                All Categories
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/gallery?category=<?= (int) $cat['id'] ?>" class="px-4 py-2 rounded-xl text-xs font-bold transition-all <?= ($selectedCat === (int) $cat['id']) ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' ?>">
                    <?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($items as $item): ?>
                <div class="group relative rounded-2xl overflow-hidden aspect-square bg-slate-200 shadow-xs border border-slate-200">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Performance Photo', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end text-white">
                        <span class="font-semibold text-xs"><?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
