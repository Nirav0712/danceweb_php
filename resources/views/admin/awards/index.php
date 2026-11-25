<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Awards & Limca / Golden Book Records</h1>
            <p class="text-xs text-slate-500 mt-1">Manage recognitions, world records, and certifications</p>
        </div>
        <button onclick="document.getElementById('createAwardModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Award
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Year</th>
                    <th class="px-6 py-3.5">Award Title</th>
                    <th class="px-6 py-3.5">Issuer</th>
                    <th class="px-6 py-3.5">Type</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($awards as $a): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-bold text-indigo-600 font-mono"><?= (int)$a['year'] ?></td>
                    <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($a['title'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($a['issuer'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $a['is_record_book'] ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'bg-slate-100 text-slate-700' ?>">
                            <?= $a['is_record_book'] ? '★ World Record' : 'Award' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form method="POST" action="/admin/awards/<?= $a['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this award?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="createAwardModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Award / Record</h3>
        <form method="POST" action="/admin/awards" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Issuer / Authority</label>
                <input type="text" name="issuer" required placeholder="e.g. Limca Book of Records, UNESCO" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" placeholder="e.g. Record, Trophy" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="is_record_book" class="rounded border-slate-300 text-indigo-600">
                    Record Book (Limca/Golden)
                </label>
                <label class="flex items-center gap-2 text-xs text-slate-600">
                    <input type="checkbox" name="is_featured" checked class="rounded border-slate-300 text-indigo-600">
                    Featured
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createAwardModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Award</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
