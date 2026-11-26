<?php
$settings = \App\Services\ContentService::getSettings();
?>
<!-- =========================================================================
     FOOTER: 100% Matching Screenshot Design, Exact Details & Academy Theme
     ========================================================================= -->
<footer class="relative bg-[#0a0f1d] text-slate-300 text-xs overflow-hidden border-t border-slate-800/80">
    <!-- Top Iridescent Rainbow Line matching Hero & Pages -->
    <div class="h-1 w-full bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-90"></div>

    <!-- Ambient Glow Effects -->
    <div class="absolute -top-24 left-1/4 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 right-1/4 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 pt-14 pb-8 relative z-10">
        <!-- Main Footer Columns Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-8 lg:gap-6 xl:gap-8 items-start">
            
            <!-- Column 1: Brand & Logo (3 cols) -->
            <div class="sm:col-span-2 md:col-span-3 lg:col-span-3 space-y-4">
                <a href="/" class="inline-block group">
                    <img src="/logodance.png" alt="Dynamice Children Academy Logo" class="h-16 w-auto object-contain brightness-110 transform group-hover:scale-105 transition-transform duration-300">
                </a>
                <p class="text-slate-400 text-xs leading-relaxed max-w-sm font-normal">
                    Premier dance academy dedicated to excellence in dance education since 2005. We nurture talent and passion through comprehensive training programs.
                </p>
                <div class="pt-1 flex items-center gap-2 text-[11px] text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Govt. Reg. Children Dance Academy • Ahmedabad</span>
                </div>
            </div>

            <!-- Column 2: QUICK LINKS (1.5 cols) -->
            <div class="lg:col-span-2 space-y-3.5">
                <h3 class="text-white font-extrabold text-xs tracking-wider uppercase">QUICK LINKS</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="/" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="/about" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>Gallery</span>
                        </a>
                    </li>
                    <li>
                        <a href="/journey/national" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>National</span>
                        </a>
                    </li>
                    <li>
                        <a href="/journey/international" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>International</span>
                        </a>
                    </li>
                    <li>
                        <a href="/blog" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>Blogs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-1.5 group">
                            <span class="text-pink-500 font-bold group-hover:translate-x-0.5 transition-transform">→</span>
                            <span>Contact Us</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: DANCE FORMS (2 cols) -->
            <div class="lg:col-span-2 space-y-3.5">
                <h3 class="text-white font-extrabold text-xs tracking-wider uppercase">DANCE FORMS</h3>
                <ul class="space-y-2 text-xs">
                    <li>
                        <a href="/gallery?category=1" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Bollywood</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery?category=2" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Folk Dance</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery?category=3" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Contemporary</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery?category=5" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Patriotic</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery?category=6" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Religious</span>
                        </a>
                    </li>
                    <li>
                        <a href="/gallery?category=4" class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-1.5">
                            <span class="text-amber-400 text-sm leading-none">•</span>
                            <span>Western</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: CLASS TIMINGS (1 col) -->
            <div class="lg:col-span-1 space-y-3.5">
                <h3 class="text-white font-extrabold text-xs tracking-wider uppercase">CLASS TIMINGS</h3>
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-300 font-bold block mb-0.5">Weekdays</span>
                        <span class="text-slate-400 block font-medium">7 AM - 9 PM</span>
                    </div>
                    <div>
                        <span class="text-slate-300 font-bold block mb-0.5">Weekends</span>
                        <span class="text-slate-400 block font-medium">8 AM - 8 PM</span>
                    </div>
                </div>
            </div>

            <!-- Column 5: GET IN TOUCH - Nikol Branch (2 cols) -->
            <div class="lg:col-span-2 space-y-3.5">
                <h3 class="text-white font-extrabold text-xs tracking-wider uppercase">GET IN TOUCH</h3>
                <div class="space-y-2 text-xs">
                    <!-- Address -->
                    <a href="https://maps.google.com/?q=VAIKUNTH+COMPLEX,+NR.+RASPAN+ARCADE,+NIKOL,+Ahmedabad" target="_blank" rel="noopener" class="text-slate-400 hover:text-pink-400 transition-colors flex items-start gap-2 leading-snug group" title="Open Nikol Branch on Google Maps">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="uppercase">VAIKUNTH COMPLEX, NR. RASPAN ARCADE, NIKOL.</span>
                    </a>

                    <!-- Phone 1 -->
                    <a href="tel:+919173878750" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+91 91738 78750</span>
                    </a>

                    <!-- Phone 2 -->
                    <a href="tel:+917228053232" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+91 72280 53232</span>
                    </a>

                    <!-- Email -->
                    <a href="mailto:dynamicechildrenacademy@gmail.com" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2 truncate" title="Send email to academy">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="truncate">dynamicechildrenacademy@gmail.com</span>
                    </a>

                    <!-- Social Icons Row with Subscribe Newsletter Symbol -->
                    <div class="flex items-center gap-2 pt-2">
                        <a href="https://www.facebook.com" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/dynamice_children_academy/" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Instagram">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Twitter / X">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@dynamicechildrenacademy" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="YouTube">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <!-- Newsletter Subscribe Symbol Button -->
                        <button type="button" onclick="openNewsletterModal()" class="w-7 h-7 rounded-lg bg-rose-600 hover:bg-rose-500 hover:scale-110 active:scale-95 text-white flex items-center justify-center shadow-md shadow-rose-600/40 transition-all cursor-pointer relative group" title="Subscribe to Academy Updates">
                            <svg class="w-3.5 h-3.5 transform -rotate-45 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span class="absolute -top-7 left-1/2 -translate-x-1/2 px-1.5 py-0.5 bg-slate-900 border border-white/10 text-white text-[10px] font-medium rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-20">Subscribe</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Column 6: GET IN TOUCH - Bapunagar Branch (2 cols) -->
            <div class="lg:col-span-2 space-y-3.5">
                <h3 class="text-white font-extrabold text-xs tracking-wider uppercase">GET IN TOUCH</h3>
                <div class="space-y-2 text-xs">
                    <!-- Address -->
                    <a href="https://maps.google.com/?q=204,+CENTRE+POINT,+INDIA+COLONY+ROAD,+BAPUNAGAR,+Ahmedabad" target="_blank" rel="noopener" class="text-slate-400 hover:text-pink-400 transition-colors flex items-start gap-2 leading-snug group" title="Open Bapunagar Branch on Google Maps">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="uppercase">204, CENTRE POINT, INDIA COLONY ROAD, BAPUNAGAR.</span>
                    </a>

                    <!-- Phone 1 -->
                    <a href="tel:+919173878750" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+91 91738 78750</span>
                    </a>

                    <!-- Phone 2 -->
                    <a href="tel:+917228053232" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+91 72280 53232</span>
                    </a>

                    <!-- Email -->
                    <a href="mailto:dynamicechildrenacademy@gmail.com" class="text-slate-400 hover:text-pink-400 transition-colors flex items-center gap-2 truncate" title="Send email to academy">
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="truncate">dynamicechildrenacademy@gmail.com</span>
                    </a>

                    <!-- Social Icons Row with Subscribe Newsletter Symbol -->
                    <div class="flex items-center gap-2 pt-2">
                        <a href="https://www.facebook.com" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.596 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/dynamice_children_academy/" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Instagram">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="Twitter / X">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@dynamicechildrenacademy" target="_blank" rel="noopener" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-pink-500 hover:bg-pink-600 hover:text-white flex items-center justify-center text-slate-400 transition-all" title="YouTube">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <!-- Newsletter Subscribe Symbol Button -->
                        <button type="button" onclick="openNewsletterModal()" class="w-7 h-7 rounded-lg bg-rose-600 hover:bg-rose-500 hover:scale-110 active:scale-95 text-white flex items-center justify-center shadow-md shadow-rose-600/40 transition-all cursor-pointer relative group" title="Subscribe to Academy Updates">
                            <svg class="w-3.5 h-3.5 transform -rotate-45 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span class="absolute -top-7 left-1/2 -translate-x-1/2 px-1.5 py-0.5 bg-slate-900 border border-white/10 text-white text-[10px] font-medium rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-20">Subscribe</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright & Legal Bar -->
        <div class="mt-14 pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <!-- Left: Copyright -->
            <p class="text-center md:text-left">
                © <?= date('Y') ?> Dynamice Children Academy. All rights reserved.
            </p>

            <!-- Center: Made with Love -->
            <p class="text-center">
                Made with <span class="text-rose-500 inline-block animate-pulse">❤️</span> by Dynamice Team
            </p>

            <!-- Right: Policy Links (Privacy Policy & Terms of Service) -->
            <div class="flex items-center gap-4 text-xs">
                <a href="/privacy-policy" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                <span class="text-slate-700">•</span>
                <a href="/terms" class="hover:text-slate-300 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- =========================================================================
     NEWSLETTER SUBSCRIPTION MODAL POPUP
     Opened via the newsletter symbol in the upper row
     ========================================================================= -->
