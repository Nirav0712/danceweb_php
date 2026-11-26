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
        HERO BANNER: Legal & Privacy (Theme-Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-16 sm:py-20 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                LEGAL COMPLIANCE &amp; STUDENT SAFETY
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-4">
                Privacy Policy
            </h1>
            <p class="max-w-2xl mx-auto text-slate-300 text-base sm:text-lg font-normal leading-relaxed">
                How Dynamice Children Academy collects, protects, and respects the personal information and media consent of our young students, parents, and community.
            </p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Effective: Academic Year 2026-27</span>
                </span>
                <span>•</span>
                <span>Version 2.4</span>
                <span>•</span>
                <span>DPDP Act &amp; POCSO Safeguard Aligned</span>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        MAIN CONTENT: Table of Contents & Policy Sections
        ========================================================================= -->
    <section class="py-14 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Quick Navigation & Support (4 cols) -->
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
                    <!-- Quick Jump Links Box -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 border border-white/90 shadow-xl space-y-4">
                        <h2 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            <span>Table of Contents</span>
                        </h2>
                        <nav class="space-y-1 text-xs">
                            <a href="#commitment" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">1. Commitment to Child Safety</a>
                            <a href="#info-collected" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">2. Information We Collect</a>
                            <a href="#media-rights" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">3. Performance Photos &amp; Video Rights</a>
                            <a href="#how-we-use" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">4. How We Use Information</a>
                            <a href="#security-storage" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">5. Security, Storage &amp; Anti-Sale</a>
                            <a href="#parental-rights" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">6. Parental Rights &amp; Opt-Out</a>
                            <a href="#contact-dpo" class="block px-3 py-2 rounded-xl text-slate-600 hover:text-pink-600 hover:bg-pink-50/60 transition font-medium">7. Grievance Desk &amp; Contact</a>
                        </nav>
                    </div>

                    <!-- Verified Safeguard Badge Card -->
                    <div class="bg-gradient-to-br from-slate-900 to-gray-900 text-white rounded-3xl p-6 border border-slate-800 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-600 flex items-center justify-center font-bold text-base shadow-md shadow-pink-500/20">
                                🛡️
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-white">Student Data Safeguard</h3>
                                <p class="text-[11px] text-slate-400">Government Registered Academy</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            We treat our young performers' privacy with sacred respect. Personal records are strictly protected, and commercial monetization of student data is strictly prohibited.
                        </p>
                        <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-400">
                            <span>IAF &amp; EGAC Certified</span>
                            <span class="text-emerald-400 font-bold">100% Compliant</span>
                        </div>
                    </div>

                    <!-- Quick Support Contact -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 border border-white/90 shadow-xl space-y-3 text-xs text-slate-600">
                        <h3 class="font-extrabold text-slate-900 uppercase tracking-wider text-[11px]">Privacy Inquiries</h3>
                        <p class="text-slate-500 leading-relaxed">Questions regarding child consent or record updates? Reach out to our admissions desk:</p>
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

                <!-- Right Column: Policy Section Cards (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Section 1: Child Safety Commitment -->
                    <div id="commitment" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 01</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Commitment to Child &amp; Family Safety</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Founded in 2002 by <strong>Director Tirthraj Trivedi</strong>, Dynamice Children Academy has trained more than 6,000 children across Gujarat in classical Kathak, authentic folk heritage, and contemporary arts. Because the vast majority of our students are between 4 and 16 years of age, our highest responsibility is safeguarding their personal safety, dignity, and digital privacy.
                        </p>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            This Privacy Policy sets forth our operational principles regarding information collected via our website (<code>dynamicechildrenacademy.com</code>), paper admission forms, and studio campus interactions at our Nikol and Bapunagar branches.
                        </p>
                        <div class="bg-pink-50/70 border border-pink-200/60 rounded-2xl p-4 text-xs text-pink-950 flex items-start gap-3">
                            <span class="text-lg">📌</span>
                            <div>
                                <strong>Parental Consent Guarantee:</strong> We do not knowingly collect personal information directly from children under 18 years without the express knowledge and authorization of their parents or legal guardians.
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Information We Collect -->
                    <div id="info-collected" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 02</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Information We Collect</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            To deliver professional dance education, schedule batches, organize certified recitals, and coordinate national tour logistics, we collect only necessary and proportionate information:
                        </p>
                        <ul class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Student Identification Details:</strong> Student full name, date of birth, age, school grade, preferred dance genre (Kathak, Folk, Bollywood, Western), and campus branch.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Parent / Guardian Contact Information:</strong> Father's and Mother's names, primary phone number, secondary emergency contact number, email address, and residential address in Ahmedabad.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Health &amp; Physical Fitness Disclosures:</strong> Information on chronic physical ailments, asthma, or previous injuries to allow instructors to adapt dance physical drills safely.</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Enrolment &amp; Fee Receipts:</strong> Course registration dates, payment confirmation numbers, and attendance records (we do NOT store credit/debit card numbers or bank passwords).</div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="text-pink-600 font-bold mt-0.5">•</span>
                                <div><strong>Website Technical Data:</strong> Standard server logs, IP addresses, browser types, and anonymous traffic statistics to optimize site speed and security.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Section 3: Media Rights & Photography Consent -->
                    <div id="media-rights" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 03</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Photography, Video &amp; Performance Media Rights</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Dance is inherently a visual performing art. As our students participate in world record milestones (London Book of World Records), state cultural festivals, and television recordings, visual documentation is central to celebrating their achievements:
                        </p>
                        <div class="space-y-3 text-xs sm:text-sm text-slate-600">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                <h4 class="font-bold text-slate-900 mb-1">📸 Stage Performances &amp; Recitals</h4>
                                <p class="text-xs text-slate-500">Photographs and videos captured during annual stage recitals, Rashtriya Lok Utsavs, and public cultural tours are archived for educational portfolios, academy memory books, and press news coverage.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                <h4 class="font-bold text-slate-900 mb-1">🌐 Digital &amp; Social Archive Showcase</h4>
                                <p class="text-xs text-slate-500">Group performance photos and video highlights may be showcased on our official website gallery (<code>/gallery</code>), official YouTube channel, and verified Instagram page to honor student talent.</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                <h4 class="font-bold text-slate-900 mb-1">✋ Parental Opt-Out Protocol</h4>
                                <p class="text-xs text-slate-500">If a parent or legal guardian prefers that their child's solo close-up photograph not be published on digital platforms, they may notify the academy admissions desk in writing at admission time, and we will honor that request promptly.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: How We Use Information -->
                    <div id="how-we-use" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 04</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">How We Use Information</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Personal data is utilized exclusively for legitimate academy administration and student training purposes:
                        </p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                            <li class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                                <strong class="text-slate-900 block mb-1">1. Batch Scheduling</strong>
                                Assigning students to beginner, intermediate, or advanced batches based on age and skill.
                            </li>
                            <li class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                                <strong class="text-slate-900 block mb-1">2. Parent Communication</strong>
                                Timely SMS, WhatsApp, and call updates regarding exam dates, holiday schedules, and costume rehearsals.
                            </li>
                            <li class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                                <strong class="text-slate-900 block mb-1">3. Government &amp; Tour Accreditation</strong>
                                Submitting participant rosters for state festivals, CIOFF international festivals, and visa logistics.
                            </li>
                            <li class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                                <strong class="text-slate-900 block mb-1">4. Certified Diplomas</strong>
                                Printing recognized qualification certificates and grade report cards upon completion of curriculum levels.
                            </li>
                        </ul>
                    </div>

                    <!-- Section 5: Security, Storage & Anti-Sale -->
                    <div id="security-storage" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 05</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Security, Storage &amp; Anti-Sale Policy</h2>
                        </div>
                        <div class="bg-emerald-50/70 border border-emerald-200/60 rounded-2xl p-5 text-xs text-emerald-950 space-y-2">
                            <div class="flex items-center gap-2 font-bold text-sm text-emerald-900">
                                <span>🔒</span>
                                <span>Zero Commercial Data Monetization Guarantee</span>
                            </div>
                            <p class="leading-relaxed">
                                Dynamice Children Academy does <strong>NOT</strong> sell, rent, license, trade, or disclose student or parent phone numbers, emails, or personal information to third-party advertisers, telemarketers, or commercial databases under any circumstances.
                            </p>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            All electronic records are secured in password-protected, encrypted MySQL databases with role-based access control (RBAC). Only authorized administrative staff and Founder Director Shri Tirthraj Trivedi have operational access to student files.
                        </p>
                    </div>

                    <!-- Section 6: Parental Rights -->
                    <div id="parental-rights" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 06</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Parental Rights &amp; Opt-Out</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Parents and legal guardians retain sovereign rights over their child's records:
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-slate-600">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="font-bold text-slate-900 block mb-1">Right to Access</span>
                                Review all student contact and attendance data on file at our studio reception.
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="font-bold text-slate-900 block mb-1">Right to Rectify</span>
                                Update change of address, mobile number, or emergency contacts immediately.
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <span class="font-bold text-slate-900 block mb-1">Right to Deletion</span>
                                Request formal erasure of non-statutory records following course completion or branch transfer.
                            </div>
                        </div>
                    </div>

                    <!-- Section 7: Grievance Desk -->
                    <div id="contact-dpo" class="bg-white/95 backdrop-blur-md rounded-3xl p-7 sm:p-8 border border-white/90 shadow-xl space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-pink-100 text-pink-700 uppercase tracking-wide">Section 07</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Grievance Desk &amp; Academy Contact</h2>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            For any inquiries, requests to review student data, or policy clarifications, please contact our administrative desk or Director:
                        </p>
                        <div class="p-5 rounded-2xl bg-gradient-to-r from-slate-900 to-gray-900 text-white space-y-3 text-xs">
                            <div class="font-bold text-sm text-pink-400">Dynamice Children Academy • Administrative Office</div>
                            <div><strong>Director:</strong> Shri Tirthraj Trivedi</div>
                            <div><strong>Nikol Campus (HQ):</strong> Shop No. 201-204, 2nd Floor, Earth Complex, Nikol Gam Road, Nikol, Ahmedabad - 382350</div>
                            <div><strong>Bapunagar Campus:</strong> 204, Centre Point, India Colony Road, Bapunagar, Ahmedabad - 380024</div>
                            <div class="pt-2 border-t border-slate-800 flex flex-wrap gap-4">
                                <a href="tel:+919173878750" class="text-emerald-400 hover:underline">📞 +91 91738 78750</a>
                                <a href="mailto:info@dynamicechildrenacademy.com" class="text-cyan-400 hover:underline">✉ info@dynamicechildrenacademy.com</a>
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
