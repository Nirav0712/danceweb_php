<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Navigation Menus</h1>
            <p class="text-xs text-slate-500 mt-1">Configure Header navbar and Footer links</p>
        </div>
        <button onclick="document.getElementById('createMenuModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Link
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Position</th>
                        <th class="px-6 py-3.5">Title</th>
                        <th class="px-6 py-3.5">Target URL</th>
                        <th class="px-6 py-3.5">Sort</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($menus as $m): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $m['position'] === 'HEADER' ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-700' ?>">
                                <?= htmlspecialchars($m['position'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($m['title'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="px-6 py-4 text-indigo-600 font-mono text-[11px]"><?= htmlspecialchars($m['url'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="px-6 py-4 text-slate-500 font-mono"><?= (int)$m['sort_order'] ?></td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="editMenu(<?= htmlspecialchars(json_encode($m), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                            <form method="POST" action="/admin/navigation/<?= $m['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this menu item?');">
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
</div>

<div id="createMenuModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Menu Item</h3>
        <form method="POST" action="/admin/navigation" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Position</label>
                <select name="position" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <option value="HEADER">Header Main Navigation</option>
                    <option value="FOOTER">Footer Links</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL (e.g. /about or https://...)</label>
                <input type="text" name="url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isAct" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isAct" class="text-xs text-slate-600">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createMenuModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Link</button>
            </div>
        </form>
    </div>
</div>

<div id="editMenuModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Menu Item</h3>
        <form id="editMenuForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Position</label>
                <select id="edit_m_position" name="position" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <option value="HEADER">Header Main Navigation</option>
                    <option value="FOOTER">Footer Links</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" id="edit_m_title" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">URL</label>
                <input type="text" id="edit_m_url" name="url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" id="edit_m_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_m_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                <label for="edit_m_is_active" class="text-xs text-slate-600">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editMenuModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Link</button>
            </div>
        </form>
    </div>
</div>

<script>
function editMenu(item) {
    document.getElementById('editMenuForm').action = '/admin/navigation/' + item.id + '/update';
    document.getElementById('edit_m_position').value = item.position || 'HEADER';
    document.getElementById('edit_m_title').value = item.title || '';
    document.getElementById('edit_m_url').value = item.url || '';
    document.getElementById('edit_m_sort_order').value = item.sort_order || 0;
    document.getElementById('edit_m_is_active').checked = parseInt(item.is_active) === 1;
    document.getElementById('editMenuModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
