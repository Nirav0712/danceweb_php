<?php
ob_start();
$settings = \App\Services\ContentService::getSettings();
$primaryPhone = $settings['phone_primary'] ?? '+91 91738 78750';
$primaryEmail = $settings['email'] ?? 'info@dynamicechildrenacademy.com';
?>
<div class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/40 to-[#fffbeb]/30">
    <!-- Ambient glowing backgrounds matching other pages -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-cyan-400/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        HERO BANNER: Terms of Service & Studio Code (Theme-Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-16 sm:py-20 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                ACADEMY POLICIES &amp; ENROLMENT GUIDELINES
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-4">
                Terms of Service &amp; Studio Guidelines
            </h1>
            <p class="max-w-2xl mx-auto text-slate-300 text-base sm:text-lg font-normal leading-relaxed">
                General rules, admission terms, studio codes of conduct, attendance standards, and fee policies governing student training at Dynamice Children Academy.
            </p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Academic Session: 2026-27</span>
                </span>
                <span>•</span>
                <span>Govt. Reg. Cultural Trust</span>
                <span>•</span>
                <span>Nikol &amp; Bapunagar Studios</span>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        MAIN CONTENT: Table of Contents & Terms Sections
        ========================================================================= -->
    <section class="py-14 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Quick Navigation & Heritage Info (4 cols) -->
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                    <!-- Quick Jump Links Box -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 border border-white/90 shadow-xl space-y-4">
                        <h2 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Terms Navigation</span>
                        </h2>
                        <nav class="space-y-1 text-xs">
                            <a href="#admission-terms" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">1. Admission &amp; Enrolment</a>
                            <a href="#code-of-conduct" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">2. Studio Discipline &amp; Uniform</a>
                            <a href="#attendance-exams" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">3. Attendance &amp; Certifications</a>
                            <a href="#fees-refunds" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">4. Fees, Schedules &amp; Refunds</a>
                            <a href="#tours-selection" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">5. Tours &amp; Stage Performances</a>
                            <a href="#health-safety" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">6. Health, Fitness &amp; First Aid</a>
                            <a href="#intellectual-property" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">7. Choreography &amp; Media Rights</a>
                            <a href="#jurisdiction" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">8. Governing Law &amp; Jurisdiction</a>
                        </nav>
                    </div>

                    <!-- Academy Core Ethos Card -->
                    <div class="bg-gradient-to-br from-slate-900 to-gray-900 text-white rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center font-bold text-base shadow-md shadow-pink-500/20">
                                🌟
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-white">Guru-Shishya Tradition</h3>
                                <p class="text-[11px] text-slate-400">Founded in 2002</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Under the leadership of Founder Director Shri Tirthraj Trivedi, our academy blends authentic Indian cultural discipline with nurturing, family-centered encouragement for every child artist.
                        </p>
                        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                            <span>6,000+ Students Trained</span>
                            <span class="text-amber-400 font-bold">World Record Holder</span>
                        </div>
                    </div>

                    <!-- Direct Helpline Card -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 border border-white/90 shadow-xl space-y-3 text-xs text-slate-600">
                        <h3 class="font-extrabold text-slate-900 uppercase tracking-wider text-[11px]">Enrolment Assistance</h3>
                        <p class="text-slate-500 leading-relaxed">Need help with batch timings or course curriculum? Reach our admissions desk:</p>
                        <div class="space-y-1.5 pt-1">
                            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $primaryPhone) ?>" class="flex items-center gap-2 text-slate-700 hover:text-pink-600 font-bold">
                                <span>📞</span>
                                <span><?= htmlspecialchars($primaryPhone, ENT_QUOTES, 'UTF-8') ?></span>
                            </a>
                            <a href="mailto:<?= htmlspecialchars($primaryEmail, ENT_QUOTES, 'UTF-8') ?>" class="flex items-center gap-2 text-slate-700 hover:text-pink-600 font-bold truncate">
                                <span>✉</span>
                                <span class="truncate"><?= htmlspecialchars($primaryEmail, ENT_QUOTES, 'UTF-8') ?></span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Terms Section Cards (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Section 1: Admission & Enrolment -->
                    <div id="admission-terms" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 01</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Admission, Age Criteria &amp; Enrolment</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Admission to Dynamice Children Academy is open to children starting from age 4 upwards through senior youth levels:
                        </p>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Age Categories:</strong> Beginners (Age 4-7), Intermediate (Age 8-11), Advanced &amp; Senior Performers (Age 12+). Batch placement is decided after preliminary instructor assessment.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Registration Completion:</strong> Enrolment is finalized only upon submission of the official admission form with parent signature, passport photograph, and registration fee clearance.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Campus Allotment:</strong> Students may enroll at Nikol Branch (Earth Complex) or Bapunagar Branch (Centre Point). Campus transfers can be requested in writing subject to batch capacity.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Section 2: Code of Conduct & Studio Discipline -->
                    <div id="code-of-conduct" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 02</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Studio Discipline, Uniform &amp; Conduct</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            To preserve the sanctity and focus of dance training, all students and visiting parents must observe studio etiquette:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-600">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">⏱ Punctuality</h4>
                                <p class="text-slate-500">Students must report 10 minutes before class commences. Warm-up exercises are mandatory to prevent injury and late arrivals disrupt ongoing group drills.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">👘 Dance Attire &amp; Ghungroos</h4>
                                <p class="text-slate-500">Clean Indian dance uniform (Kurta/Salwar or academy rehearsal wear). Kathak students must maintain dedicated, clean brass bells (Ghungroos) as instructed by Gurus.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">📵 Mobile Devices</h4>
                                <p class="text-slate-500">Mobile phones must be switched off or silenced during studio training hours. Filming inside classrooms without faculty consent is strictly prohibited.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">🤝 Respect &amp; Zero Bullying</h4>
                                <p class="text-slate-500">Absolute respect towards teachers, accompanists, and peers. Any disrespectful conduct, harassment, or verbal abuse results in immediate suspension.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Attendance & Certifications -->
                    <div id="attendance-exams" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 03</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Attendance, Examinations &amp; Vocational Certifications</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            As a <strong>Government-Approved Vocational Training Centre</strong> accredited with IAF and EGAC international standards, evaluation and certification follow rigorous criteria:
                        </p>
                        <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/60 text-xs text-amber-950 space-y-2">
                            <strong class="font-bold text-sm text-amber-900">Mandatory 75% Attendance Requirement:</strong>
                            <p class="leading-relaxed">
                                Students must maintain at least 75% recorded attendance in their batch cycle to qualify for stage recitals, annual examinations, and official level-completion certificates.
                            </p>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Official certificates bear registration seal, recognized grade marks, and Director endorsement. Duplicate certificates may be issued upon formal request subject to verification.
                        </p>
                    </div>

                    <!-- Section 4: Fees, Schedule & Refund Policy -->
                    <div id="fees-refunds" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 04</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Fees, Billing &amp; Cancellation Terms</h2>
                        </div>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Fee Schedule:</strong> Course tuition fees are payable monthly, quarterly, or annually as per chosen plan on or before the 10th day of each billing month.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Non-Refundable Enrolment Fee:</strong> One-time admission registration charges and costume deposits are strictly non-refundable once batch slots are reserved.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Absences &amp; Missed Classes:</strong> Missed classes due to personal family travels or exams are not eligible for cash refunds. Reasonable compensatory practice sessions may be arranged at the instructor's discretion.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Course Withdrawal:</strong> Written notice 15 days in advance is required prior to withdrawal from the academy to discontinue billing cycles.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Section 5: Stage Performances & Tour Selection -->
                    <div id="tours-selection" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 05</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Stage Performances &amp; National/International Tours</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Dynamice Children Academy regularly represents Gujarat and India at Rashtriya Lok Utsavs and international CIOFF / IOV cultural delegations (across Turkey, Poland, France, Germany, Czech Republic, and 15+ nations):
                        </p>
                        <div class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">🎭 Merit-Based Selection</h4>
                                <p class="text-slate-500">Tour delegation selection is made by Founder Director Tirthraj Trivedi and faculty based entirely on student discipline, technique mastery, stage confidence, and attendance consistency.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <h4 class="font-bold text-slate-900 mb-1">✈ Travel Logistics &amp; Parental Authorizations</h4>
                                <p class="text-slate-500">For outstation and overseas travel, detailed itineraries, safety guidelines, and consent forms are submitted to parents with complete transparency regarding lodging, travel, and supervision.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 6: Health & Safety -->
                    <div id="health-safety" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 06</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Health, Physical Safety &amp; First Aid</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Dance training involves rigorous physical movement, jumps, pirouettes (Chakkars), and rhythm footwork (Tatkar):
                        </p>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Medical Disclosures:</strong> Parents are required to inform instructors in writing if a student has any cardiac, orthopaedic, or respiratory limitations.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Studio First Aid:</strong> Both Nikol and Bapunagar campuses maintain certified first-aid equipment, antiseptic supplies, and ice packs for emergency attention.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Emergency Care:</strong> In the rare event of a medical emergency during training or rehearsals, academy faculty will immediately administer basic aid and contact the parent/emergency hospital promptly.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Section 7: Intellectual Property -->
                    <div id="intellectual-property" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 07</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Choreography &amp; Intellectual Property</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            All dance compositions, choreography steps, musical arrangements, stage costumes, and pedagogical curriculum created by <strong>Director Tirthraj Trivedi</strong> and academy choreographers remain the exclusive intellectual property of Dynamice Children Academy.
                        </p>
                        <div class="bg-pink-50/70 border border-pink-200/60 rounded-2xl p-4 text-xs text-pink-950 flex items-start gap-3">
                            <span class="text-lg">⚖️</span>
                            <div>
                                Students and third parties are strictly prohibited from commercially monetizing, teaching externally, or publishing full academy dance compositions without formal prior written authorization from the academy management.
                            </div>
                        </div>
                    </div>

                    <!-- Section 8: Jurisdiction & Governing Law -->
                    <div id="jurisdiction" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 08</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Governing Law &amp; Jurisdiction</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            These Terms of Service, studio agreements, and admission contracts shall be governed by, construed, and enforced in accordance with the laws of the State of Gujarat and the Republic of India.
                        </p>
                        <div class="p-5 rounded-2xl bg-gradient-to-r from-slate-900 to-gray-900 text-white space-y-2 text-xs">
                            <div class="font-bold text-sm text-pink-400">Jurisdiction Clause</div>
                            <p class="text-slate-300 leading-relaxed">
                                Any dispute, claim, or difference arising out of or in connection with academy services, admissions, or certifications shall be subject exclusively to the competent courts located in <strong>Ahmedabad, Gujarat, India</strong>.
                            </p>
                            <div class="pt-2 text-slate-400 text-[11px]">
                                Registered Cultural Trust • Govt. Reg. Children Dance Academy • Established 2002
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
