<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Domestic Tours</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">National Journey</h1>
        <p class="text-slate-300 text-sm">Performances at youth festivals, conventions, and state celebrations across India.</p>
    </div>
</section>

<section class="py-16 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-8 max-w-4xl mx-auto">
            <?php foreach ($events as $event): ?>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-center">
                    <?php if (!empty($event['image_url'])): ?>
                        <div class="w-full sm:w-48 h-36 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            <img src="<?= htmlspecialchars($event['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-3 text-xs font-semibold text-amber-600">
                            <span>📍 <?= htmlspecialchars($event['city_or_state'] ?? 'India', ENT_QUOTES, 'UTF-8') ?></span>
                            <span>•</span>
                            <span><?= htmlspecialchars((string) ($event['event_year'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <h3 class="font-serif font-bold text-xl text-slate-900"><?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-slate-600 text-xs leading-relaxed"><?= htmlspecialchars($event['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
