<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dance Stories (Articles & Blog)</h1>
            <p class="text-xs text-slate-500 mt-1">Publish dance lore, student spotlights, and cultural stories</p>
        </div>
        <button onclick="document.getElementById('createBlogModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Write Story
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Title & Author</th>
                    <th class="px-6 py-3.5">Category</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5">Published Date</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($posts as $post): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        <div><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="text-[11px] text-slate-400 font-normal">By <?= htmlspecialchars($post['author_name'], ENT_QUOTES, 'UTF-8') ?></div>
                    </td>
                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $post['status'] === 'PUBLISHED' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' ?>">
                            <?= htmlspecialchars($post['status'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 font-mono text-slate-500"><?= date('M j, Y', strtotime($post['published_at'])) ?></td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form method="POST" action="/admin/blogs/<?= $post['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this story?');">
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

<div id="createBlogModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Write New Story</h3>
        <form method="POST" action="/admin/blogs" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Story Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" value="Dance & Culture" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Author Name</label>
                    <input type="text" name="author_name" value="<?= htmlspecialchars($user['full_name'] ?? 'Editor', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Featured Cover Image URL</label>
                <input type="text" name="featured_image_url" placeholder="/uploads/blogs/cover.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Short Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Article Content</label>
                <textarea name="content" rows="6" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-mono"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createBlogModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Publish Story</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
