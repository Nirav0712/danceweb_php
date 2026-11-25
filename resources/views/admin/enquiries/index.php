<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Admission Enquiries & Leads</h1>
            <p class="text-xs text-slate-500 mt-1">Review contact form inquiries, update workflow statuses, and export leads</p>
        </div>
        <a href="/admin/enquiries/export" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-2">
            <span>↓</span> Export to CSV
        </a>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Candidate</th>
                        <th class="px-6 py-3.5">Contact Details</th>
                        <th class="px-6 py-3.5">Subject & Notes</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($enquiries as $eq): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            <div><?= htmlspecialchars($eq['name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-[11px] text-slate-400 font-normal"><?= htmlspecialchars($eq['preferred_branch'] ?? 'Main Branch') ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-800"><?= htmlspecialchars($eq['email'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-[11px] text-slate-400 font-mono"><?= htmlspecialchars($eq['phone'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="font-semibold text-slate-800 truncate"><?= htmlspecialchars($eq['subject'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-[11px] text-slate-500 line-clamp-2"><?= htmlspecialchars($eq['message'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php if ($eq['admin_notes']): ?>
                                <div class="mt-1 text-[10px] text-indigo-600 bg-indigo-50/60 p-1 rounded font-mono">Note: <?= htmlspecialchars($eq['admin_notes'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="/admin/enquiries/<?= $eq['id'] ?>/status" class="flex items-center gap-1.5">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <select name="status" onchange="this.form.submit()" class="px-2 py-1 border border-slate-200 rounded-lg text-[11px] font-semibold <?= $eq['status'] === 'NEW' ? 'bg-amber-50 text-amber-700' : ($eq['status'] === 'CONVERTED' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-50 text-slate-700') ?>">
                                    <option value="NEW" <?= $eq['status'] === 'NEW' ? 'selected' : '' ?>>NEW</option>
                                    <option value="CONTACTED" <?= $eq['status'] === 'CONTACTED' ? 'selected' : '' ?>>CONTACTED</option>
                                    <option value="CONVERTED" <?= $eq['status'] === 'CONVERTED' ? 'selected' : '' ?>>CONVERTED</option>
                                    <option value="CLOSED" <?= $eq['status'] === 'CLOSED' ? 'selected' : '' ?>>CLOSED</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <form method="POST" action="/admin/enquiries/<?= $eq['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this enquiry?');">
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
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
