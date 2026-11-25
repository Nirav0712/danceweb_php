<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?= $isNational ? 'National Press Media' : 'International Media Coverage' ?></h1>
            <p class="text-xs text-slate-500 mt-1">Manage newspaper articles, clippings, and press releases</p>
        </div>
        <button onclick="document.getElementById('createNewsModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add News Item
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Date</th>
                    <th class="px-6 py-3.5">Headline & Publication</th>
                    <th class="px-6 py-3.5">Link / Source</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($items as $item): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-mono text-slate-500"><?= htmlspecialchars($item['publish_date'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        <div><?= htmlspecialchars($item['headline'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="text-[11px] text-indigo-600 font-normal"><?= htmlspecialchars($item['publication_name'], ENT_QUOTES, 'UTF-8') ?></div>
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        <?php if ($item['external_link']): ?>
                            <a href="<?= htmlspecialchars($item['external_link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="text-indigo-600 hover:underline">View Article ↗</a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <?php 
                        $updateUrl = $isNational ? "/admin/news/national/{$item['id']}/update" : "/admin/news/international/{$item['id']}/update";
                        $deleteUrl = $isNational ? "/admin/news/national/{$item['id']}/delete" : "/admin/news/international/{$item['id']}/delete"; 
                        ?>
                        <button type="button" onclick="editNews(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>, '<?= $updateUrl ?>')" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                        <form method="POST" action="<?= $deleteUrl ?>" class="inline" onsubmit="return confirm('Delete this news clipping?');">
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

<div id="createNewsModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add News Clipping</h3>
        <?php $actionUrl = $isNational ? '/admin/news/national' : '/admin/news/international'; ?>
        <form method="POST" action="<?= $actionUrl ?>" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Headline</label>
                <input type="text" name="headline" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Publication Name</label>
                <input type="text" name="publication_name" required placeholder="e.g. Dainik Bhaskar, The Tribune" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Date</label>
                    <input type="date" name="publish_date" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">External Link (optional)</label>
                    <input type="text" name="external_link" placeholder="https://..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Clipping Image URL</label>
                <input type="text" name="image_url" required placeholder="/uploads/news/press.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Summary / Excerpt</label>
                <textarea name="summary" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createNewsModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save News</button>
            </div>
        </form>
    </div>
</div>

<div id="editNewsModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit News Clipping</h3>
        <form id="editNewsForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Headline</label>
                <input type="text" id="edit_n_headline" name="headline" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Publication Name</label>
                <input type="text" id="edit_n_publication_name" name="publication_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Date</label>
                    <input type="date" id="edit_n_publish_date" name="publish_date" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">External Link (optional)</label>
                    <input type="text" id="edit_n_external_link" name="external_link" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Clipping Image URL</label>
                <input type="text" id="edit_n_image_url" name="image_url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Summary / Excerpt</label>
                <textarea id="edit_n_summary" name="summary" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editNewsModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update News</button>
            </div>
        </form>
    </div>
</div>

<script>
function editNews(item, actionUrl) {
    document.getElementById('editNewsForm').action = actionUrl;
    document.getElementById('edit_n_headline').value = item.headline || '';
    document.getElementById('edit_n_publication_name').value = item.publication_name || '';
    document.getElementById('edit_n_publish_date').value = item.publish_date || '';
    document.getElementById('edit_n_external_link').value = item.external_link || '';
    document.getElementById('edit_n_image_url').value = item.image_url || '';
    document.getElementById('edit_n_summary').value = item.summary || '';
    document.getElementById('editNewsModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
