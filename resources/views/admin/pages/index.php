<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Website Pages & SEO</h1>
            <p class="text-xs text-slate-500 mt-1">Manage pages, hero banners, and SEO metadata</p>
        </div>
        <button onclick="document.getElementById('createPageModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + New Page
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
                        <th class="px-6 py-3.5">Title & Slug</th>
                        <th class="px-6 py-3.5">Meta Title</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($pages as $p): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-[11px] text-indigo-600 font-mono">/<?= htmlspecialchars($p['slug'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                            <?= htmlspecialchars($p['meta_title'] ?? $p['title'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 <?= $p['is_published'] ? 'text-emerald-700' : 'text-slate-400' ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $p['is_published'] ? 'bg-emerald-500' : 'bg-slate-300' ?>"></span>
                                <?= $p['is_published'] ? 'Published' : 'Draft' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="/admin/sections?page_id=<?= $p['id'] ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Sections</a>
                            <form method="POST" action="/admin/pages/<?= $p['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this page?');">
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

<div id="createPageModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Website Page</h3>
        <form method="POST" action="/admin/pages" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Slug (URL path)</label>
                <input type="text" name="slug" required placeholder="e.g. workshops" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Subtitle</label>
                <input type="text" name="subtitle" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Banner Image URL</label>
                <input type="text" name="banner_image_url" placeholder="/assets/images/banner.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Title (SEO)</label>
                <input type="text" name="meta_title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Description (SEO)</label>
                <textarea name="meta_description" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="isPub" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isPub" class="text-xs text-slate-600">Published</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createPageModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Create Page</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
