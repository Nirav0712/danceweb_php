<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Campuses & Contact Page CMS</h1>
            <p class="text-xs text-slate-500 mt-1">Manage physical academy locations, hero banner, official inquiries phone/email, and batch timings</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/contact" target="_blank" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition">
                <span>View Live Page</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            <button onclick="document.getElementById('createBranchModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
                + Add Campus Branch
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl"><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <!-- Contact Page Hero & Info CMS Settings Form -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Contact Page Header & Headquarter Info CMS</h2>
                <p class="text-[11px] text-slate-500">Edit the top hero section badge, titles, and main inquiry contact details on <code class="text-indigo-600">/contact</code></p>
            </div>
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                Live on Public Site
            </span>
        </div>

        <form method="POST" action="/admin/branches/settings" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Pill Badge</label>
                    <input type="text" name="badge_label" value="<?= htmlspecialchars($section['content'] ?? 'ADMISSIONS & ENQUIRIES', ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. ADMISSIONS &amp; ENQUIRIES</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Hero Heading</label>
                    <input type="text" name="page_title" value="<?= htmlspecialchars($section['heading'] ?? ($page['title'] ?? 'Connect With Our Academy'), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Subtitle</label>
                <textarea name="page_subtitle" rows="2" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"><?= htmlspecialchars($section['subheading'] ?? ($page['subtitle'] ?? 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.'), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Direct Inquiries / Admission Phone</label>
                    <input type="text" name="contact_phone" value="<?= htmlspecialchars($settings['contact_phone'] ?? '+91 99242 81372', ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Official Academy Email</label>
                    <input type="email" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? 'info@dynamicechildrenacademy.com', ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Academy Operational Hours</label>
                    <input type="text" name="contact_hours" value="<?= htmlspecialchars($settings['contact_hours'] ?? 'Monday to Saturday: 8:00 AM - 9:00 PM | Sunday: 8:00 AM - 2:00 PM (Special Batches)', ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? 'Contact & Admissions — Dynamice Children Academy', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($page['meta_description'] ?? 'Connect with Dynamice Children Academy admissions in Ahmedabad. Inquire about folk dance, Kathak, and Bollywood courses.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition">
                    Save Contact Page Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Branches List -->
    <div class="flex items-center justify-between pt-2">
        <div>
            <h2 class="text-base font-bold text-slate-900">Registered Teaching Campuses (<?= count($branches) ?>)</h2>
            <p class="text-xs text-slate-500">These locations appear on the contact page studio switcher and inquiry dropdown</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($branches as $b): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($b['branch_name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <span class="<?= $b['is_active'] ? 'text-emerald-600' : 'text-slate-400' ?> text-[11px] font-semibold"><?= $b['is_active'] ? 'Active' : 'Inactive' ?></span>
                </div>
                <p class="text-xs text-slate-600 mb-2"><?= htmlspecialchars($b['address_line_1'], ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($b['city'], ENT_QUOTES, 'UTF-8') ?></p>
                <div class="space-y-1 text-[11px] text-slate-500">
                    <div>📞 <?= htmlspecialchars($b['phone_primary'], ENT_QUOTES, 'UTF-8') ?></div>
                    <div>✉ <?= htmlspecialchars($b['email'], ENT_QUOTES, 'UTF-8') ?></div>
                    <div>⏰ <?= htmlspecialchars($b['timing_info'] ?? 'Mon - Sat: 9 AM - 7 PM', ENT_QUOTES, 'UTF-8') ?></div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end space-x-2">
                <button type="button" onclick="editBranch(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                <form method="POST" action="/admin/branches/<?= $b['id'] ?>/delete" onsubmit="return confirm('Delete this branch campus?');" class="inline">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="createBranchModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Branch Campus</h3>
        <form method="POST" action="/admin/branches" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Branch Name</label>
                <input type="text" name="branch_name" required placeholder="e.g. Model Town Main Branch" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Street Address</label>
                <input type="text" name="address_line_1" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">City</label>
                    <input type="text" name="city" value="Ludhiana" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">State</label>
                    <input type="text" name="state" value="Punjab" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Primary Phone</label>
                    <input type="text" name="phone_primary" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Timings Info</label>
                <input type="text" name="timing_info" placeholder="Mon - Sat: 9:00 AM - 7:00 PM" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isActBr" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isActBr" class="text-xs text-slate-600">Active Campus</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createBranchModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Branch</button>
            </div>
        </form>
    </div>
</div>

<div id="editBranchModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Branch Campus</h3>
        <form id="editBranchForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Branch Name</label>
                <input type="text" id="edit_br_name" name="branch_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Street Address</label>
                <input type="text" id="edit_br_address" name="address_line_1" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">City</label>
                    <input type="text" id="edit_br_city" name="city" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">State</label>
                    <input type="text" id="edit_br_state" name="state" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Primary Phone</label>
                    <input type="text" id="edit_br_phone" name="phone_primary" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" id="edit_br_email" name="email" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Timings Info</label>
                <input type="text" id="edit_br_timing" name="timing_info" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_br_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                <label for="edit_br_is_active" class="text-xs text-slate-600">Active Campus</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editBranchModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Branch</button>
            </div>
        </form>
    </div>
</div>

<script>
function editBranch(item) {
    document.getElementById('editBranchForm').action = '/admin/branches/' + item.id + '/update';
    document.getElementById('edit_br_name').value = item.branch_name || '';
    document.getElementById('edit_br_address').value = item.address_line_1 || '';
    document.getElementById('edit_br_city').value = item.city || '';
    document.getElementById('edit_br_state').value = item.state || '';
    document.getElementById('edit_br_phone').value = item.phone_primary || '';
    document.getElementById('edit_br_email').value = item.email || '';
    document.getElementById('edit_br_timing').value = item.timing_info || '';
    document.getElementById('edit_br_is_active').checked = parseInt(item.is_active) === 1;
    document.getElementById('editBranchModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
