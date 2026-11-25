<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Tour Flags Carousel</h1>
            <p class="text-xs text-slate-500 mt-1">Manage country flags and international festival links shown on the homepage</p>
        </div>
        <button onclick="document.getElementById('createFlagModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Tour Flag
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
        <?php foreach ($flags as $fl): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3 shadow-xs flex flex-col items-center text-center justify-between">
            <div class="w-16 h-12 rounded-lg bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center mb-2">
                <img src="<?= htmlspecialchars($fl['flag_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($fl['country_name'], ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover">
            </div>
            <div>
                <h4 class="font-bold text-slate-900 text-xs"><?= htmlspecialchars($fl['country_name'], ENT_QUOTES, 'UTF-8') ?></h4>
                <div class="text-[10px] text-slate-400"><?= (int)$fl['year'] ?></div>
            </div>
            <div class="mt-2 pt-2 border-t border-slate-100 w-full flex justify-between items-center text-[10px]">
                <span class="<?= $fl['is_active'] ? 'text-emerald-600' : 'text-slate-400' ?>"><?= $fl['is_active'] ? 'Active' : 'Hidden' ?></span>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="editFlag(<?= htmlspecialchars(json_encode($fl), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold">Edit</button>
                    <form method="POST" action="/admin/tour-flags/<?= $fl['id'] ?>/delete" onsubmit="return confirm('Delete this flag?');" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="createFlagModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Tour Flag</h3>
        <form method="POST" action="/admin/tour-flags" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Country Name</label>
                <input type="text" name="country_name" required placeholder="e.g. Turkey, Poland" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Flag Image URL</label>
                <input type="text" name="flag_url" required placeholder="/uploads/flags/flag.png" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country Code</label>
                    <input type="text" name="country_code" placeholder="e.g. TR" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Festival / Target URL</label>
                <input type="text" name="target_url" placeholder="/journey/international" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isActFl" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isActFl" class="text-xs text-slate-600">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createFlagModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Flag</button>
            </div>
        </form>
    </div>
</div>

<div id="editFlagModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Tour Flag</h3>
        <form id="editFlagForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Country Name</label>
                <input type="text" id="edit_fl_country_name" name="country_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Flag Image URL</label>
                <input type="text" id="edit_fl_flag_url" name="flag_url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" id="edit_fl_year" name="year" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country Code</label>
                    <input type="text" id="edit_fl_country_code" name="country_code" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Festival / Target URL</label>
                <input type="text" id="edit_fl_target_url" name="target_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_fl_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                <label for="edit_fl_is_active" class="text-xs text-slate-600">Active</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editFlagModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Flag</button>
            </div>
        </form>
    </div>
</div>

<script>
function editFlag(item) {
    document.getElementById('editFlagForm').action = '/admin/tour-flags/' + item.id + '/update';
    document.getElementById('edit_fl_country_name').value = item.country_name || '';
    document.getElementById('edit_fl_flag_url').value = item.flag_url || '';
    document.getElementById('edit_fl_year').value = item.year || '';
    document.getElementById('edit_fl_country_code').value = item.country_code || '';
    document.getElementById('edit_fl_target_url').value = item.target_url || '';
    document.getElementById('edit_fl_is_active').checked = parseInt(item.is_active) === 1;
    document.getElementById('editFlagModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
