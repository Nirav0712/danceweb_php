<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Audit Activity Logs</h1>
            <p class="text-xs text-slate-500 mt-1">Immutable security audit trail of staff actions, content modifications and logins</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Timestamp</th>
                        <th class="px-6 py-3.5">User</th>
                        <th class="px-6 py-3.5">Action</th>
                        <th class="px-6 py-3.5">Entity</th>
                        <th class="px-6 py-3.5">IP Address</th>
                        <th class="px-6 py-3.5">Payload Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">No audit events recorded yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 font-mono text-slate-500 whitespace-nowrap"><?= date('M j, Y H:i:s', strtotime($log['created_at'])) ?></td>
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= htmlspecialchars($log['user_name'] ?? $log['user_email'] ?? 'System', ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $log['action'] === 'CREATE' ? 'bg-emerald-50 text-emerald-700' : ($log['action'] === 'DELETE' ? 'bg-rose-50 text-rose-700' : 'bg-indigo-50 text-indigo-700') ?>">
                                    <?= htmlspecialchars($log['action'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                <?= htmlspecialchars($log['entity'], ENT_QUOTES, 'UTF-8') ?> <?= $log['entity_id'] ? '#' . (int)$log['entity_id'] : '' ?>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-400"><?= htmlspecialchars($log['ip_address'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-[11px] max-w-xs truncate" title="<?= htmlspecialchars($log['details'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($log['details'] ?? '—', ENT_QUOTES, 'UTF-8') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
