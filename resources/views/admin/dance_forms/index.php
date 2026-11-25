<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dance Forms & Curriculum</h1>
            <p class="text-xs text-slate-500 mt-1">Manage individual dance courses, syllabus, and target age groups</p>
        </div>
        <button onclick="document.getElementById('createFormModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Dance Form
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Dance Form</th>
                    <th class="px-6 py-3.5">Category</th>
                    <th class="px-6 py-3.5">Age Group</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($forms as $f): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        <div><?= htmlspecialchars($f['name'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="text-[11px] text-slate-400"><?= htmlspecialchars($f['tagline'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            <?= htmlspecialchars($f['category_name'] ?? 'General', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($f['target_age_group'] ?? 'All Ages', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 <?= $f['is_active'] ? 'text-emerald-700' : 'text-slate-400' ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?= $f['is_active'] ? 'bg-emerald-500' : 'bg-slate-300' ?>"></span>
                            <?= $f['is_active'] ? 'Active' : 'Disabled' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form method="POST" action="/admin/dance-forms/<?= $f['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this dance form?');">
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

<div id="createFormModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Dance Form</h3>
        <form method="POST" action="/admin/dance-forms" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                <select name="category_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Name</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tagline</label>
                <input type="text" name="tagline" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Target Age Group</label>
                <input type="text" name="target_age_group" placeholder="e.g. 5-15 years" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Description / Curriculum</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isActForm" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isActForm" class="text-xs text-slate-600">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createFormModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Form</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
