<?php ob_start(); ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Hero Section & Banners</h1>
            <p class="text-xs text-slate-500 mt-1">Manage the full-width homepage hero banner slides and the heading text displayed below it.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/" target="_blank" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Live Homepage
            </a>
            <button onclick="document.getElementById('createSlideModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Add Hero Slide
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Card 1: Heading Below Hero -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Hero Sub-Heading (Culture Is a Way of Life)</h3>
                <p class="text-xs text-slate-500">Edit the prominent heading that appears immediately below the full-width image banner.</p>
            </div>
            <span class="px-2.5 py-1 bg-amber-50 border border-amber-200/60 text-amber-700 text-[11px] font-semibold rounded-lg">Homepage Below Hero</span>
        </div>

        <form method="POST" action="/admin/hero/heading" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Main Heading</label>
                    <input type="text" name="heading" required value="<?= htmlspecialchars($heroSection['heading'] ?? 'Culture Is a Way of Life', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: "Culture Is a Way of Life"</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Optional Subtitle / Tagline</label>
                    <input type="text" name="subheading" value="<?= htmlspecialchars($heroSection['subheading'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g. Gujarat's Premier Classical & Folk Arts Institute" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                </div>
            </div>
            <div class="flex justify-end pt-1">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors">
                    Save Heading
                </button>
            </div>
        </form>
    </div>

    <!-- Card 2: Full-Width Hero Slides List -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Hero Slider Images (<?= count($slides) ?>)</h3>
                <p class="text-xs text-slate-500">Each image stretches 100% full width in the banner. You can upload new images, reorder them, or delete old ones.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5 w-16">Preview</th>
                        <th class="px-6 py-3.5">Title & Path</th>
                        <th class="px-6 py-3.5 w-24 text-center">Sort Order</th>
                        <th class="px-6 py-3.5 w-24 text-center">Status</th>
                        <th class="px-6 py-3.5 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($slides)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            No hero slides added yet. Click "+ Add Hero Slide" to upload one.
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach ($slides as $slide): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-20 h-12 rounded-lg bg-slate-950 overflow-hidden border border-slate-200 shadow-xs">
                                <img src="<?= htmlspecialchars($slide['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900"><?= htmlspecialchars($slide['title'] ?? 'Dynamic Children Academy Performance', ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="font-mono text-slate-400 text-[10px] mt-0.5 truncate max-w-md"><?= htmlspecialchars($slide['image_url'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono text-slate-600 font-semibold">
                            <?= (int)$slide['sort_order'] ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $slide['is_active'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-500' ?>">
                                <?= $slide['is_active'] ? 'Active' : 'Disabled' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="editSlide(<?= htmlspecialchars(json_encode($slide), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                            <form method="POST" action="/admin/hero/slides/<?= $slide['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this hero slide?');">
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

<!-- Modal: Create Slide -->
<div id="createSlideModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-base font-bold text-slate-900 mb-4">Add Hero Slide Image</h3>
        <form method="POST" action="/admin/hero/slides" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Slide Title / Alt Text</label>
                <input type="text" name="title" placeholder="e.g. World Record Folk Dance Showcase" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Upload New Image File (JPG, PNG, WEBP)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-2 text-[10px] text-slate-400 uppercase font-semibold">Or use image path / URL</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Image URL / Path</label>
                <input type="text" name="image_url" placeholder="/assets/banners/homebanner.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" id="isSlideActive" checked class="rounded border-slate-300 text-indigo-600">
                    <label for="isSlideActive" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createSlideModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Upload & Save Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Slide -->
<div id="editSlideModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-base font-bold text-slate-900 mb-4">Edit Hero Slide Image</h3>
        <form id="editSlideForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Slide Title / Alt Text</label>
                <input type="text" id="edit_slide_title" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Image File</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Current Image URL</label>
                <input type="text" id="edit_slide_image_url" name="image_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-mono text-[11px]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_slide_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" id="edit_slide_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                    <label for="edit_slide_is_active" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editSlideModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
function editSlide(slide) {
    document.getElementById('editSlideForm').action = '/admin/hero/slides/' + slide.id + '/update';
    document.getElementById('edit_slide_title').value = slide.title || '';
    document.getElementById('edit_slide_image_url').value = slide.image_url || '';
    document.getElementById('edit_slide_sort_order').value = slide.sort_order || 0;
    document.getElementById('edit_slide_is_active').checked = !!parseInt(slide.is_active);
    document.getElementById('editSlideModal').classList.remove('hidden');
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
