<?php ob_start(); ?>
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Student & Parent Reviews</h1>
            <p class="text-xs text-slate-500 mt-1">Manage ratings, testimonials, parent reflections, and homepage showcase headings</p>
        </div>
        <button onclick="document.getElementById('createTestimonialModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>+ Add Review</span>
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

    <!-- Section Heading & Badge Management Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
        <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-slate-100">
            <span class="w-7 h-7 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">💬</span>
            <div>
                <h2 class="text-sm font-bold text-slate-800">Homepage Showcase Settings (Words From Our Families)</h2>
                <p class="text-[11px] text-slate-400">Controls the pill badge, main heading, and subtitle on the public homepage</p>
            </div>
        </div>

        <form method="POST" action="/admin/testimonials/heading" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Top Pill Badge</label>
                    <input type="text" name="content" value="<?= htmlspecialchars($section['content'] ?? 'PARENT REFLECTIONS', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-semibold tracking-wider">
                    <p class="text-[10px] text-slate-400 mt-1">Pill badge shown above title (e.g. PARENT REFLECTIONS)</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Main Heading <span class="text-rose-500">*</span></label>
                    <input type="text" name="heading" required value="<?= htmlspecialchars($section['heading'] ?? 'Words From Our Families', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                    <p class="text-[10px] text-slate-400 mt-1">Section title (e.g. Words From Our Families)</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtitle / Subheading</label>
                    <input type="text" name="subheading" value="<?= htmlspecialchars($section['subheading'] ?? 'Authentic reflections from parents and students experiencing our creative pedagogy.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                    <p class="text-[10px] text-slate-400 mt-1">Optional subtitle text</p>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                    Save Showcase Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Testimonials List Grid -->
    <div>
        <div class="flex items-center justify-between mb-3 px-1">
            <h2 class="text-sm font-bold text-slate-800">Testimonials List (<?= count($testimonials) ?> total)</h2>
            <span class="text-xs text-slate-400">First 6 active items will be displayed on homepage (3x2 grid)</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($testimonials as $t): ?>
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between hover:shadow-md transition-shadow relative">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-amber-500 text-xs tracking-wider">
                            <?= str_repeat('★', (int)$t['rating']) . str_repeat('☆', 5 - (int)$t['rating']) ?>
                        </span>
                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $t['is_active'] ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' ?>">
                                <?= $t['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $t['is_featured'] ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-500' ?>">
                                <?= $t['is_featured'] ? 'Featured' : 'Standard' ?>
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-700 italic leading-relaxed line-clamp-4">"<?= htmlspecialchars($t['review_text'], ENT_QUOTES, 'UTF-8') ?>"</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs"><?= htmlspecialchars($t['person_name'], ENT_QUOTES, 'UTF-8') ?></h4>
                        <span class="text-[11px] text-slate-400"><?= htmlspecialchars($t['relation_or_role'] ?? 'Student', ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="editTestimonial(<?= htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs cursor-pointer">Edit</button>
                        <form method="POST" action="/admin/testimonials/<?= $t['id'] ?>/delete" onsubmit="return confirm('Delete this review?');" class="inline">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs cursor-pointer">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Create Testimonial Modal -->
<div id="createTestimonialModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900">Add Testimonial</h3>
            <button type="button" onclick="document.getElementById('createTestimonialModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form method="POST" action="/admin/testimonials" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Person Name <span class="text-rose-500">*</span></label>
                <input type="text" name="person_name" required placeholder="e.g. Bhavna Patel" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Relation / Role</label>
                <input type="text" name="relation_or_role" placeholder="e.g. Mother of Dhyana (Age 8)" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Star Rating (1-5)</label>
                    <select name="rating" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                        <option value="5" selected>★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Review Text <span class="text-rose-500">*</span></label>
                <textarea name="review_text" rows="3" required placeholder="Write the testimonial reflection..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"></textarea>
            </div>
            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Featured on Home</span>
                </label>
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Active</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createTestimonialModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Save Review</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Testimonial Modal -->
<div id="editTestimonialModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900">Edit Testimonial</h3>
            <button type="button" onclick="document.getElementById('editTestimonialModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
        </div>
        <form id="editTestimonialForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Person Name <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_t_person_name" name="person_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Relation / Role</label>
                <input type="text" id="edit_t_relation_or_role" name="relation_or_role" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Star Rating (1-5)</label>
                    <select id="edit_t_rating" name="rating" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                        <option value="5">★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_t_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Review Text <span class="text-rose-500">*</span></label>
                <textarea id="edit_t_review_text" name="review_text" rows="3" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"></textarea>
            </div>
            <div class="flex items-center gap-6 pt-1">
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" id="edit_t_is_featured" name="is_featured" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Featured on Home</span>
                </label>
                <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                    <input type="checkbox" id="edit_t_is_active" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Active</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editTestimonialModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Update Review</button>
            </div>
        </form>
    </div>
</div>

<script>
function editTestimonial(item) {
    document.getElementById('editTestimonialForm').action = '/admin/testimonials/' + item.id + '/update';
    document.getElementById('edit_t_person_name').value = item.person_name || '';
    document.getElementById('edit_t_relation_or_role').value = item.relation_or_role || '';
    document.getElementById('edit_t_rating').value = item.rating || 5;
    document.getElementById('edit_t_sort_order').value = item.sort_order || 0;
    document.getElementById('edit_t_review_text').value = item.review_text || '';
    document.getElementById('edit_t_is_featured').checked = parseInt(item.is_featured) === 1;
    document.getElementById('edit_t_is_active').checked = parseInt(item.is_active) === 1;
    document.getElementById('editTestimonialModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
