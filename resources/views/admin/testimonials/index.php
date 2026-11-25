<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Student & Parent Reviews</h1>
            <p class="text-xs text-slate-500 mt-1">Manage ratings, testimonials, and featured alumni reviews</p>
        </div>
        <button onclick="document.getElementById('createTestimonialModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Review
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($testimonials as $t): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-amber-500 text-xs tracking-wider">
                        <?= str_repeat('★', (int)$t['rating']) . str_repeat('☆', 5 - (int)$t['rating']) ?>
                    </span>
                    <span class="<?= $t['is_featured'] ? 'text-indigo-600 font-semibold text-[10px] uppercase tracking-wider' : 'text-slate-400 text-[10px]' ?>">
                        <?= $t['is_featured'] ? 'Featured' : 'Standard' ?>
                    </span>
                </div>
                <p class="text-xs text-slate-700 italic leading-relaxed line-clamp-4">"<?= htmlspecialchars($t['review_text'], ENT_QUOTES, 'UTF-8') ?>"</p>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-slate-900 text-xs"><?= htmlspecialchars($t['person_name'], ENT_QUOTES, 'UTF-8') ?></h4>
                    <span class="text-[11px] text-slate-400"><?= htmlspecialchars($t['relation_or_role'] ?? 'Student', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <form method="POST" action="/admin/testimonials/<?= $t['id'] ?>/delete" onsubmit="return confirm('Delete this review?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="createTestimonialModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Testimonial</h3>
        <form method="POST" action="/admin/testimonials" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Person Name</label>
                <input type="text" name="person_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Relation / Role</label>
                <input type="text" name="relation_or_role" placeholder="e.g. Kathak Student / Parent" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Star Rating (1-5)</label>
                    <select name="rating" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                        <option value="5">★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
                <div class="flex items-center pt-5">
                    <input type="checkbox" name="is_featured" id="isFeatTest" checked class="rounded border-slate-300 text-indigo-600">
                    <label for="isFeatTest" class="ml-2 text-xs text-slate-600">Featured on Home</label>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Review Text</label>
                <textarea name="review_text" rows="3" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createTestimonialModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Review</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