<div id="newsletterModal" class="fixed inset-0 z-50 hidden transition-all duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop Blur & Overlay -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeNewsletterModal()"></div>

    <!-- Modal Dialog Center -->
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4 sm:p-6">
        <div class="relative w-full max-w-md bg-[#0f172a] border border-slate-700/80 rounded-3xl shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="newsletterModalCard">
            
            <!-- Top Iridescent Rainbow Line -->
            <div class="h-1.5 w-full bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500"></div>

            <!-- Ambient Glow Effect -->
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-rose-500/15 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Close Button -->
            <button type="button" onclick="closeNewsletterModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white flex items-center justify-center transition-all cursor-pointer z-10" aria-label="Close modal">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="p-6 sm:p-8 space-y-5 relative z-10">
                <!-- Red Circular Plane Icon + Subscribe Title -->
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-rose-600/40">
                        <svg class="w-5 h-5 transform -rotate-45 -mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </span>
                    <div>
                        <h3 class="text-white font-black text-lg sm:text-xl tracking-tight" id="modal-title">Subscribe</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Get updates on new courses</p>
                    </div>
                </div>

                <p class="text-slate-300 text-xs leading-relaxed">
                    Be the first to receive updates on upcoming dance batches, festival tours, workshop admissions, and cultural performances.
                </p>

                <!-- Subscribe Form -->
                <form id="footerNewsletterForm" action="/api/newsletter/subscribe" method="POST" class="space-y-3 pt-1">
                    <?= \App\Helpers\Security::csrfField() ?>
                    <div>
                        <input type="email" name="email" id="footerSubEmail" required placeholder="Your email address" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 text-xs sm:text-sm outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                    </div>
                    <button type="submit" id="footerSubBtn" class="w-full py-3 px-5 bg-gradient-to-r from-rose-600 via-pink-600 to-rose-600 hover:opacity-95 text-white font-bold rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg shadow-rose-600/30 transition-all cursor-pointer">
                        <span>Subscribe</span>
                        <span class="text-base leading-none">→</span>
                    </button>
                    <div id="footerSubMsg" class="hidden text-xs p-3 rounded-xl"></div>
                </form>

                <div class="pt-2 border-t border-slate-800 text-[11px] text-slate-500 flex items-center justify-between">
                    <span>🔒 No spam, unsubscribe anytime.</span>
                    <a href="/privacy-policy" class="hover:text-slate-400 underline">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Modal & Ajax Script -->
