<?php ob_start(); ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Hero Section & Dynamic Heading</h1>
            <p class="text-xs text-slate-500 mt-1">Manage the full-width homepage hero banner slides and the dynamic CMS-managed rotating heading below it.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="/" target="_blank" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Live Homepage
            </a>
            <button onclick="document.getElementById('createPhraseModal').classList.remove('hidden')" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Add Rotating Phrase
            </button>
            <button onclick="document.getElementById('createSlideModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Add Hero Slide
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Card 1: Interactive Live Preview of Heading Below Hero -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 rounded-3xl border border-slate-800 p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-6">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs uppercase font-extrabold tracking-widest text-slate-300">Live Heading Preview (Public Homepage)</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-slate-300 text-[11px] font-mono">
                    Duration: <strong id="previewDurationDisplay" class="text-amber-400"><?= (int)($config['rotation_duration'] ?? 3) ?>s</strong>
                </span>
                <span class="px-2.5 py-1 rounded-lg bg-white/10 text-slate-300 text-[11px] font-mono">
                    Style: <strong id="previewStyleDisplay" class="text-cyan-400"><?= htmlspecialchars($config['transition_style'] ?? 'slide-fade', ENT_QUOTES, 'UTF-8') ?></strong>
                </span>
                <button type="button" onclick="testRotateNext()" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-lg text-[11px] shadow-sm transition-all cursor-pointer">
                    ↻ Test Next Phrase
                </button>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 sm:p-10 text-center relative z-10">
            <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white tracking-tight leading-snug">
                <span id="previewFixedText"><?= htmlspecialchars($heroSection['heading'] ?? 'Empowering Young Minds Through', ENT_QUOTES, 'UTF-8') ?></span>
                <span class="inline-flex items-baseline justify-center relative overflow-hidden align-baseline ml-2 min-h-[1.25em]">
                    <span id="previewDynamicPhrase" class="text-amber-400 font-extrabold inline-block transition-all duration-300">
                        <?php
                        $activePhrases = array_values(array_filter($phrases, fn($p) => !empty($p['is_active'])));
                        echo htmlspecialchars($activePhrases[0]['phrase'] ?? 'Indian Dance', ENT_QUOTES, 'UTF-8');
                        ?>
                    </span>
                </span>
            </h2>
            <p id="previewSubtitleText" class="text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto mt-2 font-normal">
                <?= htmlspecialchars($heroSection['subheading'] ?? 'Premier Indian Dance Academy', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </div>

    <!-- Card 2: Fixed Heading & Slider Configuration -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Heading Configuration & Text Rotation Settings</h3>
                <p class="text-xs text-slate-500">Customize the permanent prefix text, subtitle, rotation duration, and animation style.</p>
            </div>
            <span class="px-2.5 py-1 bg-amber-50 border border-amber-200/60 text-amber-700 text-[11px] font-semibold rounded-lg">CMS Controls</span>
        </div>

        <form method="POST" action="/admin/hero/heading" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Permanent Fixed Prefix Text</label>
                    <input type="text" id="admin_heading_input" name="heading" required value="<?= htmlspecialchars($heroSection['heading'] ?? 'Empowering Young Minds Through', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" oninput="updatePreviewFixedText(this.value)">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: <strong>Empowering Young Minds Through</strong> (Always stays fixed while phrases rotate).</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Optional Subtitle / Tagline</label>
                    <input type="text" id="admin_subheading_input" name="subheading" value="<?= htmlspecialchars($heroSection['subheading'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g. Premier Indian Dance Academy" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" oninput="updatePreviewSubtitleText(this.value)">
                    <span class="text-[11px] text-slate-400 mt-1 block">Displayed directly beneath the main heading.</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Rotation Duration (Seconds)</label>
                    <div class="relative">
                        <input type="number" id="admin_duration_input" name="rotation_duration" min="2" max="15" step="1" required value="<?= (int)($config['rotation_duration'] ?? 3) ?>" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" oninput="updatePreviewDuration(this.value)">
                        <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">sec</span>
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Allowed range: 2 to 15 seconds (Default: 3 seconds).</span>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Transition Style</label>
                    <select id="admin_transition_input" name="transition_style" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none bg-white" onchange="updatePreviewTransition(this.value)">
                        <option value="slide-fade" <?= ($config['transition_style'] ?? 'slide-fade') === 'slide-fade' ? 'selected' : '' ?>>Fade & Slide (Smooth vertical slide with crossfade — Recommended)</option>
                        <option value="fade" <?= ($config['transition_style'] ?? 'slide-fade') === 'fade' ? 'selected' : '' ?>>Smooth Crossfade (Gentle opacity fade in-place)</option>
                        <option value="slide-up" <?= ($config['transition_style'] ?? 'slide-fade') === 'slide-up' ? 'selected' : '' ?>>Vertical Slide-Up (Contemporary ticker feel)</option>
                    </select>
                    <span class="text-[11px] text-slate-400 mt-1 block">How the phrase transitions to the next entry.</span>
                </div>
            </div>

            <div class="flex justify-end pt-2 border-t border-slate-100">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors cursor-pointer">
                    Save Heading & Rotation Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Card 3: Dynamic Rotating Phrases List -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900">CMS Rotating Heading Phrases (<?= count($phrases) ?>)</h3>
                <p class="text-xs text-slate-500 mt-0.5">These phrases automatically rotate after the fixed prefix text. You can add, edit, disable, reorder, or delete entries.</p>
            </div>
            <button onclick="document.getElementById('createPhraseModal').classList.remove('hidden')" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors cursor-pointer self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Add Rotating Phrase
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5 w-16 text-center">Sort</th>
                        <th class="px-6 py-3.5">Rotating Phrase Text</th>
                        <th class="px-6 py-3.5 w-32 text-center">Live Preview Badge</th>
                        <th class="px-6 py-3.5 w-28 text-center">Status</th>
                        <th class="px-6 py-3.5 w-36 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($phrases)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            No rotating phrases configured yet. Click "+ Add Rotating Phrase" to create one.
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach ($phrases as $phraseItem): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 text-center font-mono text-slate-700 font-semibold">
                            <?= (int)$phraseItem['sort_order'] ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($phraseItem['phrase'], ENT_QUOTES, 'UTF-8') ?></span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-600 border border-amber-200">
                                <?= htmlspecialchars($phraseItem['phrase'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="/admin/hero/phrases/<?= $phraseItem['id'] ?>/toggle" class="inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer <?= $phraseItem['is_active'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' ?>" title="Click to toggle status">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $phraseItem['is_active'] ? 'bg-emerald-500' : 'bg-slate-400' ?>"></span>
                                    <?= $phraseItem['is_active'] ? 'Active (Rotating)' : 'Disabled' ?>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="editPhrase(<?= htmlspecialchars(json_encode($phraseItem), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs cursor-pointer">Edit</button>
                            <form method="POST" action="/admin/hero/phrases/<?= $phraseItem['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this rotating phrase? At least one active phrase must remain.');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs cursor-pointer">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 4: Full-Width Hero Slider Images List -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Hero Slider Images (<?= count($slides) ?>)</h3>
                <p class="text-xs text-slate-500">Each image stretches 100% full width in the banner. You can upload new images, reorder them, or delete old ones.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5 w-16">Preview</th>
                        <th class="px-6 py-3.5">Title & Path</th>
                        <th class="px-6 py-3.5 w-24 text-center">Sort Order</th>
                        <th class="px-6 py-3.5 w-24 text-center">Status</th>
                        <th class="px-6 py-3.5 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($slides)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            No hero slides added yet. Click "+ Add Hero Slide" to upload one.
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach ($slides as $slide): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-20 h-12 rounded-lg bg-slate-950 overflow-hidden border border-slate-200 shadow-xs">
                                <img src="<?= htmlspecialchars($slide['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900"><?= htmlspecialchars($slide['title'] ?? 'Dynamic Children Academy Performance', ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="font-mono text-slate-400 text-[10px] mt-0.5 truncate max-w-md"><?= htmlspecialchars($slide['image_url'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono text-slate-600 font-semibold">
                            <?= (int)$slide['sort_order'] ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $slide['is_active'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-500' ?>">
                                <?= $slide['is_active'] ? 'Active' : 'Disabled' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="editSlide(<?= htmlspecialchars(json_encode($slide), ENT_QUOTES, 'UTF-8') ?>)" class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs cursor-pointer">Edit</button>
                            <form method="POST" action="/admin/hero/slides/<?= $slide['id'] ?>/delete" class="inline" onsubmit="return confirm('Delete this hero slide?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs cursor-pointer">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Create Phrase -->
<div id="createPhraseModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-900 mb-4">Add Rotating Heading Phrase</h3>
        <form method="POST" action="/admin/hero/phrases" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Phrase Text <span class="text-rose-500">*</span></label>
                <input type="text" name="phrase" required placeholder="e.g. Classical Dance, Cultural Excellence" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                <span class="text-[11px] text-slate-400 mt-1 block">This text will be highlighted in orange and rotate on the homepage.</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" id="isPhraseActive" checked class="rounded border-slate-300 text-amber-600">
                    <label for="isPhraseActive" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createPhraseModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold cursor-pointer">Save Phrase</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Phrase -->
<div id="editPhraseModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-900 mb-4">Edit Rotating Heading Phrase</h3>
        <form id="editPhraseForm" method="POST" action="" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Phrase Text <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_phrase_text" name="phrase" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_phrase_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" id="edit_phrase_is_active" name="is_active" class="rounded border-slate-300 text-amber-600">
                    <label for="edit_phrase_is_active" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editPhraseModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">Update Phrase</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Create Slide -->
<div id="createSlideModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-base font-bold text-slate-900 mb-4">Add Hero Slide Image</h3>
        <form method="POST" action="/admin/hero/slides" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Slide Title / Alt Text</label>
                <input type="text" name="title" placeholder="e.g. World Record Folk Dance Showcase" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Upload New Image File (JPG, PNG, WEBP)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-2 text-[10px] text-slate-400 uppercase font-semibold">Or use image path / URL</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Image URL / Path</label>
                <input type="text" name="image_url" placeholder="/assets/banners/homebanner.jpg" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" id="isSlideActive" checked class="rounded border-slate-300 text-indigo-600">
                    <label for="isSlideActive" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createSlideModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold cursor-pointer">Upload & Save Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Slide -->
<div id="editSlideModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <h3 class="text-base font-bold text-slate-900 mb-4">Edit Hero Slide Image</h3>
        <form id="editSlideForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Slide Title / Alt Text</label>
                <input type="text" id="edit_slide_title" name="title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Image File</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Current Image URL</label>
                <input type="text" id="edit_slide_image_url" name="image_url" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-mono text-[11px]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                    <input type="number" id="edit_slide_sort_order" name="sort_order" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" id="edit_slide_is_active" name="is_active" class="rounded border-slate-300 text-indigo-600">
                    <label for="edit_slide_is_active" class="text-xs text-slate-700 font-medium">Active (Visible)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editSlideModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold cursor-pointer">Update Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
// Available active phrases for preview
const previewPhrases = <?= json_encode(array_values(array_map(fn($p) => $p['phrase'], array_filter($phrases, fn($p) => !empty($p['is_active']))))) ?>;
let previewIndex = 0;
let previewInterval = null;

function updatePreviewFixedText(val) {
    document.getElementById('previewFixedText').textContent = val.trim() || 'Empowering Young Minds Through';
}

function updatePreviewSubtitleText(val) {
    document.getElementById('previewSubtitleText').textContent = val.trim();
}

function updatePreviewDuration(val) {
    const num = Math.max(2, Math.min(15, parseInt(val, 10) || 3));
    document.getElementById('previewDurationDisplay').textContent = num + 's';
    restartPreviewTimer();
}

function updatePreviewTransition(val) {
    document.getElementById('previewStyleDisplay').textContent = val;
}

function testRotateNext() {
    if (!previewPhrases || previewPhrases.length === 0) return;
    const phraseEl = document.getElementById('previewDynamicPhrase');
    if (!phraseEl) return;

    previewIndex = (previewIndex + 1) % previewPhrases.length;
    const nextPhrase = previewPhrases[previewIndex];
    const style = document.getElementById('admin_transition_input')?.value || 'slide-fade';

    phraseEl.style.transition = 'opacity 250ms ease, transform 250ms ease';
    if (style === 'slide-fade') {
        phraseEl.style.opacity = '0';
        phraseEl.style.transform = 'translateY(-8px)';
    } else if (style === 'slide-up') {
        phraseEl.style.opacity = '0';
        phraseEl.style.transform = 'translateY(-14px)';
    } else {
        phraseEl.style.opacity = '0';
    }

    setTimeout(() => {
        phraseEl.textContent = nextPhrase;
        phraseEl.style.transition = 'none';
        if (style === 'slide-fade') {
            phraseEl.style.transform = 'translateY(8px)';
        } else if (style === 'slide-up') {
            phraseEl.style.transform = 'translateY(14px)';
        } else {
            phraseEl.style.transform = 'none';
        }
        phraseEl.style.opacity = '0';

        void phraseEl.offsetHeight;

        phraseEl.style.transition = 'opacity 300ms ease, transform 300ms cubic-bezier(0.16, 1, 0.3, 1)';
        phraseEl.style.opacity = '1';
        phraseEl.style.transform = 'translateY(0)';
    }, 250);
}

function restartPreviewTimer() {
    if (previewInterval) clearInterval(previewInterval);
    if (!previewPhrases || previewPhrases.length <= 1) return;
    const durationInput = document.getElementById('admin_duration_input');
    const sec = Math.max(2, Math.min(15, parseInt(durationInput?.value, 10) || 3));
    previewInterval = setInterval(testRotateNext, sec * 1000);
}

document.addEventListener('DOMContentLoaded', function() {
    restartPreviewTimer();
});

function editSlide(slide) {
    document.getElementById('editSlideForm').action = '/admin/hero/slides/' + slide.id + '/update';
    document.getElementById('edit_slide_title').value = slide.title || '';
    document.getElementById('edit_slide_image_url').value = slide.image_url || '';
    document.getElementById('edit_slide_sort_order').value = slide.sort_order || 0;
    document.getElementById('edit_slide_is_active').checked = !!parseInt(slide.is_active);
    document.getElementById('editSlideModal').classList.remove('hidden');
}

function editPhrase(phrase) {
    document.getElementById('editPhraseForm').action = '/admin/hero/phrases/' + phrase.id + '/update';
    document.getElementById('edit_phrase_text').value = phrase.phrase || '';
    document.getElementById('edit_phrase_sort_order').value = phrase.sort_order || 0;
    document.getElementById('edit_phrase_is_active').checked = !!parseInt(phrase.is_active);
    document.getElementById('editPhraseModal').classList.remove('hidden');
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
