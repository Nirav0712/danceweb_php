<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?= $isNational ? 'National Cultural Tours' : 'International World Tours' ?></h1>
            <p class="text-xs text-slate-500 mt-1">Manage <?= $isNational ? 'state youth festivals and domestic' : 'global cultural' ?> tours and festival performances</p>
        </div>
        <button onclick="document.getElementById('createJourneyModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Tour Event
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Year</th>
                    <th class="px-6 py-3.5">Event & Festival</th>
                    <th class="px-6 py-3.5">Location</th>
                    <th class="px-6 py-3.5">Participants</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($events as $ev): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-bold text-indigo-600 font-mono"><?= (int)$ev['year'] ?></td>
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        <div><?= htmlspecialchars($ev['title'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="text-[11px] text-slate-400"><?= htmlspecialchars($ev['festival_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        <?= htmlspecialchars($ev['city'] ? "{$ev['city']}, {$ev['country']}" : $ev['country'], ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td class="px-6 py-4 text-slate-500 font-mono"><?= $ev['participants_count'] ? (int)$ev['participants_count'] : '—' ?></td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <?php $deleteUrl = $isNational ? "/admin/journey/national/{$ev['id']}/delete" : "/admin/journey/international/{$ev['id']}/delete"; ?>
                        <form method="POST" action="<?= $deleteUrl ?>" class="inline" onsubmit="return confirm('Delete this tour event?');">
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

<div id="createJourneyModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Tour Event</h3>
        <?php $actionUrl = $isNational ? '/admin/journey/national' : '/admin/journey/international'; ?>
        <form method="POST" action="<?= $actionUrl ?>" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tour Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Festival Name</label>
                <input type="text" name="festival_name" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country</label>
                    <input type="text" name="country" value="<?= $isNational ? 'India' : '' ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">City / State</label>
                    <input type="text" name="city" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Participants Count</label>
                    <input type="number" name="participants_count" placeholder="e.g. 24" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cover Image URL</label>
                <input type="text" name="cover_image_url" placeholder="/uploads/tours/tour1.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createJourneyModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Save Tour Event</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
