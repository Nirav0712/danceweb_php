<?php
ob_start();
?>
<!-- Page Hero Banner -->
<section class="bg-slate-900 text-white py-16 sm:py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl mx-auto space-y-4">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Heritage & Vision</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold"><?= htmlspecialchars($page['title'] ?? 'About Dynamice Children Academy', ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
            <?= htmlspecialchars($page['subtitle'] ?? 'Founded with an enduring passion to preserve, teach, and elevate the rich folk traditions of Gujarat onto national and global platforms.', ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>
</section>

<!-- Academy History & Foundation -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Our Founding Story</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">25+ Years of Cultural Devotion</h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Under the visionary guidance of <?= htmlspecialchars($settings['director_name'] ?? 'Shri Tirthraj Trivedi', ENT_QUOTES, 'UTF-8') ?>, Dynamice Children Academy started as a passionate cultural initiative to impart classical discipline and lively folk dance technique to children.
                </p>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Over two and a half decades, the academy has trained over 15,000 students, earned coveted Limca Book and Golden Book of World Records citations, and represented the Republic of India at international dance competitions across Europe and Asia.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="font-serif font-bold text-2xl text-amber-600 block"><?= htmlspecialchars($settings['founding_year'] ?? '1998', ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="text-xs text-slate-500 font-medium">Inception Year</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="font-serif font-bold text-2xl text-amber-600 block">2</span>
                        <span class="text-xs text-slate-500 font-medium">Premier Ahmedabad Studios</span>
                    </div>
                </div>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                <img src="<?= htmlspecialchars($page['banner_image_url'] ?? '/assets/about/academy_group.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="Academy Dancers" class="w-full h-auto object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Affiliations & Accreditations -->
<?php if (!empty($associations)): ?>
<section class="py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Recognitions</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Affiliations & Partners</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <?php foreach ($associations as $assoc): ?>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center space-y-3 shadow-xs">
                    <img src="<?= htmlspecialchars($assoc['logo_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($assoc['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="h-16 w-auto mx-auto object-contain">
                    <h3 class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($assoc['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="text-slate-500 text-xs"><?= htmlspecialchars($assoc['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
