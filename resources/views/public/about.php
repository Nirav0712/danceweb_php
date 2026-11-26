<?php
ob_start();

$foundingYear = $settings['founding_year'] ?? '2002';
$directorName = $settings['director_name'] ?? 'Tirthraj Trivedi';

// 1. Founded in 2002 Section Data
$foundedData = !empty($sections['about_founded']['content']) ? json_decode($sections['about_founded']['content'], true) : [];
$foundedHeading = $sections['about_founded']['heading'] ?? 'Founded in 2002';
$foundedBadge = $sections['about_founded']['subheading'] ?? 'ABOUT US';
$foundedImage = $sections['about_founded']['image_url'] ?? '/assets/about/founded-2002-stage.jpg';
$estYear = $foundedData['est_year'] ?? $foundingYear;
$studentsTrained = $foundedData['students_trained'] ?? '6,000+ Students Trained';
$foundedP1 = $foundedData['p1'] ?? "Founded in {$foundingYear} by Director {$directorName} with just 14 students, our academy has grown into a prestigious institution that has proudly trained more than 6,000 young learners. Guided by a strong vision to nurture India’s culture, traditions, and values in the next generation, we have become a trusted platform for children aged 4 to 14 years to learn, express, and shine.";
$foundedP2 = $foundedData['p2'] ?? "We are a Government-Registered Institution, a Government-Approved Vocational Training Centre, and a Trademark-Registered Academy under the Government of India. Our commitment to excellence is further strengthened by certifications from IAF and EGAC for maintaining a high-quality management system.";
$foundedP3 = $foundedData['p3'] ?? "Our academy has earned international recognition, marking its name in the London Book of World Records and becoming an esteemed member of CIOFF (International Council of Organizations of Folklore Festivals and Folk Arts) and IOV (International Organization of Folk Art). These affiliations allow our students to proudly represent India on global platforms.";
$foundedP4 = $foundedData['p4'] ?? "With a mission to instill cultural values, discipline, and artistic excellence, we provide world-class training and international-stage opportunities. We strive to shape ambitious, confident, and culturally enriched young minds who carry the pride and authenticity of India across the world.";

// 2. Dance Technique Section Data
$techData = !empty($sections['about_technique']['content']) ? json_decode($sections['about_technique']['content'], true) : [];
$techHeading = $sections['about_technique']['heading'] ?? "We're some simple steps for teaching dance";
$techBadge = $sections['about_technique']['subheading'] ?? 'OUR DANCE TECHNIQUE';
$step1Desc = $techData['step1'] ?? "Dramatically initiate our mission in {$foundingYear} with minimal initial investment, rapidly expanding operational capacity to over 6,000 students trained. Systematically scale our educational footprint over 23 years of sustained deployment, ensuring continuous market leadership in artistic and cultural development. Compellingly leverage the visionary expertise of Founder {$directorName} to anchor value-driven educational portals.";
$step2Desc = $techData['step2'] ?? "We launched our mission in {$foundingYear} with minimal initial investment, swiftly expanding our operational capacity to exceed 6,000 trained students. We have systematically enlarged our educational footprint over 23 years of continuous deployment, guaranteeing sustained market dominance in artistic and cultural development. We compellingly harness the visionary acumen of Founder {$directorName} to secure value-driven educational gateways.";
$step3Desc = $techData['step3'] ?? "Our endeavor began dramatically in {$foundingYear} with a paltry initial investment, rapidly increasing our operational capacity to over 6,000 students educated. We have methodically expanded our educational presence across 23 years of uninterrupted deployment, maintaining perpetual market preeminence in artistic and cultural development. We powerfully utilize the visionary expertise of Founder {$directorName} to anchor value-driven educational platforms.";
$checklist = $techData['checklist'] ?? ['Dance Practice', 'Dance Growth', 'Dance Training', 'Dance Improvement'];

