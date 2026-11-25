<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <?php if (!empty($page['subtitle'])): ?>
            <span class="text-xs font-bold text-amber-400 uppercase tracking-widest"><?= htmlspecialchars($page['subtitle'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold"><?= htmlspecialchars($page['title'] ?? 'Custom Page', ENT_QUOTES, 'UTF-8') ?></h1>
    </div>
</section>

<section class="py-16 bg-white min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <?php if (!empty($page['banner_image_url'])): ?>
            <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                <img src="<?= htmlspecialchars($page['banner_image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($page['title'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-auto object-cover max-h-96" loading="lazy">
            </div>
        <?php endif; ?>

        <?php if (!empty($sections)): ?>
            <?php foreach ($sections as $section): ?>
                <div class="prose max-w-none mb-8">
                    <?php if (!empty($section['heading'])): ?>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2"><?= htmlspecialchars($section['heading'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($section['subheading'])): ?>
                        <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mb-4"><?= htmlspecialchars($section['subheading'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <?php endif; ?>
                    <div class="text-slate-600 leading-relaxed text-sm">
                        <?= $section['content'] ?? '' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="prose max-w-none text-slate-600 text-sm leading-relaxed">
                <p><?= htmlspecialchars($page['meta_description'] ?? 'Welcome to Dynamice Children Academy.', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
