<?php ob_start(); 
$publicUrl = $isNational ? '/news/national' : '/news/international';
$settingsUrl = $isNational ? '/admin/news/national/settings' : '/admin/news/international/settings';
$actionUrl = $isNational ? '/admin/news/national' : '/admin/news/international';
?>
<div class="space-y-8">
    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?= $isNational ? 'National Press Media' : 'International Media Coverage' ?></h1>
            <p class="text-xs text-slate-500 mt-1">Manage newspaper articles, media clippings, and public press coverage</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= $publicUrl ?>" target="_blank" class="px-3.5 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>View Public Page</span>
            </a>
            <button onclick="document.getElementById('createNewsModal').classList.remove('hidden')" class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>+ Add News Item</span>
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
            <span class="px-2.5 py-1 bg-pink-50 text-pink-700 text-[11px] font-bold rounded-lg border border-pink-100">Public Page: <?= $publicUrl ?></span>
        </div>

        <form method="POST" action="<?= $settingsUrl ?>" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Pill Badge</label>
                    <input type="text" name="badge_label" value="<?= htmlspecialchars($section['content'] ?? ($isNational ? 'IN THE HEADLINES' : 'GLOBAL HEADLINES'), ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. IN THE HEADLINES</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title / Heading</label>
                    <input type="text" name="page_title" value="<?= htmlspecialchars($page['title'] ?? ($isNational ? 'National News & Media' : 'International News & Media'), ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. National News & Media</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Subtitle</label>
                    <input type="text" name="page_subtitle" value="<?= htmlspecialchars($page['subtitle'] ?? 'Press clippings and national print media coverage celebrating our performances and world record events.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">Short descriptive sentence</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? ($isNational ? 'National News & Press Coverage | Dynamice Children Academy' : 'International News & Press | Dynamice Children Academy'), ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($page['meta_description'] ?? 'Press clippings and national print media coverage celebrating our performances and world record events.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
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
        2. NEWS ITEMS TABLE
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">News Clippings & Articles (<?= count($items) ?>)</h2>
            <span class="text-xs text-slate-400">All published items visible on <?= $publicUrl ?></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Clipping</th>
                        <th class="px-6 py-3.5">Date</th>
                        <th class="px-6 py-3.5">Headline & Publication</th>
                        <th class="px-6 py-3.5">Link / Source</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">No news clippings added yet. Click "+ Add News Item" above.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img
                                        src="<?= htmlspecialchars(!empty($item['image_url']) ? $item['image_url'] : '/assets/gallery/5.jpg', ENT_QUOTES, 'UTF-8') ?>"
                                        onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                                        alt=""
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-500 whitespace-nowrap">
                                <?= !empty($item['publish_date']) ? date('M j, Y', strtotime($item['publish_date'])) : '—' ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="line-clamp-1"><?= htmlspecialchars($item['headline'], ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="text-[11px] text-pink-600 font-normal mt-0.5"><?= htmlspecialchars($item['publication_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <?php if (!empty($item['external_link'])): ?>
                                    <a href="<?= htmlspecialchars($item['external_link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="text-pink-600 hover:underline flex items-center gap-1">
                                        <span>Source ↗</span>
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <?php 
                                $updateUrl = $isNational ? "/admin/news/national/{$item['id']}/update" : "/admin/news/international/{$item['id']}/update";
                                $deleteUrl = $isNational ? "/admin/news/national/{$item['id']}/delete" : "/admin/news/international/{$item['id']}/delete"; 
                                ?>
                                <button type="button" onclick="editNews(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>, '<?= $updateUrl ?>')" class="text-pink-600 hover:text-pink-800 font-semibold text-xs">Edit</button>
                                <form method="POST" action="<?= $deleteUrl ?>" class="inline" onsubmit="return confirm('Delete this news clipping?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =========================================================================
    MODAL 1: CREATE NEWS ITEM
    ========================================================================= -->
<div id="createNewsModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Add News Clipping</h3>
            <button type="button" onclick="document.getElementById('createNewsModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Headline <span class="text-rose-500">*</span></label>
                <input type="text" name="headline" required placeholder="e.g. Test Press Release" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publication Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="publication_name" required value="Punjab Kesari" placeholder="e.g. Punjab Kesari, Divya Bhaskar" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Date</label>
                    <input type="date" name="publish_date" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <!-- Image Upload & URL Section -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Newspaper Clipping Photo</label>
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
                    <label class="block text-xs font-semibold text-slate-700 mb-1">External Link (Optional)</label>
                    <input type="text" name="external_link" placeholder="https://..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Summary / Excerpt (Optional)</label>
                <textarea name="summary" rows="3" placeholder="Brief description of the press release..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createNewsModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Save News Clipping</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
    MODAL 2: EDIT NEWS ITEM
    ========================================================================= -->
<div id="editNewsModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Edit News Clipping</h3>
            <button type="button" onclick="document.getElementById('editNewsModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="editNewsForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Headline <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_n_headline" name="headline" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publication Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_n_publication_name" name="publication_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Date</label>
                    <input type="date" id="edit_n_publish_date" name="publish_date" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <!-- Image Upload & URL Section -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Newspaper Clipping Photo</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Upload New File:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Or Existing Image URL:</span>
                        <input type="text" id="edit_n_image_url" name="image_url" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">External Link (Optional)</label>
                    <input type="text" id="edit_n_external_link" name="external_link" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_n_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Summary / Excerpt (Optional)</label>
                <textarea id="edit_n_summary" name="summary" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editNewsModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Update Clipping</button>
            </div>
        </form>
    </div>
</div>

<script>
function editNews(item, actionUrl) {
    document.getElementById('editNewsForm').action = actionUrl;
    document.getElementById('edit_n_headline').value = item.headline || '';
    document.getElementById('edit_n_publication_name').value = item.publication_name || '';
    document.getElementById('edit_n_publish_date').value = item.publish_date ? item.publish_date.substring(0, 10) : '';
    document.getElementById('edit_n_external_link').value = item.external_link || '';
    document.getElementById('edit_n_image_url').value = item.image_url || '';
    document.getElementById('edit_n_sort_order').value = item.sort_order || 0;
    document.getElementById('edit_n_summary').value = item.summary || '';
    document.getElementById('editNewsModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
