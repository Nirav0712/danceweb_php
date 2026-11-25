<?php
ob_start();
?>
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Overview</h1>
            <p class="text-xs text-slate-500 mt-1">Real-time metrics and dynamic CMS administration status</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold">
                Role: <?= htmlspecialchars($user['role'] ?? 'EDITOR', ENT_QUOTES, 'UTF-8') ?>
            </span>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Pages</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['pages'] ?? 0) ?></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Gallery</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['gallery'] ?? 0) ?></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Stories</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['blogs'] ?? 0) ?></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Press News</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['news'] ?? 0) ?></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Awards</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['awards'] ?? 0) ?></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 block mb-1 uppercase tracking-wider">Leads</span>
            <span class="text-2xl font-bold text-slate-900"><?= (int) ($metrics['enquiries'] ?? 0) ?></span>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-2">Phase 02 Architecture Status</h2>
        <div class="space-y-2 text-xs text-slate-600">
            <p class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <strong>Core PHP Foundation:</strong> Operational with front-controller and URL router.
            </p>
            <p class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <strong>PDO MySQL Connection:</strong> Active with prepared statements and UTF8mb4.
            </p>
            <p class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <strong>RBAC Guardrails:</strong> Role-based access control verified for SUPER_ADMIN, ADMIN, and EDITOR.
            </p>
            <p class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <strong>Hostinger Compatibility:</strong> Configured for Apache shared hosting with .htaccess front controller.
            </p>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
