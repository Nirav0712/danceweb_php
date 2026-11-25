<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Campuses & Studio Branches</h1>
            <p class="text-xs text-slate-500 mt-1">Manage physical academy locations, phones, batch timings, and map embeds</p>
        </div>
        <button onclick="document.getElementById('createBranchModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Campus Branch
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

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
                <form method="POST" action="/admin/branches/<?= $b['id'] ?>/delete" onsubmit="return confirm('Delete this branch campus?');">
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
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
