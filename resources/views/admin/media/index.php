<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Media Assets Library</h1>
            <p class="text-xs text-slate-500 mt-1">Upload and manage images with automatic MIME inspection and storage</p>
        </div>
        <button onclick="document.getElementById('uploadMediaModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Upload Asset
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl"><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php foreach ($media as $m): ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-xs group relative flex flex-col justify-between">
            <div class="aspect-square rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                <img src="<?= htmlspecialchars($m['url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($m['alt_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.src='/assets/images/logo.png'">
            </div>
            <div class="mt-2 text-[11px] truncate text-slate-700 font-medium px-1" title="<?= htmlspecialchars($m['original_filename'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($m['original_filename'] ?? basename($m['url']), ENT_QUOTES, 'UTF-8') ?>
            </div>
            <div class="flex items-center justify-between mt-1 px-1 text-[10px] text-slate-400">
                <span><?= strtoupper($m['format'] ?? 'IMG') ?></span>
                <form method="POST" action="/admin/media/<?= $m['id'] ?>/delete" onsubmit="return confirm('Delete this media asset?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="uploadMediaModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Upload Media File</h3>
        <form method="POST" action="/admin/media/upload" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Select File (JPG, PNG, WEBP, GIF, SVG - max 5MB)</label>
                <input type="file" name="file" required accept="image/*" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Folder Category</label>
                <input type="text" name="folder" value="general" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Alt Text</label>
                <input type="text" name="alt_text" placeholder="Description for SEO and accessibility" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('uploadMediaModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold">Upload</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
