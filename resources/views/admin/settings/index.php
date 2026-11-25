<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Academy Settings & Global SEO</h1>
            <p class="text-xs text-slate-500 mt-1">Configure academy name, director details, phone numbers, and social URLs</p>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
        <form method="POST" action="/admin/settings" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($settings as $st): ?>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">
                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $st['setting_key'])), ENT_QUOTES, 'UTF-8') ?>
                        <span class="text-[10px] text-slate-400 font-mono font-normal">(<?= htmlspecialchars($st['setting_key'], ENT_QUOTES, 'UTF-8') ?>)</span>
                    </label>
                    <?php if ($st['description']): ?>
                        <p class="text-[11px] text-slate-400 mb-1"><?= htmlspecialchars($st['description'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                    
                    <?php if ($st['setting_type'] === 'JSON' || strlen($st['setting_value'] ?? '') > 80): ?>
                        <textarea name="settings[<?= htmlspecialchars($st['setting_key'], ENT_QUOTES, 'UTF-8') ?>]" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-mono outline-none"><?= htmlspecialchars($st['setting_value'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    <?php else: ?>
                        <input type="text" name="settings[<?= htmlspecialchars($st['setting_key'], ENT_QUOTES, 'UTF-8') ?>]" value="<?= htmlspecialchars($st['setting_value'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
                    Save Academy Settings
                </button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
