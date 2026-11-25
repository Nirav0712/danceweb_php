<?php
ob_start();
?>
<section class="bg-slate-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-3">
        <span class="text-xs font-bold text-amber-400 uppercase tracking-widest">Reach Out</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold">Contact & Studios</h1>
        <p class="text-slate-300 text-sm">Join our batch training in Nikol or Bapunagar. Inquire for batches, timings, and fees.</p>
    </div>
</section>

<section class="py-20 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Studio Branches Information -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-widest block mb-1">Our Branches</span>
                    <h2 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">Visit Our Studios</h2>
                </div>
                <div class="space-y-6">
                    <?php foreach ($branches as $branch): ?>
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                            <h3 class="font-bold text-slate-900 text-base"><?= htmlspecialchars($branch['branch_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="text-slate-600 text-xs leading-relaxed"><?= htmlspecialchars($branch['address_line1'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="pt-2 flex flex-col gap-1 text-xs text-slate-500">
                                <span>📞 <strong>Phone:</strong> <?= htmlspecialchars($branch['phone_primary'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                                <span>⏰ <strong>Timings:</strong> <?= htmlspecialchars($branch['timing_info'] ?? 'Mon - Sat: 9:00 AM - 8:00 PM', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-amber-50 border border-amber-200/80 p-6 rounded-2xl text-amber-900 space-y-2">
                    <span class="font-bold text-sm block">Director Contact</span>
                    <p class="text-xs leading-relaxed text-amber-800">
                        For institutional workshops, national festival invites, and overseas cultural delegations, contact Founder Director Shri Tirthraj Trivedi.
                    </p>
                    <span class="font-bold text-xs text-amber-900 block pt-1">✉️ <?= htmlspecialchars($settings['email'] ?? 'dynamicechildrenacademy@gmail.com', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>

            <!-- Admission Enquiry Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm space-y-6">
                    <div>
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-widest block mb-1">Student Admissions</span>
                        <h2 class="font-serif text-2xl font-bold text-slate-900">Online Admission Enquiry</h2>
                        <p class="text-xs text-slate-500 mt-1">Submit your details below and our faculty will contact you within 24 hours.</p>
                    </div>

                    <div id="enquirySuccessMsg" class="hidden p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold"></div>
                    <div id="enquiryErrorMsg" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold"></div>

                    <form id="publicEnquiryForm" action="/api/enquiries" method="POST" class="space-y-4">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Student Name *</label>
                                <input type="text" name="student_name" required placeholder="Full Name of Student"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Parent / Guardian Name</label>
                                <input type="text" name="parent_name" placeholder="Parent or Guardian"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Number *</label>
                                <input type="tel" name="phone" required placeholder="+91 98765 43210"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                                <input type="email" name="email" placeholder="example@gmail.com"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Preferred Campus</label>
                            <select name="branch_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all">
                                <option value="1">Nikol Branch (Vaikunth Complex)</option>
                                <option value="2">Bapunagar Branch (Centre Point)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Student Age & Dance Interest</label>
                            <textarea name="message" rows="3" placeholder="E.g., Age 8, interested in Folk Garba & Western batch..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition-all"></textarea>
                        </div>

                        <button type="submit" id="enquirySubmitBtn"
                            class="w-full py-3.5 px-6 bg-gradient-to-r from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                            Submit Admission Enquiry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('publicEnquiryForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('enquirySubmitBtn');
    const succ = document.getElementById('enquirySuccessMsg');
    const err = document.getElementById('enquiryErrorMsg');

    succ.classList.add('hidden');
    err.classList.add('hidden');
    btn.disabled = true;
    btn.innerText = 'Submitting...';

    const formData = new FormData(this);
    try {
        const res = await fetch('/api/enquiries', {
            method: 'POST',
            body: formData,
        });
        const data = await res.json();
        if (data.success) {
            succ.innerText = data.message;
            succ.classList.remove('hidden');
            this.reset();
        } else {
            err.innerText = data.message || 'Error submitting enquiry.';
            err.classList.remove('hidden');
        }
    } catch {
        err.innerText = 'Network error. Please try again or call our branch directly.';
        err.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        btn.innerText = 'Submit Admission Enquiry';
    }
});
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
