<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Page Sections</h1>
            <p class="text-xs text-slate-500 mt-1">Configure layout sections, headings, contents and call-to-action buttons</p>
        </div>
        <button onclick="document.getElementById('createSectionModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Section
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <!-- Page Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs">
        <a href="/admin/sections" class="px-3 py-1.5 rounded-xl border <?= empty($selected_page_id) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200' ?>">All Pages</a>
        <?php foreach ($pages as $p): ?>
            <a href="/admin/sections?page_id=<?= $p['id'] ?>" class="px-3 py-1.5 rounded-xl border <?= $selected_page_id == $p['id'] ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-slate-600 border-slate-200' ?>">
                <?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Page</th>
                        <th class="px-6 py-3.5">Section Key & Heading</th>
                        <th class="px-6 py-3.5">CTA Button</th>
                        <th class="px-6 py-3.5">Sort</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($sections as $s): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($s['page_title'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="px-6 py-4">
                            <div class="font-mono text-indigo-600 text-[11px]"><?= htmlspecialchars($s['section_key'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-slate-800 font-semibold"><?= htmlspecialchars($s['heading'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            <?= $s['button_text'] ? htmlspecialchars($s['button_text'], ENT_QUOTES, 'UTF-8') . " (" . htmlspecialchars($s['button_url'] ?? '', ENT_QUOTES, 'UTF-8') . ")" : '—' ?>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono"><?= (int)$s['sort_order'] ?></td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="editSection(<?= htmlspecialchars(json_encode($s), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                            <form method="POST" action="/admin/sections/<?= $s['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete section?');">
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

<div id="createSectionModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Section</h3>
        <form method="POST" action="/admin/sections" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Parent Page</label>
                <select name="page_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <?php foreach ($pages as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Section Key</label>
                <input type="text" name="section_key" placeholder="e.g. hero, about_stats, cta" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                <input type="text" name="heading" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Subheading</label>
                <input type="text" name="subheading" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Content / Body</label>
                <textarea name="content" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button Text</label>
                    <input type="text" name="button_text" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button URL</label>
                    <input type="text" name="button_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" id="isVis" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isVis" class="text-xs text-slate-600">Visible</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createSectionModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Section</button>
            </div>
        </form>
    </div>
</div>

<div id="editSectionModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Section</h3>
        <form id="editSectionForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                <input type="text" id="edit_sec_heading" name="heading" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Subheading</label>
                <input type="text" id="edit_sec_subheading" name="subheading" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Content / Body</label>
                <textarea id="edit_sec_content" name="content" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button Text</label>
                    <input type="text" id="edit_sec_button_text" name="button_text" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button URL</label>
                    <input type="text" id="edit_sec_button_url" name="button_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" id="edit_sec_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_sec_is_visible" name="is_visible" class="rounded border-slate-300 text-indigo-600">
                <label for="edit_sec_is_visible" class="text-xs text-slate-600">Visible</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editSectionModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Section</button>
            </div>
        </form>
    </div>
</div>

<script>
function editSection(item) {
    document.getElementById('editSectionForm').action = '/admin/sections/' + item.id + '/update';
    document.getElementById('edit_sec_heading').value = item.heading || '';
    document.getElementById('edit_sec_subheading').value = item.subheading || '';
    document.getElementById('edit_sec_content').value = item.content || '';
    document.getElementById('edit_sec_button_text').value = item.button_text || '';
    document.getElementById('edit_sec_button_url').value = item.button_url || '';
    document.getElementById('edit_sec_sort_order').value = item.sort_order || 0;
    document.getElementById('edit_sec_is_visible').checked = parseInt(item.is_visible) === 1;
    document.getElementById('editSectionModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
