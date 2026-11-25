<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Affiliations & Cultural Partners</h1>
            <p class="text-xs text-slate-500 mt-1">Manage partner organizations, universities, and cultural councils</p>
        </div>
        <button onclick="document.getElementById('createAssocModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Affiliation
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <?php foreach ($associations as $assoc): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col items-center text-center justify-between">
            <div class="w-20 h-20 rounded-xl bg-slate-50 border border-slate-100 p-2 flex items-center justify-center mb-3">
                <img src="<?= htmlspecialchars($assoc['logo_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($assoc['name'], ENT_QUOTES, 'UTF-8') ?>" class="max-h-full max-w-full object-contain">
            </div>
            <div>
                <h4 class="font-bold text-slate-900 text-xs"><?= htmlspecialchars($assoc['name'], ENT_QUOTES, 'UTF-8') ?></h4>
                <div class="text-[10px] text-indigo-600 font-semibold mt-0.5"><?= htmlspecialchars($assoc['acronym'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 w-full flex justify-between items-center text-[11px]">
                <span class="<?= $assoc['is_active'] ? 'text-emerald-600' : 'text-slate-400' ?>"><?= $assoc['is_active'] ? 'Active' : 'Hidden' ?></span>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="editAssoc(<?= htmlspecialchars(json_encode($assoc), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold">Edit</button>
                    <form method="POST" action="/admin/associations/<?= $assoc['id'] ?>/delete" onsubmit="return confirm('Delete this partner?');" class="inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="createAssocModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Affiliation</h3>
        <form method="POST" action="/admin/associations" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Organization Name</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Acronym / Short Code</label>
                <input type="text" name="acronym" placeholder="e.g. CIOFF, IOV" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Logo URL</label>
                <input type="text" name="logo_url" required placeholder="/uploads/partners/logo.png" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Website URL</label>
                <input type="text" name="website_url" placeholder="https://..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isActAssoc" checked class="rounded border-slate-300 text-indigo-600">
                <label for="isActAssoc" class="text-xs text-slate-600">Active Partner</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createAssocModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Partner</button>
            </div>
        </form>
    </div>
</div>

<div id="editAssocModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Affiliation</h3>
        <form id="editAssocForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Organization Name</label>
                <input type="text" id="edit_assoc_name" name="name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Acronym / Short Code</label>
                <input type="text" id="edit_assoc_acronym" name="acronym" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Logo URL</label>
                <input type="text" id="edit_assoc_logo_url" name="logo_url" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Website URL</label>
                <input type="text" id="edit_assoc_website_url" name="website_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_assoc_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                <label for="edit_assoc_is_active" class="text-xs text-slate-600">Active Partner</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editAssocModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Update Partner</button>
            </div>
        </form>
    </div>
</div>

<script>
function editAssoc(item) {
    document.getElementById('editAssocForm').action = '/admin/associations/' + item.id + '/update';
    document.getElementById('edit_assoc_name').value = item.name || '';
    document.getElementById('edit_assoc_acronym').value = item.acronym || '';
    document.getElementById('edit_assoc_logo_url').value = item.logo_url || '';
    document.getElementById('edit_assoc_website_url').value = item.website_url || '';
    document.getElementById('edit_assoc_is_active').checked = parseInt(item.is_active) === 1;
    document.getElementById('editAssocModal').classList.remove('hidden');
}
</script>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
