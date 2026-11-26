<?php ob_start(); ?>
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Awards & World Records</h1>
            <p class="text-xs text-slate-500 mt-1">Manage recognitions, world record book entries, certificate media, and homepage showcase heading</p>
        </div>
        <button onclick="document.getElementById('createAwardModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Add New Award / Record</span>
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <span><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <!-- Section Heading & Subtitle Management Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
        <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-slate-100">
            <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">🏆</span>
            <div>
                <h2 class="text-sm font-bold text-slate-800">Homepage Showcase Settings (Awards & World Records)</h2>
                <p class="text-[11px] text-slate-400">Controls the badge, title, subtitle, and action link on the homepage</p>
            </div>
        </div>

        <form method="POST" action="/admin/awards/heading" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Top Badge Label</label>
                    <input type="text" name="content" value="<?= htmlspecialchars($section['content'] ?? 'PRESTIGIOUS ACCREDITATIONS & HONORS', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-medium">
                    <p class="text-[10px] text-slate-400 mt-1">Displayed in amber badge at the top</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Main Heading</label>
                    <input type="text" name="heading" required value="<?= htmlspecialchars($section['heading'] ?? 'Awards & World Records', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                    <p class="text-[10px] text-slate-400 mt-1">Large section title</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">View All Button Text</label>
                    <input type="text" name="button_text" value="<?= htmlspecialchars($section['button_text'] ?? 'View All Records & Honors', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                    <p class="text-[10px] text-slate-400 mt-1">Link text next to carousel arrows</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtitle / Description</label>
                    <input type="text" name="subheading" value="<?= htmlspecialchars($section['subheading'] ?? 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button Link URL</label>
                    <input type="text" name="button_url" value="<?= htmlspecialchars($section['button_url'] ?? '/awards', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                    Save Showcase Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Awards Records Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800">Awards & Records List (<?= count($awards) ?> total)</h2>
            <span class="text-xs text-slate-500">Sorted by sort order & year</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Image</th>
                        <th class="px-6 py-3.5">Year</th>
                        <th class="px-6 py-3.5">Award Title</th>
                        <th class="px-6 py-3.5">Issuer / Council</th>
                        <th class="px-6 py-3.5">Type</th>
                        <th class="px-6 py-3.5">Order</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($awards)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400">No awards recorded yet. Click "+ Add New Award / Record" above to add one.</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($awards as $a): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-3">
                            <div class="w-12 h-9 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                <img src="<?= htmlspecialchars($a['certificate_image_url'] ?: '/assets/awards/01.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="" class="w-full h-full object-cover" onerror="this.src='/assets/awards/01.jpg';">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-indigo-600 font-mono"><?= (int)$a['year'] ?></td>
                        <td class="px-6 py-4 font-semibold text-slate-900 max-w-xs">
                            <div class="truncate"><?= htmlspecialchars($a['title'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php if (!empty($a['description'])): ?>
                                <div class="text-[11px] text-slate-400 truncate max-w-xs"><?= htmlspecialchars($a['description'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-slate-600 max-w-xs truncate"><?= htmlspecialchars($a['issuer'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $a['is_record_book'] ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-pink-50 text-pink-700 border border-pink-100' ?>">
                                <?= $a['is_record_book'] ? '🏆 World Record' : '🏅 National Honor' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 font-mono"><?= (int)($a['sort_order'] ?? 0) ?></td>
                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <button type="button" onclick="editAward(<?= htmlspecialchars(json_encode($a), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs cursor-pointer">Edit</button>
                            <form method="POST" action="/admin/awards/<?= $a['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this award?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs cursor-pointer">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Award Modal -->
<div id="createAwardModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 my-8">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900">Add New Award / Record</h3>
            <button type="button" onclick="document.getElementById('createAwardModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form method="POST" action="/admin/awards" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Award Title <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="e.g. London Book of World Records Certificate" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Issuer / Authority <span class="text-rose-500">*</span></label>
                <input type="text" name="issuer" required placeholder="e.g. London Book of World Records, UNESCO, AIBA" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" placeholder="Record, Citation, Trophy" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <!-- Certificate Image Upload / URL -->
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Certificate / Trophy Image</label>
                <input type="file" name="certificate_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div class="text-[11px] text-slate-400">Or provide direct URL:</div>
                <input type="text" name="certificate_image_url" placeholder="/assets/awards/01.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="2" placeholder="Inscribed for historic mass child classical dance recital and world-class choreography synchronization." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"></textarea>
            </div>

            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_record_book" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="font-semibold text-amber-700">🏆 World Record Book</span>
                </label>
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Featured on Home</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createAwardModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Save Award</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Award Modal -->
<div id="editAwardModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 my-8">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900">Edit Award / Record</h3>
            <button type="button" onclick="document.getElementById('editAwardModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form id="editAwardForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Award Title <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_award_title" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Issuer / Authority <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_award_issuer" name="issuer" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" id="edit_award_year" name="year" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" id="edit_award_category" name="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_award_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <!-- Certificate Image Upload / URL -->
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-semibold text-slate-700">Certificate / Trophy Image</label>
                    <div id="edit_award_img_preview" class="w-10 h-7 rounded bg-slate-200 overflow-hidden border border-slate-300">
                        <img id="edit_award_img_thumb" src="" alt="" class="w-full h-full object-cover">
                    </div>
                </div>
                <input type="file" name="certificate_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div class="text-[11px] text-slate-400">Current Image URL:</div>
                <input type="text" id="edit_award_image_url" name="certificate_image_url" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Description</label>
                <textarea id="edit_award_description" name="description" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"></textarea>
            </div>

            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" id="edit_award_is_record_book" name="is_record_book" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="font-semibold text-amber-700">🏆 World Record Book</span>
                </label>
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" id="edit_award_is_featured" name="is_featured" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Featured on Home</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editAwardModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Update Award</button>
            </div>
        </form>
    </div>
</div>

<script>
function editAward(item) {
    document.getElementById('editAwardForm').action = '/admin/awards/' + item.id + '/update';
    document.getElementById('edit_award_title').value = item.title || '';
    document.getElementById('edit_award_issuer').value = item.issuer || '';
    document.getElementById('edit_award_year').value = item.year || '';
    document.getElementById('edit_award_category').value = item.category || '';
    document.getElementById('edit_award_sort_order').value = item.sort_order || 0;
    document.getElementById('edit_award_image_url').value = item.certificate_image_url || '';
    document.getElementById('edit_award_img_thumb').src = item.certificate_image_url || '/assets/awards/01.jpg';
    document.getElementById('edit_award_description').value = item.description || '';
    document.getElementById('edit_award_is_record_book').checked = parseInt(item.is_record_book) === 1;
    document.getElementById('edit_award_is_featured').checked = parseInt(item.is_featured) === 1;
    document.getElementById('editAwardModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