<script>
function openNewsletterModal() {
    const modal = document.getElementById('newsletterModal');
    const card = document.getElementById('newsletterModalCard');
    if (!modal || !card) return;
    modal.classList.remove('hidden');
    setTimeout(() => {
        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
        const emailInput = document.getElementById('footerSubEmail');
        if (emailInput) emailInput.focus();
    }, 10);
}

function closeNewsletterModal() {
    const modal = document.getElementById('newsletterModal');
    const card = document.getElementById('newsletterModalCard');
    if (!modal || !card) return;
    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNewsletterModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('footerNewsletterForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('footerSubBtn');
        const emailInput = document.getElementById('footerSubEmail');
        const msg = document.getElementById('footerSubMsg');

        if (!emailInput.value) return;

        btn.disabled = true;
        const originalBtnHtml = btn.innerHTML;
        btn.innerHTML = '<span>Subscribing...</span>';
        msg.className = 'hidden text-xs p-3 rounded-xl';

        const formData = new FormData(form);

        fetch('/api/newsletter/subscribe', {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
            msg.classList.remove('hidden');

            if (data.success) {
                msg.className = 'text-xs p-3 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
                msg.textContent = data.message || 'Thank you! You are now subscribed to our academy updates.';
                emailInput.value = '';
                setTimeout(() => {
                    closeNewsletterModal();
                }, 3000);
            } else {
                msg.className = 'text-xs p-3 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20';
                msg.textContent = data.message || 'Error subscribing. Please try again.';
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
            msg.classList.remove('hidden');
            msg.className = 'text-xs p-3 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20';
            msg.textContent = 'Server or network error. Please try again later.';
        });
    });
});
</script>
