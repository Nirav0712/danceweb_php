<?php
ob_start();

$foundedData = !empty($sections['about_founded']['content']) ? json_decode($sections['about_founded']['content'], true) : [];
$techData = !empty($sections['about_technique']['content']) ? json_decode($sections['about_technique']['content'], true) : [];
$frameData = !empty($sections['about_framework']['content']) ? json_decode($sections['about_framework']['content'], true) : [];
$awardsData = !empty($sections['about_awards']['content']) ? json_decode($sections['about_awards']['content'], true) : [];
$mediaData = !empty($sections['about_media']['content']) ? json_decode($sections['about_media']['content'], true) : [];
$visionData = !empty($sections['about_vision']['content']) ? json_decode($sections['about_vision']['content'], true) : [];
$ctaSec = $sections['about_cta'] ?? [];
?>

<div class="space-y-6 pb-12">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">About Us Page Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage all 6 sections, storytelling narratives, framework steps, media stats, and SEO metadata</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/about" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Live Page</span>
            </a>
            <button type="submit" form="aboutPageForm" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5 cursor-pointer transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save All Changes</span>
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

    <form id="aboutPageForm" method="POST" action="/admin/about" enctype="multipart/form-data" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">

        <!-- CARD 1: Page Header & Hero Banner -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">🚩</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">1. Hero Banner &amp; Page Titles</h2>
                    <p class="text-[11px] text-slate-400">Controls the top title, subtitle and search engine metadata</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="page_title" required value="<?= htmlspecialchars($page['title'] ?? 'About Us', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtitle / Tagline</label>
                    <input type="text" name="page_subtitle" value="<?= htmlspecialchars($page['subtitle'] ?? 'Founded in 2002 by Director Tirthraj Trivedi', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? 'Dynamice Children Academy | About Us', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Meta Description (SEO)</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($page['meta_description'] ?? 'Government-Registered Dance Academy training children aged 4-14 years in classical, folk, and contemporary dance forms.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- CARD 2: Section 1 — Founded in 2002 -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-sm">🏛️</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">2. Section 1: Founded in 2002 (Story &amp; Photo)</h2>
                    <p class="text-[11px] text-slate-400">Academy founding story, stage recital photo, and trust credentials</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Section Badge</label>
                    <input type="text" name="founded_badge" value="<?= htmlspecialchars($sections['about_founded']['subheading'] ?? 'ABOUT US', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                    <input type="text" name="founded_heading" value="<?= htmlspecialchars($sections['about_founded']['heading'] ?? 'Founded in 2002', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Inception Year</label>
                    <input type="text" name="founded_est_year" value="<?= htmlspecialchars($foundedData['est_year'] ?? '2002', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Students Trained Pill</label>
                    <input type="text" name="founded_students_trained" value="<?= htmlspecialchars($foundedData['students_trained'] ?? '6,000+ Students Trained', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500">
                </div>
            </div>

            <!-- Image Upload / URL -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-semibold text-slate-700">Stage Recital Photo</label>
                    <span class="text-[11px] text-slate-400">Current: <?= htmlspecialchars($sections['about_founded']['image_url'] ?? '/assets/about/founded-2002-stage.jpg', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <input type="file" name="founded_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                <input type="text" name="founded_image_url" value="<?= htmlspecialchars($sections['about_founded']['image_url'] ?? '/assets/about/founded-2002-stage.jpg', ENT_QUOTES, 'UTF-8') ?>" placeholder="/assets/about/founded-2002-stage.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
            </div>

            <!-- 4 Paragraphs -->
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Paragraph 1 (Origins &amp; Vision)</label>
                    <textarea name="founded_p1" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"><?= htmlspecialchars($foundedData['p1'] ?? "Founded in 2002 by Director Tirthraj Trivedi with just 14 students, our academy has grown into a prestigious institution that has proudly trained more than 6,000 young learners. Guided by a strong vision to nurture India’s culture, traditions, and values in the next generation, we have become a trusted platform for children aged 4 to 14 years to learn, express, and shine.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Paragraph 2 (Government &amp; Quality Certifications)</label>
                    <textarea name="founded_p2" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"><?= htmlspecialchars($foundedData['p2'] ?? "We are a Government-Registered Institution, a Government-Approved Vocational Training Centre, and a Trademark-Registered Academy under the Government of India. Our commitment to excellence is further strengthened by certifications from IAF and EGAC for maintaining a high-quality management system.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Paragraph 3 (World Records &amp; UNESCO Partners)</label>
                    <textarea name="founded_p3" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"><?= htmlspecialchars($foundedData['p3'] ?? "Our academy has earned international recognition, marking its name in the London Book of World Records and becoming an esteemed member of CIOFF (International Council of Organizations of Folklore Festivals and Folk Arts) and IOV (International Organization of Folk Art). These affiliations allow our students to proudly represent India on global platforms.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Paragraph 4 (Mission &amp; Cultural Values)</label>
                    <textarea name="founded_p4" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 leading-relaxed"><?= htmlspecialchars($foundedData['p4'] ?? "With a mission to instill cultural values, discipline, and artistic excellence, we provide world-class training and international-stage opportunities. We strive to shape ambitious, confident, and culturally enriched young minds who carry the pride and authenticity of India across the world.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 3: Section 2 — Dance Technique & Steps -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">🩰</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">3. Section 2: Our Dance Technique (3 Interactive Steps &amp; Checklist)</h2>
                    <p class="text-[11px] text-slate-400">Controls the interactive step switchers and checklist pills</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Badge</label>
                    <input type="text" name="technique_badge" value="<?= htmlspecialchars($sections['about_technique']['subheading'] ?? 'OUR DANCE TECHNIQUE', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                    <input type="text" name="technique_heading" value="<?= htmlspecialchars($sections['about_technique']['heading'] ?? "We're some simple steps for teaching dance", ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500 font-bold">
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dance Step 01 Description</label>
                    <textarea name="technique_step1" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"><?= htmlspecialchars($techData['step1'] ?? "Dramatically initiate our mission in 2002 with minimal initial investment, rapidly expanding operational capacity to over 6,000 students trained. Systematically scale our educational footprint over 23 years of sustained deployment, ensuring continuous market leadership in artistic and cultural development. Compellingly leverage the visionary expertise of Founder Tirthraj Trivedi to anchor value-driven educational portals.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dance Step 02 Description</label>
                    <textarea name="technique_step2" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"><?= htmlspecialchars($techData['step2'] ?? "We launched our mission in 2002 with minimal initial investment, swiftly expanding our operational capacity to exceed 6,000 trained students. We have systematically enlarged our educational footprint over 23 years of continuous deployment, guaranteeing sustained market dominance in artistic and cultural development. We compellingly harness the visionary acumen of Founder Tirthraj Trivedi to secure value-driven educational gateways.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dance Step 03 Description</label>
                    <textarea name="technique_step3" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-indigo-500"><?= htmlspecialchars($techData['step3'] ?? "Our endeavor began dramatically in 2002 with a paltry initial investment, rapidly increasing our operational capacity to over 6,000 students educated. We have methodically expanded our educational presence across 23 years of uninterrupted deployment, maintaining perpetual market preeminence in artistic and cultural development. We powerfully utilize the visionary expertise of Founder Tirthraj Trivedi to anchor value-driven educational platforms.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>

            <!-- 4 Checklist Items -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checklist 1</label>
                    <input type="text" name="technique_check1" value="<?= htmlspecialchars($techData['checklist'][0] ?? 'Dance Practice', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checklist 2</label>
                    <input type="text" name="technique_check2" value="<?= htmlspecialchars($techData['checklist'][1] ?? 'Dance Growth', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checklist 3</label>
                    <input type="text" name="technique_check3" value="<?= htmlspecialchars($techData['checklist'][2] ?? 'Dance Training', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checklist 4</label>
                    <input type="text" name="technique_check4" value="<?= htmlspecialchars($techData['checklist'][3] ?? 'Dance Improvement', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                </div>
            </div>
        </div>

        <!-- CARD 4: Section 2 Part 2 — Structured Pedagogical Framework (Dark Card) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-slate-900 text-emerald-400 flex items-center justify-center font-bold text-sm">⚡</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">4. Section 2 Part 2: Structured Pedagogical Framework (Dark Digital Cards)</h2>
                    <p class="text-[11px] text-slate-400">Controls the 4 workflow process cards: Warm-Up, Breakdown, Choreograph, Perform</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Badge</label>
                    <input type="text" name="framework_badge" value="<?= htmlspecialchars($sections['about_framework']['subheading'] ?? 'Structured Pedagogical Framework', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                    <input type="text" name="framework_heading" value="<?= htmlspecialchars($sections['about_framework']['heading'] ?? 'SIMPLE STEPS FOR TEACHING DANCE', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtitle</label>
                    <input type="text" name="framework_subtitle" value="<?= htmlspecialchars($frameData['subtitle'] ?? 'Our proven 4-stage systematic methodology transforming complete beginners into confident, culturally enriched stage performers.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <!-- Step 1 -->
                <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200/60 space-y-2">
                    <span class="text-xs font-bold text-amber-800 block">STEP 01 (Flexibility)</span>
                    <input type="text" name="framework_s1_title" value="<?= htmlspecialchars($frameData['step1_title'] ?? 'WARM-UP & STRETCH', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold bg-white">
                    <input type="text" name="framework_s1_sub" value="<?= htmlspecialchars($frameData['step1_sub'] ?? '1. Build Flexibility & Prevent Injury', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
                    <textarea name="framework_s1_desc" rows="2" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white"><?= htmlspecialchars($frameData['step1_desc'] ?? 'Dynamic conditioning, safe joint rotations, and posture alignment to prepare young muscles for energetic movement.', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <!-- Step 2 -->
                <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-200/60 space-y-2">
                    <span class="text-xs font-bold text-emerald-800 block">STEP 02 (Technique)</span>
                    <input type="text" name="framework_s2_title" value="<?= htmlspecialchars($frameData['step2_title'] ?? 'BREAKDOWN & DRILL', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold bg-white">
                    <input type="text" name="framework_s2_sub" value="<?= htmlspecialchars($frameData['step2_sub'] ?? '2. Teach Basic Movements & Repetition', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
                    <textarea name="framework_s2_desc" rows="2" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white"><?= htmlspecialchars($frameData['step2_desc'] ?? 'Deconstructing complex footwork, hand mudras, and rhythmic beats into easily mastered drills with guided repetitions.', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <!-- Step 3 -->
                <div class="bg-orange-50/50 p-4 rounded-xl border border-orange-200/60 space-y-2">
                    <span class="text-xs font-bold text-orange-800 block">STEP 03 (Artistry)</span>
                    <input type="text" name="framework_s3_title" value="<?= htmlspecialchars($frameData['step3_title'] ?? 'CHOREOGRAPH & CREATE', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold bg-white">
                    <input type="text" name="framework_s3_sub" value="<?= htmlspecialchars($frameData['step3_sub'] ?? '3. Combine Steps Into Routines', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
                    <textarea name="framework_s3_desc" rows="2" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white"><?= htmlspecialchars($frameData['step3_desc'] ?? 'Seamlessly weaving individual techniques into captivating stage routines, song timing, formations, and musicality.', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <!-- Step 4 -->
                <div class="bg-cyan-50/50 p-4 rounded-xl border border-cyan-200/60 space-y-2">
                    <span class="text-xs font-bold text-cyan-800 block">STEP 04 (Stage Presence)</span>
                    <input type="text" name="framework_s4_title" value="<?= htmlspecialchars($frameData['step4_title'] ?? 'PERFORM & SHARE', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold bg-white">
                    <input type="text" name="framework_s4_sub" value="<?= htmlspecialchars($frameData['step4_sub'] ?? '4. Encourage Confidence & Expression', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white">
                    <textarea name="framework_s4_desc" rows="2" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none bg-white"><?= htmlspecialchars($frameData['step4_desc'] ?? 'Stage rehearsals, authentic facial expressions (Bhava), group coordination, and commanding stage performance.', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 5: Section 3 — Awards & Recognition -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">🏆</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">5. Section 3: Our Awards &amp; Recognition</h2>
                    <p class="text-[11px] text-slate-400">Accreditations, record book citations, and credential pills</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                <input type="text" name="awards_heading" value="<?= htmlspecialchars($sections['about_awards']['heading'] ?? 'Our Awards & Recognition', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
            </div>

            <div class="space-y-3">
                <textarea name="awards_p1" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($awardsData['p1'] ?? "Our journey is defined by a consistent pursuit of excellence, earning us prestigious recognition on both national and international stages. We take immense pride in being featured in the London Book of World Records, a testament to the dedication of our students and the visionary leadership that drives our academy. This global milestone reflects our commitment to setting high standards in artistic training and cultural representation.", ENT_QUOTES, 'UTF-8') ?></textarea>
                <textarea name="awards_p2" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($awardsData['p2'] ?? "As a Government-Registered Institution and a Government-Approved Vocational Training Centre, we operate with the highest levels of credibility and trust. Our academy is also Trademark-Registered under the Government of India, further supported by certifications from IAF and EGAC for maintaining a high-quality management system. These credentials ensure that every student is part of a professionally recognized and secure educational environment.", ENT_QUOTES, 'UTF-8') ?></textarea>
                <textarea name="awards_p3" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($awardsData['p3'] ?? "Beyond institutional excellence, we are proud members of CIOFF and IOV—the premier international organizations for folklore and folk art affiliated with UNESCO. This allows our students to represent India’s rich heritage on global platforms worldwide. Our mission has been celebrated by the press, with features in over 200 print media articles and 60+ news channels highlighting our impact.", ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-2">
                <input type="text" name="awards_b1" value="<?= htmlspecialchars($awardsData['badge1'] ?? '🏆 London Book of World Records', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                <input type="text" name="awards_b2" value="<?= htmlspecialchars($awardsData['badge2'] ?? '🏛️ Govt. Approved Vocational Centre', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                <input type="text" name="awards_b3" value="<?= htmlspecialchars($awardsData['badge3'] ?? '🌐 CIOFF & IOV (UNESCO Partner)', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                <input type="text" name="awards_b4" value="<?= htmlspecialchars($awardsData['badge4'] ?? '📜 IAF & EGAC Quality Certified', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
            </div>
        </div>

        <!-- CARD 6: Section 4 — Our Media Journey -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-sm">📰</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">6. Section 4: Our Media Journey (3 Media Channels)</h2>
                    <p class="text-[11px] text-slate-400">Print Articles, News Channels, and Global Press features</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Badge</label>
                    <input type="text" name="media_badge" value="<?= htmlspecialchars($sections['about_media']['subheading'] ?? 'RECOGNIZED GLOBALLY, CELEBRATED NATIONALLY', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                    <input type="text" name="media_heading" value="<?= htmlspecialchars($sections['about_media']['heading'] ?? 'Our Media Journey', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                <div class="space-y-2">
                    <input type="text" name="media_col1_title" value="<?= htmlspecialchars($mediaData['col1_title'] ?? '200+ Print Articles', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold">
                    <textarea name="media_col1_desc" rows="4" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none"><?= htmlspecialchars($mediaData['col1_desc'] ?? "The media has played a pivotal role in documenting our academy’s growth, sharing our story of cultural preservation with the world. We are profoundly grateful for the recognition received from respected media houses, whose coverage has highlighted our initiatives in over 200 print articles. These features celebrate our dedication to youth development and our contributions to the global artistic community.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="space-y-2">
                    <input type="text" name="media_col2_title" value="<?= htmlspecialchars($mediaData['col2_title'] ?? '60+ News Channels', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold">
                    <textarea name="media_col2_desc" rows="4" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none"><?= htmlspecialchars($mediaData['col2_desc'] ?? "Our mission has been further amplified through more than 60 electronic media and press news channels, bringing our vision into countless homes nationwide. This consistent national presence has been instrumental in establishing our academy as a trusted name for cultural education. By sharing our students' accomplishments, these platforms have helped us inspire a new generation to embrace their heritage with pride.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="space-y-2">
                    <input type="text" name="media_col3_title" value="<?= htmlspecialchars($mediaData['col3_title'] ?? '50+ Global Features', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none font-bold">
                    <textarea name="media_col3_desc" rows="4" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none"><?= htmlspecialchars($mediaData['col3_desc'] ?? "Internationally, our efforts to spread Indian culture have been featured in over 50 articles and interviews across prominent global platforms. This overwhelming support from the international media has not only bolstered our credibility but has also motivated us to advance our mission with even greater passion. We continue to strive for excellence, honored by the global community's embrace of our journey.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 7: Section 5 — Vision, Mission & Values -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm">💡</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">7. Section 5: Vision, Mission &amp; Core Values</h2>
                    <p class="text-[11px] text-slate-400">Guiding institutional pillars and pedagogical principles</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Badge</label>
                    <input type="text" name="vision_badge" value="<?= htmlspecialchars($sections['about_vision']['subheading'] ?? 'Guiding Principles', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Heading</label>
                    <input type="text" name="vision_heading" value="<?= htmlspecialchars($sections['about_vision']['heading'] ?? 'Our Vision, Mission & Core Values', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-pink-600 mb-1">Our Vision</label>
                    <textarea name="vision_desc" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($visionData['vision_desc'] ?? "To be Gujarat's leading children performing arts institution, nurturing culturally rooted, emotionally resilient, and artistically accomplished young citizens through the timeless discipline of Indian dance.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-amber-600 mb-1">Our Mission</label>
                    <textarea name="mission_desc" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($visionData['mission_desc'] ?? "To provide safe, disciplined, and joy-filled dance instruction combining classical techniques with folk vibrancy, preparing students for stage performance, world record achievements, and lifelong wellness.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-purple-600 mb-1">Our Core Values</label>
                    <textarea name="values_desc" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none"><?= htmlspecialchars($visionData['values_desc'] ?? "Discipline, cultural reverence, inclusivity, creative expression, and uncompromising artistic integrity in every step, gesture, and stage performance.", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 8: Section 6 — Call to Action Banner -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-sm">🎯</span>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">8. Section 6: Bottom Call To Action Banner</h2>
                    <p class="text-[11px] text-slate-400">Trial class invite banner at the bottom of the page</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Banner Heading</label>
                    <input type="text" name="cta_heading" value="<?= htmlspecialchars($ctaSec['heading'] ?? 'Experience the Joy of Dance Firsthand', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Banner Subtitle</label>
                    <input type="text" name="cta_subheading" value="<?= htmlspecialchars($ctaSec['subheading'] ?? 'Book a free observation session or trial class at our Nikol or Bapunagar branches to meet Director Tirthraj Trivedi and our certified instructors.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button Text</label>
                    <input type="text" name="cta_button_text" value="<?= htmlspecialchars($ctaSec['button_text'] ?? 'Contact Admissions', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Button Link URL</label>
                    <input type="text" name="cta_button_url" value="<?= htmlspecialchars($ctaSec['button_url'] ?? '/contact', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none">
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Save Bar -->
        <div class="sticky bottom-4 z-30 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200/90 shadow-xl flex items-center justify-between">
            <span class="text-xs text-slate-500 font-medium">Ready to update About Us page and sync live?</span>
            <div class="flex items-center gap-3">
                <a href="/admin/pages" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-50">Back to Pages</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-md transition-colors cursor-pointer">
                    Save All Changes
                </button>
            </div>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