// 3. Structured Pedagogical Framework Data
$frameData = !empty($sections['about_framework']['content']) ? json_decode($sections['about_framework']['content'], true) : [];
$frameHeading = $sections['about_framework']['heading'] ?? 'SIMPLE STEPS FOR TEACHING DANCE';
$frameBadge = $sections['about_framework']['subheading'] ?? 'Structured Pedagogical Framework';
$frameSubtitle = $frameData['subtitle'] ?? 'Our proven 4-stage systematic methodology transforming complete beginners into confident, culturally enriched stage performers.';
$f1Title = $frameData['step1_title'] ?? 'WARM-UP & STRETCH';
$f1Sub = $frameData['step1_sub'] ?? '1. Build Flexibility & Prevent Injury';
$f1Desc = $frameData['step1_desc'] ?? 'Dynamic conditioning, safe joint rotations, and posture alignment to prepare young muscles for energetic movement.';
$f2Title = $frameData['step2_title'] ?? 'BREAKDOWN & DRILL';
$f2Sub = $frameData['step2_sub'] ?? '2. Teach Basic Movements & Repetition';
$f2Desc = $frameData['step2_desc'] ?? 'Deconstructing complex footwork, hand mudras, and rhythmic beats into easily mastered drills with guided repetitions.';
$f3Title = $frameData['step3_title'] ?? 'CHOREOGRAPH & CREATE';
$f3Sub = $frameData['step3_sub'] ?? '3. Combine Steps Into Routines';
$f3Desc = $frameData['step3_desc'] ?? 'Seamlessly weaving individual techniques into captivating stage routines, song timing, formations, and musicality.';
$f4Title = $frameData['step4_title'] ?? 'PERFORM & SHARE';
$f4Sub = $frameData['step4_sub'] ?? '4. Encourage Confidence & Expression';
$f4Desc = $frameData['step4_desc'] ?? 'Stage rehearsals, authentic facial expressions (Bhava), group coordination, and commanding stage performance.';

// 4. Awards & Recognition Section Data
$awardsData = !empty($sections['about_awards']['content']) ? json_decode($sections['about_awards']['content'], true) : [];
$awardsHeading = $sections['about_awards']['heading'] ?? 'Our Awards & Recognition';
$awardsP1 = $awardsData['p1'] ?? "Our journey is defined by a consistent pursuit of excellence, earning us prestigious recognition on both national and international stages. We take immense pride in being featured in the London Book of World Records, a testament to the dedication of our students and the visionary leadership that drives our academy. This global milestone reflects our commitment to setting high standards in artistic training and cultural representation.";
$awardsP2 = $awardsData['p2'] ?? "As a Government-Registered Institution and a Government-Approved Vocational Training Centre, we operate with the highest levels of credibility and trust. Our academy is also Trademark-Registered under the Government of India, further supported by certifications from IAF and EGAC for maintaining a high-quality management system. These credentials ensure that every student is part of a professionally recognized and secure educational environment.";
$awardsP3 = $awardsData['p3'] ?? "Beyond institutional excellence, we are proud members of CIOFF and IOV—the premier international organizations for folklore and folk art affiliated with UNESCO. This allows our students to represent India’s rich heritage on global platforms worldwide. Our mission has been celebrated by the press, with features in over 200 print media articles and 60+ news channels highlighting our impact.";
$awardsB1 = $awardsData['badge1'] ?? '🏆 London Book of World Records';
$awardsB2 = $awardsData['badge2'] ?? '🏛️ Govt. Approved Vocational Centre';
$awardsB3 = $awardsData['badge3'] ?? '🌐 CIOFF & IOV (UNESCO Partner)';
$awardsB4 = $awardsData['badge4'] ?? '📜 IAF & EGAC Quality Certified';

// 5. Media Journey Section Data
$mediaData = !empty($sections['about_media']['content']) ? json_decode($sections['about_media']['content'], true) : [];
$mediaHeading = $sections['about_media']['heading'] ?? 'Our Media Journey';
$mediaBadge = $sections['about_media']['subheading'] ?? 'RECOGNIZED GLOBALLY, CELEBRATED NATIONALLY';
$col1Title = $mediaData['col1_title'] ?? '200+ Print Articles';
$col1Desc = $mediaData['col1_desc'] ?? "The media has played a pivotal role in documenting our academy’s growth, sharing our story of cultural preservation with the world. We are profoundly grateful for the recognition received from respected media houses, whose coverage has highlighted our initiatives in over 200 print articles. These features celebrate our dedication to youth development and our contributions to the global artistic community.";
$col2Title = $mediaData['col2_title'] ?? '60+ News Channels';
$col2Desc = $mediaData['col2_desc'] ?? "Our mission has been further amplified through more than 60 electronic media and press news channels, bringing our vision into countless homes nationwide. This consistent national presence has been instrumental in establishing our academy as a trusted name for cultural education. By sharing our students' accomplishments, these platforms have helped us inspire a new generation to embrace their heritage with pride.";
$col3Title = $mediaData['col3_title'] ?? '50+ Global Features';
$col3Desc = $mediaData['col3_desc'] ?? "Internationally, our efforts to spread Indian culture have been featured in over 50 articles and interviews across prominent global platforms. This overwhelming support from the international media has not only bolstered our credibility but has also motivated us to advance our mission with even greater passion. We continue to strive for excellence, honored by the global community's embrace of our journey.";

