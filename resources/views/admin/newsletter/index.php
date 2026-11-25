<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Newsletter Subscribers</h1>
            <p class="text-xs text-slate-500 mt-1">Manage audience mailing list subscriptions and export data</p>
        </div>
        <a href="/admin/newsletter/export" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-2">
            <span>↓</span> Export to CSV
        </a>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                <tr>
                    <th class="px-6 py-3.5">Subscriber Email</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5">Subscribed Date</th>
                    <th class="px-6 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($subscribers as $sub): ?>
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($sub['email'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 <?= $sub['is_subscribed'] ? 'text-emerald-700' : 'text-slate-400' ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?= $sub['is_subscribed'] ? 'bg-emerald-500' : 'bg-slate-300' ?>"></span>
                            <?= $sub['is_subscribed'] ? 'Subscribed' : 'Unsubscribed' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 font-mono text-slate-500"><?= date('M j, Y H:i', strtotime($sub['subscribed_at'])) ?></td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form method="POST" action="/admin/newsletter/<?= $sub['id'] ?>/toggle" class="inline">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs"><?= $sub['is_subscribed'] ? 'Unsubscribe' : 'Re-subscribe' ?></button>
                        </form>
                        <form method="POST" action="/admin/newsletter/<?= $sub['id'] ?>/delete" class="inline" onsubmit="return confirm('Remove subscriber?');">
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
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
