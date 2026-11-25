<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Setup', ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 text-slate-800">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-sm border border-slate-200/80 p-8 sm:p-10">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                D
            </div>
            <div>
                <span class="font-bold text-slate-900 text-base leading-tight block">Initial Admin Setup</span>
                <span class="text-[10px] uppercase font-bold tracking-wider text-indigo-600 block">One-Time Administrator Creation</span>
            </div>
        </div>

        <h1 class="text-xl font-bold text-slate-900 mb-1">Create Super Admin</h1>
        <p class="text-xs text-slate-500 mb-6">Create the master administrator account with a strong, unique password.</p>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200/60 text-red-700 text-xs font-medium">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="/admin/setup" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label for="full_name" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Full Name</label>
                <input type="text" id="full_name" name="full_name" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm transition-all"
                    placeholder="Academy Super Admin">
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Email Address</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm transition-all"
                    placeholder="admin@dynamicechildrenacademy.com">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Password (Min 12 Characters)</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm transition-all"
                    placeholder="••••••••••••••••">
            </div>

            <div>
                <label for="confirm_password" class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm transition-all"
                    placeholder="••••••••••••••••">
            </div>

            <button type="submit"
                class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center justify-center">
                Initialize Admin Account
            </button>
        </form>
    </div>
</body>
</html>
