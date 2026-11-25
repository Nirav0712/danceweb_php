<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Photo Gallery</h1>
            <p class="text-xs text-slate-500 mt-1">Manage performance and event photos displayed across the website</p>
        </div>
        <button onclick="document.getElementById('createGalleryModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Photo
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <?php foreach ($items as $item): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-xs flex flex-col justify-between">
            <div class="aspect-4/3 rounded-xl bg-slate-100 overflow-hidden">
                <img src="<?= htmlspecialchars($item['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover">
            </div>
            <div class="mt-2 px-1">
                <div class="font-semibold text-slate-900 text-xs truncate"><?= htmlspecialchars($item['title'] ?? 'Performance Photo', ENT_QUOTES, 'UTF-8') ?></div>
                <div class="text-[10px] text-slate-400"><?= htmlspecialchars($item['category_name'] ?? 'General') ?> • <?= $item['event_year'] ?? 'Recent' ?></div>
            </div>
            <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-100 px-1 text-[11px]">
                <span class="<?= $item['is_featured'] ? 'text-amber-600 font-semibold' : 'text-slate-400' ?>"><?= $item['is_featured'] ? '★ Featured' : '' ?></span>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="editGallery(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold">Edit</button>
                    <form method="POST" action="/admin/gallery/<?= $item['id'] ?>/delete" onsubmit="return confirm('Delete this gallery photo?');" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="createGalleryModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Gallery Photo</h3>
        <form method="POST" action="/admin/gallery" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Image URL</label>
                <input type="text" name="image_url" required placeholder="/uploads/gallery/photo.jpg or URL" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <option value="">General</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" name="event_year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center pt-5">
                    <input type="checkbox" name="is_featured" id="isFeat" class="rounded border-slate-300 text-indigo-600">
                    <label for="isFeat" class="ml-2 text-xs text-slate-600">Featured</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createGalleryModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Photo</button>
            </div>
        </form>
    </div>
</div>

<div id="editGalleryModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Gallery Photo</h3>
        <form id="editGalleryForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Image URL</label>
                <input type="text" id="edit_image_url" name="image_url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" id="edit_title" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                <select id="edit_category_id" name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                    <option value="">General</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" id="edit_event_year" name="event_year" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center pt-5">
                    <input type="checkbox" id="edit_is_featured" name="is_featured" class="rounded border-slate-300 text-indigo-600">
                    <label for="edit_is_featured" class="ml-2 text-xs text-slate-600">Featured</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editGalleryModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Photo</button>
            </div>
        </form>
    </div>
</div>

<script>
function editGallery(item) {
    document.getElementById('editGalleryForm').action = '/admin/gallery/' + item.id + '/update';
    document.getElementById('edit_image_url').value = item.image_url || '';
    document.getElementById('edit_title').value = item.title || '';
    document.getElementById('edit_category_id').value = item.category_id || '';
    document.getElementById('edit_event_year').value = item.event_year || '';
    document.getElementById('edit_is_featured').checked = parseInt(item.is_featured) === 1;
    document.getElementById('editGalleryModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
