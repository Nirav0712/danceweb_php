<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Setup Locked', ENT_QUOTES, 'UTF-8') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 font-sans text-slate-800">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 text-center">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 font-bold text-xl">
            🔒
        </div>
        <h1 class="text-xl font-bold text-slate-900 mb-2">Setup Already Completed</h1>
        <p class="text-sm text-slate-500 mb-6"><?= htmlspecialchars($message ?? 'Administrator account already exists.', ENT_QUOTES, 'UTF-8') ?></p>
        <a href="/admin/login" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all">
            Proceed to Login
        </a>
    </div>
</body>
</html>