// 6. Vision, Mission & Values Data
$visionData = !empty($sections['about_vision']['content']) ? json_decode($sections['about_vision']['content'], true) : [];
$visionHeading = $sections['about_vision']['heading'] ?? 'Our Vision, Mission & Core Values';
$visionBadge = $sections['about_vision']['subheading'] ?? 'Guiding Principles';
$visionDesc = $visionData['vision_desc'] ?? "To be Gujarat's leading children performing arts institution, nurturing culturally rooted, emotionally resilient, and artistically accomplished young citizens through the timeless discipline of Indian dance.";
$missionDesc = $visionData['mission_desc'] ?? "To provide safe, disciplined, and joy-filled dance instruction combining classical techniques with folk vibrancy, preparing students for stage performance, world record achievements, and lifelong wellness.";
$valuesDesc = $visionData['values_desc'] ?? "Discipline, cultural reverence, inclusivity, creative expression, and uncompromising artistic integrity in every step, gesture, and stage performance.";

// 7. CTA Banner Data
$ctaHeading = $sections['about_cta']['heading'] ?? 'Experience the Joy of Dance Firsthand';
$ctaSubheading = $sections['about_cta']['subheading'] ?? "Book a free observation session or trial class at our Nikol or Bapunagar branches to meet Director {$directorName} and our certified instructors.";
$ctaBtnText = $sections['about_cta']['button_text'] ?? 'Contact Admissions';
$ctaBtnUrl = $sections['about_cta']['button_url'] ?? '/contact';
?>

