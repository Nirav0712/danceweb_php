<?php ob_start(); ?>
<div class="space-y-8">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Performance Photo Gallery</h1>
            <p class="text-xs text-slate-500 mt-1">Manage performance photographs, dance categories, and visual archive showcase</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/gallery" target="_blank" class="px-3.5 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>View Public Gallery</span>
            </a>
            <button onclick="document.getElementById('createGalleryModal').classList.remove('hidden')" class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>+ Add Photo</span>
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>
    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <!-- =========================================================================
        1. PAGE BANNER & CMS SETTINGS
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Page Header & Banner CMS Settings</h2>
                <p class="text-xs text-slate-500 mt-0.5">Customize the top rainbow hero badge, headline, and subtitle</p>
            </div>
            <span class="px-2.5 py-1 bg-pink-50 text-pink-700 text-[11px] font-bold rounded-lg border border-pink-100">Public Page: /gallery</span>
        </div>

        <form method="POST" action="/admin/gallery/settings" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Pill Badge</label>
                    <input type="text" name="badge_label" value="<?= htmlspecialchars($section['content'] ?? 'VISUAL ARCHIVE', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. VISUAL ARCHIVE</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title / Heading</label>
                    <input type="text" name="page_title" value="<?= htmlspecialchars($page['title'] ?? 'Performance Photo Gallery', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. Performance Photo Gallery</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Subtitle</label>
                    <input type="text" name="page_subtitle" value="<?= htmlspecialchars($page['subtitle'] ?? 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">Short descriptive sentence</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? 'Performance Photo Gallery | Dynamice Children Academy', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($page['meta_description'] ?? 'Capturing the color, grace, rhythm, and stage triumphs of our young artists across 140+ documented moments.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-xs">
                    Save Header Settings
                </button>
            </div>
        </form>
    </div>

    <!-- =========================================================================
        2. PHOTOS GRID
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Documented Photographs (<?= count($items) ?>)</h2>
            <span class="text-xs text-slate-400">All photos shown on /gallery</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php foreach ($items as $item): ?>
            <div class="bg-slate-50 rounded-2xl border border-slate-200/80 p-2 shadow-xs flex flex-col justify-between">
                <div class="aspect-4/3 rounded-xl bg-slate-100 overflow-hidden relative">
                    <img
                        src="<?= htmlspecialchars(!empty($item['image_url']) ? $item['image_url'] : '/assets/gallery/5.jpg', ENT_QUOTES, 'UTF-8') ?>"
                        onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                        alt=""
                        class="w-full h-full object-cover"
                    >
                    <?php if (!empty($item['is_featured'])): ?>
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-400 text-slate-950 shadow-xs">★ Featured</span>
                    <?php endif; ?>
                </div>
                <div class="mt-2 px-1">
                    <div class="font-semibold text-slate-900 text-xs truncate"><?= htmlspecialchars($item['title'] ?? 'Performance Photo', ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="text-[10px] text-slate-400"><?= htmlspecialchars($item['category_name'] ?? 'General') ?> • <?= $item['event_year'] ?? '2024' ?></div>
                </div>
                <div class="flex items-center justify-end gap-2 mt-2 pt-2 border-t border-slate-200/60 px-1 text-[11px]">
                    <button type="button" onclick="editGallery(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>)" class="text-pink-600 hover:text-pink-800 font-semibold">Edit</button>
                    <form method="POST" action="/admin/gallery/<?= $item['id'] ?>/delete" onsubmit="return confirm('Delete this gallery photo?');" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- =========================================================================
    MODAL 1: ADD PHOTO
    ========================================================================= -->
<div id="createGalleryModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Add Performance Photo</h3>
            <button type="button" onclick="document.getElementById('createGalleryModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="/admin/gallery" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Photo Title</label>
                <input type="text" name="title" placeholder="e.g. Gujarati Folk Garba Ensemble" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <!-- Image File or URL -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Photo Asset</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Upload New File:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Or Existing Image URL:</span>
                        <input type="text" name="image_url" placeholder="/assets/gallery/5.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dance Discipline / Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                        <option value="">General</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Event Year</label>
                    <input type="number" name="event_year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_featured" id="isFeat" class="rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                <label for="isFeat" class="text-xs font-semibold text-slate-700">Feature this photo on Homepage & Top Gallery</label>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createGalleryModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Save Photo</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
    MODAL 2: EDIT PHOTO
    ========================================================================= -->
<div id="editGalleryModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Edit Photo</h3>
            <button type="button" onclick="document.getElementById('editGalleryModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="editGalleryForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Photo Title</label>
                <input type="text" id="edit_title" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Photo Asset</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Upload New File:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Or Existing Image URL:</span>
                        <input type="text" id="edit_image_url" name="image_url" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dance Discipline / Category</label>
                    <select id="edit_category_id" name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                        <option value="">General</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Event Year</label>
                    <input type="number" id="edit_event_year" name="event_year" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="edit_is_featured" name="is_featured" class="rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                <label for="edit_is_featured" class="text-xs font-semibold text-slate-700">Feature this photo on Homepage & Top Gallery</label>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editGalleryModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Update Photo</button>
            </div>
        </form>
    </div>
</div>

<script>
function editGallery(item) {
    document.getElementById('editGalleryForm').action = '/admin/gallery/' + item.id + '/update';
    document.getElementById('edit_title').value = item.title || '';
    document.getElementById('edit_image_url').value = item.image_url || '';
    document.getElementById('edit_category_id').value = item.category_id || '';
    document.getElementById('edit_event_year').value = item.event_year || '2024';
    document.getElementById('edit_is_featured').checked = item.is_featured == 1;
    document.getElementById('editGalleryModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
