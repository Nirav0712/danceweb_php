<?php
ob_start();

$pageTitle = $page['title'] ?? ($isNational ? 'Our National Journey' : 'Our International Journey');
$pageSubtitle = $page['subtitle'] ?? ($isNational ? 'Showcasing the vibrant folk heritage of Gujarat on premier national stages, Rashtriya Lok Utsavs, and state festivals.' : 'Representing India at prestigious international folk dance festivals across Europe, Asia, and the Middle East.');
$metaTitle = $page['meta_title'] ?? '';
$metaDesc = $page['meta_description'] ?? '';

$sectionKey = $isNational ? 'national_map_showcase' : 'international_map_showcase';
$mapSec = $sections[$sectionKey] ?? [];
$mapData = !empty($mapSec['content']) ? json_decode($mapSec['content'], true) : [];

$heroBadge = $mapData['hero_badge'] ?? ($mapSec['subheading'] ?? ($isNational ? 'Across India' : 'Global Tours'));
$mapHeading = $mapData['map_heading'] ?? ($mapSec['heading'] ?? ($isNational ? 'Tours Across Major Indian States' : 'Tours Across World Nations'));
$mapBadge = $mapData['map_badge'] ?? ($isNational ? 'National Map & Conclaves' : 'Global Footprint & Festivals');
$mapBaseNote = $mapData['map_base_note'] ?? ($isNational ? 'Base: Ahmedabad | Over 28+ National Festivals' : 'Base: Ahmedabad | 15+ World Nations');
$ctaText = $mapData['cta_text'] ?? ($isNational ? 'Want to see our international tours across 15+ world nations?' : 'Want to see our domestic tours across Indian states?');
$ctaUrl = $mapData['cta_url'] ?? ($isNational ? '/journey/international' : '/journey/national');
?>