<div class="min-h-screen text-slate-900 bg-slate-50 relative overflow-hidden">
    <!-- =========================================================================
        PAGE HEADER BANNER (SS 1 Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-16 sm:py-20 lg:py-24 bg-cover bg-center overflow-hidden w-full">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <!-- Ambient Glows -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-rose-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest bg-white/10 text-rose-300 border border-white/15 backdrop-blur-md shadow-sm mb-4">
                <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                Our Journey &amp; Heritage
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">
                <?= htmlspecialchars($page['title'] ?? 'About Us', ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mt-4 text-sm sm:text-base lg:text-lg text-gray-300 max-w-2xl mx-auto font-normal">
                <?= htmlspecialchars($page['subtitle'] ?? "Founded in {$foundingYear} by Director {$directorName}", ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 1: FOUNDED IN 2002 (SS 1 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 lg:py-24 relative overflow-hidden w-full">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Left: Academy Stage Photo -->
                <div class="lg:col-span-5">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 bg-slate-900 group aspect-[4/3] sm:aspect-[16/11]">
                        <img
                            src="<?= htmlspecialchars($foundedImage, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Dynamice Children Academy Stage Recital"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.src='/assets/about/aboutimg2.png';"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/60 via-transparent to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white text-xs font-semibold flex items-center justify-between">
                            <span class="bg-black/60 backdrop-blur-md px-3 py-1 rounded-full border border-white/20">
                                Est. <?= htmlspecialchars($estYear, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="bg-rose-500/80 backdrop-blur-md px-3 py-1 rounded-full text-white font-bold">
                                <?= htmlspecialchars($studentsTrained, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Content & Narrative -->
                <div class="lg:col-span-7 space-y-4">
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full bg-rose-100/70 text-rose-600 font-extrabold text-xs uppercase tracking-wider">
                        <?= htmlspecialchars($foundedBadge, ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        <?= htmlspecialchars($foundedHeading, ENT_QUOTES, 'UTF-8') ?>
                    </h2>

                    <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-4 font-normal pt-1">
                        <p><?= htmlspecialchars($foundedP1, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($foundedP2, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($foundedP3, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($foundedP4, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 2: OUR DANCE TECHNIQUE (SS 2 & SS 3 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-white via-slate-50 to-white relative overflow-hidden border-y border-slate-200/60 w-full">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10 space-y-12 sm:space-y-16">
            <!-- Section Header -->
            <div>
                <span class="inline-flex items-center px-3.5 py-1 rounded-full bg-rose-100/70 text-rose-600 font-extrabold text-xs uppercase tracking-wider mb-3">
                    <?= htmlspecialchars($techBadge, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    <?= htmlspecialchars($techHeading, ENT_QUOTES, 'UTF-8') ?>
                </h2>
            </div>

            <!-- Part 1: Interactive Technique Tabs & Narrative Card -->
            <div class="w-full space-y-6">
                <!-- Step Navigation Tabs -->
                <div class="flex items-center gap-3 flex-wrap">
                    <button
                        type="button"
                        id="dance-tab-1"
                        onclick="switchDanceStep(1)"
                        class="dance-step-btn px-6 py-3 rounded-2xl text-xs sm:text-sm font-extrabold transition-all duration-200 cursor-pointer bg-rose-600 text-white shadow-lg shadow-rose-600/30 scale-102 ring-2 ring-rose-400/40"
                    >
                        Dance Step 01
                    </button>
                    <button
                        type="button"
                        id="dance-tab-2"
                        onclick="switchDanceStep(2)"
                        class="dance-step-btn px-6 py-3 rounded-2xl text-xs sm:text-sm font-extrabold transition-all duration-200 cursor-pointer bg-white hover:bg-slate-100 text-slate-700 border border-slate-300/80 shadow-xs"
                    >
                        Dance Step 02
                    </button>
                    <button
                        type="button"
                        id="dance-tab-3"
                        onclick="switchDanceStep(3)"
                        class="dance-step-btn px-6 py-3 rounded-2xl text-xs sm:text-sm font-extrabold transition-all duration-200 cursor-pointer bg-white hover:bg-slate-100 text-slate-700 border border-slate-300/80 shadow-xs"
                    >
                        Dance Step 03
                    </button>
                </div>

                <!-- Step Description Card -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 lg:p-12 border border-slate-200/80 shadow-xl shadow-slate-900/5 space-y-8 w-full">
                    <p id="dance-step-text" class="text-slate-700 text-base sm:text-lg lg:text-xl leading-relaxed font-normal">
                        <?= htmlspecialchars($step1Desc, ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <!-- 4 Checklist Points -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 pt-6 border-t border-slate-100">
                        <?php foreach ($checklist as $item): ?>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/60">
                            <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs sm:text-sm font-extrabold text-slate-800"><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Part 2: Full-Width Digital UI for "SIMPLE STEPS FOR TEACHING DANCE" (SS 3 Matching) -->
            <div class="w-full bg-gray-950 text-white rounded-3xl p-8 sm:p-12 lg:p-14 shadow-2xl border border-gray-800 relative overflow-hidden">
                <!-- Ambient Lighting Gradients -->
                <div class="absolute -top-24 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>
                <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-[100px] pointer-events-none"></div>

                <!-- Digital UI Header -->
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14 relative z-10">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-500/15 text-[#bbf7d0] border border-emerald-500/30 text-[11px] font-black uppercase tracking-widest mb-3">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <?= htmlspecialchars($frameBadge, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-wider text-[#bbf7d0] uppercase">
                        <?= htmlspecialchars($frameHeading, ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-400 mt-2 max-w-xl mx-auto font-normal">
                        <?= htmlspecialchars($frameSubtitle, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <!-- 4 Process Workflow Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10">
                    <!-- Step 1 -->
                    <div class="bg-gray-900/90 rounded-2xl p-6 border border-amber-500/30 hover:border-amber-400 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-amber-500/10 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-xs font-black">STEP 01</span>
                                <div class="w-11 h-11 rounded-2xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                                </div>
                            </div>
                            <h4 class="text-base sm:text-lg font-black text-white uppercase tracking-tight group-hover:text-amber-300 transition-colors">
                                <?= htmlspecialchars($f1Title, ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                            <p class="text-xs font-bold text-amber-400 mt-1 mb-3">
                                <?= htmlspecialchars($f1Sub, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-xs text-gray-300 leading-relaxed font-normal">
                                <?= htmlspecialchars($f1Desc, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-800 text-[11px] font-semibold text-gray-400 flex items-center justify-between">
                            <span>Phase: Readiness</span>
                            <span class="text-amber-400 font-bold">Flexibility</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gray-900/90 rounded-2xl p-6 border border-emerald-500/30 hover:border-emerald-400 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs font-black">STEP 02</span>
                                <div class="w-11 h-11 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                            </div>
                            <h4 class="text-base sm:text-lg font-black text-white uppercase tracking-tight group-hover:text-emerald-300 transition-colors">
                                <?= htmlspecialchars($f2Title, ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                            <p class="text-xs font-bold text-emerald-400 mt-1 mb-3">
                                <?= htmlspecialchars($f2Sub, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-xs text-gray-300 leading-relaxed font-normal">
                                <?= htmlspecialchars($f2Desc, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-800 text-[11px] font-semibold text-gray-400 flex items-center justify-between">
                            <span>Phase: Technique</span>
                            <span class="text-emerald-400 font-bold">Repetition</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gray-900/90 rounded-2xl p-6 border border-orange-500/30 hover:border-orange-400 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-orange-500/10 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 border border-orange-500/40 text-xs font-black">STEP 03</span>
                                <div class="w-11 h-11 rounded-2xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center text-orange-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                </div>
                            </div>
                            <h4 class="text-base sm:text-lg font-black text-white uppercase tracking-tight group-hover:text-orange-300 transition-colors">
                                <?= htmlspecialchars($f3Title, ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                            <p class="text-xs font-bold text-orange-400 mt-1 mb-3">
                                <?= htmlspecialchars($f3Sub, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-xs text-gray-300 leading-relaxed font-normal">
                                <?= htmlspecialchars($f3Desc, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-800 text-[11px] font-semibold text-gray-400 flex items-center justify-between">
                            <span>Phase: Artistry</span>
                            <span class="text-orange-400 font-bold">Routine</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-gray-900/90 rounded-2xl p-6 border border-cyan-500/30 hover:border-cyan-400 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-cyan-500/10 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 text-xs font-black">STEP 04</span>
                                <div class="w-11 h-11 rounded-2xl bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V4a2 2 0 114 0v4h1a3 3 0 013 3v1a3 3 0 01-3 3H7a3 3 0 01-3-3v-1a3 3 0 013-3h1z"/></svg>
                                </div>
                            </div>
                            <h4 class="text-base sm:text-lg font-black text-white uppercase tracking-tight group-hover:text-cyan-300 transition-colors">
                                <?= htmlspecialchars($f4Title, ENT_QUOTES, 'UTF-8') ?>
                            </h4>
                            <p class="text-xs font-bold text-cyan-400 mt-1 mb-3">
                                <?= htmlspecialchars($f4Sub, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-xs text-gray-300 leading-relaxed font-normal">
                                <?= htmlspecialchars($f4Desc, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-800 text-[11px] font-semibold text-gray-400 flex items-center justify-between">
                            <span>Phase: Stage</span>
                            <span class="text-cyan-400 font-bold">Expression</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 3: OUR AWARDS & RECOGNITION (SS 4 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 lg:py-24 relative overflow-hidden w-full">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="bg-white rounded-3xl p-8 sm:p-12 lg:p-14 border border-slate-200/80 shadow-xl shadow-slate-900/5 relative overflow-hidden">
                <!-- Top Accent Rainbow Line -->
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-400 via-rose-500 to-purple-600 opacity-90"></div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-2xl bg-amber-500/10 text-amber-600 border border-amber-500/20">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                        </div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                            <?= htmlspecialchars($awardsHeading, ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                    </div>

                    <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-4 font-normal">
                        <p><?= htmlspecialchars($awardsP1, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($awardsP2, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($awardsP3, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <!-- Badges Bar -->
                    <div class="pt-4 flex flex-wrap items-center gap-3 sm:gap-4 border-t border-slate-100 text-xs font-bold">
                        <span class="px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                            <?= htmlspecialchars($awardsB1, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <span class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <?= htmlspecialchars($awardsB2, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <span class="px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                            <?= htmlspecialchars($awardsB3, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <span class="px-3 py-1.5 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                            <?= htmlspecialchars($awardsB4, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 4: OUR MEDIA JOURNEY (SS 5 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-slate-50 via-white to-slate-50 relative overflow-hidden w-full">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="bg-white rounded-3xl p-8 sm:p-12 lg:p-16 border border-slate-200/80 shadow-xl shadow-slate-900/5 relative overflow-hidden">
                <!-- Header Content -->
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
                    <p class="text-xs sm:text-sm font-extrabold uppercase tracking-widest text-rose-600 mb-2">
                        <?= htmlspecialchars($mediaBadge, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                        <?= htmlspecialchars($mediaHeading, ENT_QUOTES, 'UTF-8') ?>
                    </h2>
                    <!-- Red/Crimson Underline Accent -->
                    <div class="w-16 h-1 bg-rose-500 rounded-full mx-auto mt-4"></div>
                </div>

                <!-- 3-Column Narrative Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 text-slate-600 text-sm sm:text-base leading-relaxed">
                    <!-- Column 1: Print Media -->
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-rose-600 font-bold text-xs uppercase tracking-wider mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span><?= htmlspecialchars($col1Title, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <p class="font-normal text-justify sm:text-left">
                            <?= htmlspecialchars($col1Desc, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>

                    <!-- Column 2: Electronic & Television Press -->
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-amber-600 font-bold text-xs uppercase tracking-wider mb-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span><?= htmlspecialchars($col2Title, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <p class="font-normal text-justify sm:text-left">
                            <?= htmlspecialchars($col2Desc, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>

                    <!-- Column 3: Global Media & International Outreach -->
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-purple-600 font-bold text-xs uppercase tracking-wider mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span><?= htmlspecialchars($col3Title, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <p class="font-normal text-justify sm:text-left">
                            <?= htmlspecialchars($col3Desc, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 5: OUR VISION, MISSION & CORE VALUES (SS 6 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 lg:py-24 relative overflow-hidden w-full">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold uppercase tracking-wider">
                    <?= htmlspecialchars($visionBadge, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    <?= htmlspecialchars($visionHeading, ENT_QUOTES, 'UTF-8') ?>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Vision -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden space-y-4">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 to-rose-600"></div>
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center border border-pink-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Our Vision</h3>
                    <p class="text-sm text-slate-600 leading-relaxed font-normal">
                        <?= htmlspecialchars($visionDesc, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <!-- Mission -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden space-y-4">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-500 to-orange-600"></div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Our Mission</h3>
                    <p class="text-sm text-slate-600 leading-relaxed font-normal">
                        <?= htmlspecialchars($missionDesc, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <!-- Values -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden space-y-4">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-purple-500 to-indigo-600"></div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Our Core Values</h3>
                    <p class="text-sm text-slate-600 leading-relaxed font-normal">
                        <?= htmlspecialchars($valuesDesc, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        SECTION 6: CALL TO ACTION BANNER (SS 6 Matching)
        ========================================================================= -->
    <section class="py-16 sm:py-20 text-center relative overflow-hidden w-full">
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="bg-gradient-to-r from-rose-500 via-pink-600 to-amber-500 text-white rounded-3xl p-10 sm:p-14 shadow-2xl relative overflow-hidden space-y-6">
                <h2 class="text-3xl sm:text-4xl font-black">
                    <?= htmlspecialchars($ctaHeading, ENT_QUOTES, 'UTF-8') ?>
                </h2>
                <p class="text-rose-100 text-sm sm:text-base max-w-xl mx-auto font-normal">
                    <?= htmlspecialchars($ctaSubheading, ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="flex justify-center gap-4 pt-2">
                    <a
                        href="<?= htmlspecialchars($ctaBtnUrl, ENT_QUOTES, 'UTF-8') ?>"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full font-bold text-sm bg-white text-rose-600 shadow-xl hover:bg-rose-50 hover:scale-105 transition-all duration-300 cursor-pointer"
                    >
                        <span><?= htmlspecialchars($ctaBtnText, ENT_QUOTES, 'UTF-8') ?></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Vanilla JS for Dance Steps Tabs Switcher -->
<script>
const danceStepDescriptions = {
    1: <?= json_encode($step1Desc, JSON_UNESCAPED_UNICODE) ?>,
    2: <?= json_encode($step2Desc, JSON_UNESCAPED_UNICODE) ?>,
    3: <?= json_encode($step3Desc, JSON_UNESCAPED_UNICODE) ?>
};

function switchDanceStep(stepNum) {
    const textElem = document.getElementById('dance-step-text');
    if (textElem && danceStepDescriptions[stepNum]) {
        textElem.textContent = danceStepDescriptions[stepNum];
    }

    for (let i = 1; i <= 3; i++) {
        const btn = document.getElementById('dance-tab-' + i);
        if (!btn) continue;
        if (i === stepNum) {
            btn.className = 'dance-step-btn px-6 py-3 rounded-2xl text-xs sm:text-sm font-extrabold transition-all duration-200 cursor-pointer bg-rose-600 text-white shadow-lg shadow-rose-600/30 scale-102 ring-2 ring-rose-400/40';
        } else {
            btn.className = 'dance-step-btn px-6 py-3 rounded-2xl text-xs sm:text-sm font-extrabold transition-all duration-200 cursor-pointer bg-white hover:bg-slate-100 text-slate-700 border border-slate-300/80 shadow-xs';
        }
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
