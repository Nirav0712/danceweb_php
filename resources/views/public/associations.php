<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Cultural Partnerships</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">Affiliations & Recognitions</h1>
        <p class="text-slate-300 text-sm">Partnering with national cultural councils and international folk dance confederations.</p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($associations as $assoc): ?>
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center space-y-4 shadow-xs">
                    <img src="<?= htmlspecialchars($assoc['logo_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($assoc['name'], ENT_QUOTES, 'UTF-8') ?>" class="h-24 w-auto mx-auto object-contain">
                    <h3 class="font-serif font-bold text-lg text-slate-900"><?= htmlspecialchars($assoc['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="text-slate-600 text-xs leading-relaxed"><?= htmlspecialchars($assoc['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