<div class="space-y-6 pb-12">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900"><?= $isNational ? 'National Cultural Tours Management' : 'International World Tours Management' ?></h1>
            <p class="text-xs text-slate-500 mt-1">Manage <?= $isNational ? 'domestic state youth festivals, conclaves, map settings, and tour records' : 'global cultural festivals, world records tours, and events' ?></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= $isNational ? '/journey/national' : '/journey/international' ?>" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Live Page</span>
            </a>
            <button onclick="document.getElementById('createJourneyModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Add Tour Event</span>
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <span><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <!-- CARD 1: Page Header & Map Showcase CMS Settings -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">🗺️</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800"><?= $isNational ? 'National Journey Header &amp; Map Settings' : 'International Journey Header &amp; Map Settings' ?></h2>
                    <p class="text-[11px] text-slate-400">Configure page hero banner, map showcase headings, base tags, and cross-journey CTA links</p>
                </div>
            </div>
            <button type="submit" form="journeySettingsForm" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Header &amp; Map Settings</span>
            </button>
        </div>

        <?php $settingsActionUrl = $isNational ? '/admin/journey/national/settings' : '/admin/journey/international/settings'; ?>
        <form id="journeySettingsForm" method="POST" action="<?= $settingsActionUrl ?>" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

            <!-- Hero Banner Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Pill Badge</label>
                    <input type="text" name="hero_badge" value="<?= htmlspecialchars($heroBadge, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title</label>
                    <input type="text" name="page_title" value="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Map Section Badge</label>
                    <input type="text" name="map_badge" value="<?= htmlspecialchars($mapBadge, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Page Subtitle</label>
                <textarea name="page_subtitle" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"><?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <!-- Map Card Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Map Heading</label>
                    <input type="text" name="map_heading" value="<?= htmlspecialchars($mapHeading, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Base Footnote Pill</label>
                    <input type="text" name="map_base_note" value="<?= htmlspecialchars($mapBaseNote, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Cross-Journey CTA Link URL</label>
                    <input type="text" name="cta_url" value="<?= htmlspecialchars($ctaUrl, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Cross-Journey CTA Text</label>
                <input type="text" name="cta_text" value="<?= htmlspecialchars($ctaText, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <!-- SEO Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($metaTitle, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($metaDesc, ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>
        </form>
    </div>

    <!-- CARD 2: Tour Events List Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-800">
                    <?= $isNational ? 'National Tour Events' : 'International Tour Events' ?> 
                    <span class="text-xs font-normal text-slate-400">(<?= count($events) ?> records)</span>
                </h3>
                <p class="text-[11px] text-slate-400">Domestic festival recitals, Rashtriya Lok Utsavs, and conclaves shown on the public page</p>
            </div>
            <button onclick="document.getElementById('createJourneyModal').classList.remove('hidden')" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition-colors">
                + Add Event
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Cover</th>
                        <th class="px-6 py-3.5">Year</th>
                        <th class="px-6 py-3.5">Event &amp; Festival</th>
                        <th class="px-6 py-3.5">Location</th>
                        <th class="px-6 py-3.5">Artists</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($events)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs">
                                No tour events found. Click "+ Add Tour Event" to add your first national tour.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($events as $idx => $ev): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-14 h-10 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                <img
                                    src="<?= htmlspecialchars($ev['cover_image_url'] ?: '/assets/gallery/' . (($idx % 8) + 1) . '.jpg', ENT_QUOTES, 'UTF-8') ?>"
                                    alt=""
                                    class="w-full h-full object-cover"
                                    onerror="this.src='/assets/about/founded-2002-stage.jpg';"
                                >
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-indigo-600 font-mono"><?= (int)$ev['year'] ?></td>
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            <div><?= htmlspecialchars($ev['title'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php if (!empty($ev['festival_name'])): ?>
                                <div class="text-[11px] text-slate-400 font-normal">Event: <?= htmlspecialchars($ev['festival_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                            <?php if (!empty($ev['description'])): ?>
                                <div class="text-[11px] text-slate-500 font-normal line-clamp-1 max-w-md mt-0.5"><?= htmlspecialchars($ev['description'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <span class="inline-flex items-center gap-1">
                                📍 <?= htmlspecialchars($ev['city'] ? "{$ev['city']}, {$ev['country']}" : $ev['country'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            <?= !empty($ev['participants_count']) ? (int)$ev['participants_count'] . ' Artists' : '—' ?>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <?php 
                            $updateUrl = $isNational ? "/admin/journey/national/{$ev['id']}/update" : "/admin/journey/international/{$ev['id']}/update";
                            $deleteUrl = $isNational ? "/admin/journey/national/{$ev['id']}/delete" : "/admin/journey/international/{$ev['id']}/delete"; 
                            ?>
                            <button
                                type="button"
                                onclick="editJourney(<?= htmlspecialchars(json_encode($ev), ENT_QUOTES, 'UTF-8') ?>, '<?= $updateUrl ?>')"
                                class="px-2.5 py-1 text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg font-semibold text-xs transition-colors cursor-pointer"
                            >
                                Edit
                            </button>
                            <form method="POST" action="<?= $deleteUrl ?>" class="inline" onsubmit="return confirm('Delete tour event <?= htmlspecialchars(addslashes($ev['title']), ENT_QUOTES, 'UTF-8') ?>?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="px-2.5 py-1 text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 rounded-lg font-semibold text-xs transition-colors cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =========================================================================
    MODAL 1: Add Tour Event Modal (with File Upload + Description)
    ========================================================================= -->
<div id="createJourneyModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Add <?= $isNational ? 'National' : 'International' ?> Tour Event</h3>
            <button type="button" onclick="document.getElementById('createJourneyModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none cursor-pointer">&times;</button>
        </div>

        <?php $actionUrl = $isNational ? '/admin/journey/national' : '/admin/journey/international'; ?>
        <form method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tour Title *</label>
                <input type="text" name="title" required placeholder="e.g. Delhi Republic Day National Cultural Conclave" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Festival / Conclave Name</label>
                <input type="text" name="festival_name" placeholder="e.g. Rashtriya Lok Utsav" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country *</label>
                    <input type="text" name="country" value="<?= $isNational ? 'India' : '' ?>" required placeholder="e.g. <?= $isNational ? 'India' : 'Turkey' ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country Code</label>
                    <input type="text" name="country_code" value="<?= $isNational ? 'IN' : '' ?>" maxlength="4" placeholder="e.g. TR" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-mono uppercase">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">City / State</label>
                    <input type="text" name="city" placeholder="e.g. <?= $isNational ? 'New Delhi' : 'Istanbul' ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year *</label>
                    <input type="number" name="year" value="<?= date('Y') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Artists / Participants Count</label>
                <input type="number" name="participants_count" placeholder="e.g. 40" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Event Description &amp; Performance Highlights</label>
                <textarea name="description" rows="3" placeholder="Represented Gujarat state folk traditions with 40 child artists at the National Cultural Conclave..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"></textarea>
            </div>

            <!-- Image Upload & URL input -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Cover Photo (Upload Image or Enter URL)</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <input type="text" name="cover_image_url" placeholder="Or enter URL: /assets/national/year1.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="0" class="w-24 px-3 py-1.5 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createJourneyModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Save Tour Event</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
    MODAL 2: Edit Tour Event Modal (with File Upload + Description)
    ========================================================================= -->
<div id="editJourneyModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Edit Tour Event</h3>
            <button type="button" onclick="document.getElementById('editJourneyModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none cursor-pointer">&times;</button>
        </div>

        <form id="editJourneyForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tour Title *</label>
                <input type="text" id="edit_j_title" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Festival / Conclave Name</label>
                <input type="text" id="edit_j_festival_name" name="festival_name" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country *</label>
                    <input type="text" id="edit_j_country" name="country" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Country Code</label>
                    <input type="text" id="edit_j_country_code" name="country_code" maxlength="4" placeholder="e.g. TR" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-mono uppercase">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">City / State</label>
                    <input type="text" id="edit_j_city" name="city" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year *</label>
                    <input type="number" id="edit_j_year" name="year" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Artists / Participants Count</label>
                <input type="number" id="edit_j_participants_count" name="participants_count" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Event Description &amp; Performance Highlights</label>
                <textarea id="edit_j_description" name="description" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"></textarea>
            </div>

            <!-- Image Upload & Preview -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-semibold text-slate-700">Cover Photo</label>
                    <span id="edit_j_current_img_label" class="text-[11px] text-slate-400 truncate max-w-xs"></span>
                </div>
                <input type="file" name="cover_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <input type="text" id="edit_j_cover_image_url" name="cover_image_url" placeholder="/assets/national/year1.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sort Order</label>
                <input type="number" id="edit_j_sort_order" name="sort_order" value="0" class="w-24 px-3 py-1.5 border border-slate-200 rounded-xl text-xs outline-none">
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editJourneyModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Update Tour Event</button>
            </div>
        </form>
    </div>
</div>

<script>
function editJourney(item, actionUrl) {
    var form = document.getElementById('editJourneyForm');
    if (!form) return;
    form.action = actionUrl;

    document.getElementById('edit_j_title').value = item.title || '';
    document.getElementById('edit_j_festival_name').value = item.festival_name || '';
    document.getElementById('edit_j_country').value = item.country || '';
    document.getElementById('edit_j_country_code').value = item.country_code || '';
    document.getElementById('edit_j_city').value = item.city || '';
    document.getElementById('edit_j_year').value = item.year || new Date().getFullYear();
    document.getElementById('edit_j_participants_count').value = item.participants_count || '';
    document.getElementById('edit_j_description').value = item.description || '';
    document.getElementById('edit_j_cover_image_url').value = item.cover_image_url || '';
    document.getElementById('edit_j_sort_order').value = item.sort_order || 0;

    var curLabel = document.getElementById('edit_j_current_img_label');
    if (curLabel) {
        curLabel.textContent = item.cover_image_url ? 'Current: ' + item.cover_image_url : 'No image uploaded';
    }

    document.getElementById('editJourneyModal').classList.remove('hidden');
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
