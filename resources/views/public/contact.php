<?php
ob_start();

$pageTitle = !empty($section['heading']) ? $section['heading'] : (!empty($page['title']) && $page['title'] !== 'Contact' && $page['title'] !== 'Contact Us' ? $page['title'] : 'Connect With Our Academy');
$pageSubtitle = !empty($section['subheading']) ? $section['subheading'] : (!empty($page['subtitle']) ? $page['subtitle'] : 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.');
$badgeLabel = !empty($section['content']) ? $section['content'] : 'ADMISSIONS & ENQUIRIES';

$primaryPhone = !empty($settings['contact_phone']) ? $settings['contact_phone'] : '+91 99242 81372';
$primaryEmail = !empty($settings['contact_email']) ? $settings['contact_email'] : 'info@dynamicechildrenacademy.com';

$nikolAddress = 'Shop No. 201-204, 2nd Floor, Earth Complex, Nikol Gam Road, Nikol, Ahmedabad - 382350';
$bapunagarAddress = '204, Centre Point, India Colony Road, Bapunagar, Ahmedabad - 380024';

$successParam = $_GET['success'] ?? null;
$errorParam = $_GET['error'] ?? null;
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/40 to-[#fffbeb]/30">
    <!-- Ambient glowing backgrounds matching other pages -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-purple-500/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        HERO BANNER: Admissions & Enquiries (100% Screenshot Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-16 sm:py-20 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                <?= htmlspecialchars($badgeLabel, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-4">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="max-w-2xl mx-auto text-slate-300 text-base sm:text-lg font-normal">
                <?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        MAIN CONTENT: 2-Column Contact Info & Enquiry Form
        ========================================================================= -->
    <section class="py-16 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Academy Info & Campuses -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <!-- Quick Contact Card: Academy Headquarters -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-7 border border-white/90 shadow-xl space-y-6 relative overflow-hidden">
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Academy Headquarters</span>
                        </h2>

                        <div class="space-y-5 text-sm text-slate-600">
                            <!-- Phone -->
                            <div class="flex items-start gap-3.5">
                                <div class="p-3 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-white flex-shrink-0 shadow-md shadow-pink-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">Direct Inquiries / Admission Line</div>
                                    <a href="tel:<?= preg_replace('/\s+/', '', $primaryPhone) ?>" class="text-pink-600 hover:text-pink-700 font-semibold">
                                        <?= htmlspecialchars($primaryPhone, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                    <div class="text-xs text-slate-400 mt-0.5 font-medium">Mon – Sat, 9:00 AM – 8:00 PM IST</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-3.5">
                                <div class="p-3 rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 text-white flex-shrink-0 shadow-md shadow-purple-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">Official Email</div>
                                    <a href="mailto:<?= htmlspecialchars($primaryEmail, ENT_QUOTES, 'UTF-8') ?>" class="text-purple-600 hover:text-purple-700 font-semibold break-all">
                                        <?= htmlspecialchars($primaryEmail, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                    <div class="text-xs text-slate-400 mt-0.5 font-medium">Response within 24 working hours</div>
                                </div>
                            </div>

                            <!-- Hours -->
                            <div class="flex items-start gap-3.5">
                                <div class="p-3 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex-shrink-0 shadow-md shadow-amber-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">Operational Hours</div>
                                    <p class="text-slate-600 font-medium">Monday to Saturday: 8:00 AM – 9:00 PM</p>
                                    <p class="text-slate-600 font-medium">Sunday: 8:00 AM – 2:00 PM (Special Batches)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campus Locations Card -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-7 border border-white/90 shadow-xl space-y-4 relative overflow-hidden">
                        <h3 class="text-lg font-extrabold text-slate-900">Our Teaching Campuses</h3>
                        
                        <div class="space-y-4">
                            <!-- Nikol Campus -->
                            <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/70 hover:bg-slate-50 transition-all">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-slate-900">Nikol Branch (HQ)</h4>
                                    <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full bg-pink-100 text-pink-700 border border-pink-200">
                                        Main Studio
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2 flex items-start gap-2 font-medium">
                                    <svg class="w-4 h-4 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span><?= htmlspecialchars($nikolAddress, ENT_QUOTES, 'UTF-8') ?></span>
                                </p>
                                <div class="mt-2.5 flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-200/60 font-medium">
                                    <span>Phone: +91 99242 81372</span>
                                    <a
                                        href="https://maps.google.com/?q=Nikol+Gam+Road+Ahmedabad"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="text-pink-600 hover:text-pink-700 font-bold inline-flex items-center gap-1"
                                    >
                                        <span>View Map ↗</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Bapunagar Campus -->
                            <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/70 hover:bg-slate-50 transition-all">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-slate-900">Bapunagar Branch</h4>
                                    <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-700 border border-purple-200">
                                        Studio
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2 flex items-start gap-2 font-medium">
                                    <svg class="w-4 h-4 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span><?= htmlspecialchars($bapunagarAddress, ENT_QUOTES, 'UTF-8') ?></span>
                                </p>
                                <div class="mt-2.5 flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-200/60 font-medium">
                                    <span>Phone: +91 99242 81372</span>
                                    <a
                                        href="https://maps.google.com/?q=India+Colony+Bapunagar+Ahmedabad"
                                        target="_blank"
                                        rel="noreferrer"
                                        class="text-pink-600 hover:text-pink-700 font-bold inline-flex items-center gap-1"
                                    >
                                        <span>View Map ↗</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Director Note -->
                    <div class="bg-gradient-to-br from-pink-500/10 via-white/80 to-amber-50/50 rounded-3xl p-6 border border-pink-200/80 shadow-md text-sm text-slate-700">
                        <div class="font-extrabold text-slate-900 mb-1">Personal Guidance from Tirthraj Trivedi</div>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Parents wishing to consult directly with Founder & Director Tirthraj Trivedi regarding advanced classical or international festival performance tracks are invited to schedule an appointment via our admission desk.
                        </p>
                    </div>

                </div>

                <!-- Right Column: Send Us an Enquiry Form -->
                <div class="lg:col-span-7">
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/90 p-7 sm:p-10 relative overflow-hidden">
                        <div class="mb-8">
                            <h2 class="text-2xl font-extrabold text-slate-900 flex items-center gap-2">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <span>Send Us an Enquiry</span>
                            </h2>
                            <p class="text-slate-500 text-sm mt-1 font-medium">
                                Fill out the form below for admissions, trial classes, or performance bookings. We will respond promptly.
                            </p>
                        </div>

                        <!-- Flash Alert Messages -->
                        <?php if (!empty($successParam)): ?>
                            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start gap-3 text-emerald-800 text-sm font-medium">
                                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <div><?= htmlspecialchars($successParam, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($errorParam)): ?>
                            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-start gap-3 text-rose-800 text-sm font-medium">
                                <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <div><?= htmlspecialchars($errorParam, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                        <?php endif; ?>

                        <div id="ajaxSuccessMsg" class="hidden mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium"></div>
                        <div id="ajaxErrorMsg" class="hidden mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium"></div>

                        <form id="contactEnquiryForm" action="/api/enquiries" method="POST" class="space-y-5">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            
                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    required
                                    placeholder="e.g., Aarav Patel"
                                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white/80 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                >
                            </div>

                            <!-- Email & Phone Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Email Address <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        required
                                        placeholder="e.g., aarav@example.com"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Phone Number <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="tel"
                                        name="phone"
                                        required
                                        placeholder="e.g., +91 99242 81372"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                    >
                                </div>
                            </div>

                            <!-- Preferred Branch & Subject -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Preferred Branch
                                    </label>
                                    <select
                                        name="preferred_branch"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                    >
                                        <option value="Nikol Branch (HQ)">Nikol Branch (HQ)</option>
                                        <option value="Bapunagar Branch">Bapunagar Branch</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Enquiry Type / Subject <span class="text-rose-500">*</span>
                                    </label>
                                    <select
                                        name="subject"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all"
                                    >
                                        <option value="New Admission Enquiry">New Admission Enquiry</option>
                                        <option value="Trial Class Booking">Trial Class Booking</option>
                                        <option value="Folk & Garba Workshop">Folk & Garba Workshop</option>
                                        <option value="Festival / Event Choreography">Festival / Event Choreography</option>
                                        <option value="General Query">General Query</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Message -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Message / Student Details <span class="text-rose-500">*</span>
                                </label>
                                <textarea
                                    name="message"
                                    rows="4"
                                    required
                                    placeholder="Please include student age, prior dance experience (if any), and your questions or preferred batch timing..."
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all resize-y"
                                ></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button
                                    type="submit"
                                    id="submitEnquiryBtn"
                                    class="w-full sm:w-auto px-10 py-4 rounded-full bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 hover:scale-105 text-white font-extrabold text-sm shadow-lg shadow-pink-500/30 transition-all flex items-center justify-center gap-2"
                                >
                                    <span>Send Admission Enquiry</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                                <p class="text-xs text-slate-400 mt-3 font-normal">
                                    By submitting, you agree to allow Dynamice Children Academy to contact you via phone or email regarding your enquiry. We never share your data.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- =========================================================================
                INTERACTIVE GOOGLE MAPS SWITCHER (Screenshot 3 Matching)
                ========================================================================= -->
            <div class="mt-16 bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Find Our Studios on Google Maps</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Visit either of our air-conditioned dance training facilities in Ahmedabad</p>
                    </div>
                    <div class="inline-flex p-1.5 rounded-2xl bg-slate-100 self-start sm:self-auto gap-1">
                        <button
                            type="button"
                            id="mapTabNikol"
                            onclick="switchMapBranch('nikol')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-pink-600 shadow-xs"
                        >
                            Nikol Branch (HQ)
                        </button>
                        <button
                            type="button"
                            id="mapTabBapunagar"
                            onclick="switchMapBranch('bapunagar')"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900"
                        >
                            Bapunagar Branch
                        </button>
                    </div>
                </div>

                <div class="relative w-full h-80 sm:h-96 bg-slate-100">
                    <iframe
                        id="branchMapIframe"
                        title="Dynamice Children Academy Studio Map"
                        src="https://maps.google.com/maps?q=Nikol+Gam+Road+Ahmedabad&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        class="w-full h-full border-0"
                        loading="lazy"
                        allowfullscreen
                    ></iframe>
                </div>
                
                <div id="branchAddressFooter" class="p-4 bg-slate-50 text-xs text-slate-600 text-center border-t border-slate-200 font-medium">
                    <span><strong>Nikol Campus:</strong> <?= htmlspecialchars($nikolAddress, ENT_QUOTES, 'UTF-8') ?> • Call: +91 99242 81372</span>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
function switchMapBranch(branch) {
    const btnNikol = document.getElementById('mapTabNikol');
    const btnBapunagar = document.getElementById('mapTabBapunagar');
    const iframe = document.getElementById('branchMapIframe');
    const footer = document.getElementById('branchAddressFooter');

    if (branch === 'nikol') {
        btnNikol.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-pink-600 shadow-xs';
        btnBapunagar.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900';
        iframe.src = 'https://maps.google.com/maps?q=Nikol+Gam+Road+Ahmedabad&t=&z=15&ie=UTF8&iwloc=&output=embed';
        footer.innerHTML = '<span><strong>Nikol Campus:</strong> <?= htmlspecialchars($nikolAddress, ENT_QUOTES, 'UTF-8') ?> • Call: +91 99242 81372</span>';
    } else {
        btnBapunagar.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-pink-600 shadow-xs';
        btnNikol.className = 'px-4 py-2 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900';
        iframe.src = 'https://maps.google.com/maps?q=India+Colony+Bapunagar+Ahmedabad&t=&z=15&ie=UTF8&iwloc=&output=embed';
        footer.innerHTML = '<span><strong>Bapunagar Campus:</strong> <?= htmlspecialchars($bapunagarAddress, ENT_QUOTES, 'UTF-8') ?> • Call: +91 99242 81372</span>';
    }
}

// Ajax form handler
document.getElementById('contactEnquiryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn = document.getElementById('submitEnquiryBtn');
    const successBox = document.getElementById('ajaxSuccessMsg');
    const errorBox = document.getElementById('ajaxErrorMsg');

    successBox.classList.add('hidden');
    errorBox.classList.add('hidden');
    btn.disabled = true;
    btn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Submitting Enquiry...';

    const formData = new FormData(form);

    fetch('/api/enquiries', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Admission Enquiry</span><svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>';
        if (data.success) {
            successBox.textContent = data.message || 'Thank you! Your enquiry has been received.';
            successBox.classList.remove('hidden');
            form.reset();
        } else {
            errorBox.textContent = data.message || 'Error sending enquiry. Please check your fields.';
            errorBox.classList.remove('hidden');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<span>Send Admission Enquiry</span>';
        errorBox.textContent = 'Network or server error submitting enquiry. Please call us directly.';
        errorBox.classList.remove('hidden');
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
