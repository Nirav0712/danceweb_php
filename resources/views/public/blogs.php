<?php
ob_start();

$pageTitle = !empty($page['title']) ? $page['title'] : (!empty($section['heading']) ? $section['heading'] : 'Dance Stories & Insights');
$pageSubtitle = !empty($page['subtitle']) ? $page['subtitle'] : (!empty($section['subheading']) ? $section['subheading'] : 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.');
$badgeLabel = !empty($section['content']) ? $section['content'] : 'PERSPECTIVES & WISDOM';

// Sample fallback stories matching screenshot if database is empty
$displayBlogs = !empty($blogs) ? $blogs : [
    [
        'id' => 1,
        'title' => 'Test Story Title',
        'slug' => 'test-story-title-1',
        'category' => 'Culture',
        'author_name' => 'Test Author',
        'featured_image_url' => '/assets/gallery/5.jpg',
        'published_at' => '2026-11-25 00:00:00',
        'excerpt' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
    ],
    [
        'id' => 2,
        'title' => 'Test Story Title',
        'slug' => 'test-story-title-2',
        'category' => 'Culture',
        'author_name' => 'Test Author',
        'featured_image_url' => '/assets/gallery/5.jpg',
        'published_at' => '2026-11-25 00:00:00',
        'excerpt' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
    ],
    [
        'id' => 3,
        'title' => 'Test Story Title',
        'slug' => 'test-story-title-3',
        'category' => 'Culture',
        'author_name' => 'Test Author',
        'featured_image_url' => '/assets/gallery/5.jpg',
        'published_at' => '2026-11-25 00:00:00',
        'excerpt' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
    ],
];
?>

<div class="min-h-screen text-slate-900 relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#fdf2f8]/40 to-[#fffbeb]/30">
    <!-- Ambient glowing backgrounds matching other pages -->
    <div class="absolute top-1/4 left-10 w-[500px] h-[500px] bg-pink-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-amber-400/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- =========================================================================
        HERO BANNER: Perspectives & Wisdom (100% Screenshot Matching)
        ========================================================================= -->
    <section class="relative bg-gradient-to-r from-gray-950 via-slate-900 to-gray-950 text-white py-20 lg:py-24 overflow-hidden">
        <!-- Top Iridescent Rainbow Line -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500 opacity-80"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest text-white shadow-sm mb-4 border border-white/20 bg-white/10 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 via-amber-400 to-cyan-400 animate-pulse"></span>
                <?= htmlspecialchars($badgeLabel, ENT_QUOTES, 'UTF-8') ?>
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-300 max-w-2xl mx-auto font-normal">
                <?= htmlspecialchars($pageSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>
    </section>

    <!-- =========================================================================
        MAIN STORIES GRID: 3-Column Card Layout matching Screenshot
        ========================================================================= -->
    <section class="py-16 sm:py-20 relative z-10">
        <div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12">
            <?php if (!empty($displayBlogs)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($displayBlogs as $b): 
                        $imgUrl = !empty($b['featured_image_url']) ? $b['featured_image_url'] : '/assets/gallery/5.jpg';
                        $storyCategory = !empty($b['category']) ? $b['category'] : 'Culture';
                        $storyAuthor = !empty($b['author_name']) ? $b['author_name'] : 'Director Tirthraj Trivedi';
                        $storyDate = !empty($b['published_at']) ? date('M j, Y', strtotime($b['published_at'])) : date('M j, Y');
                        $storySlug = !empty($b['slug']) ? $b['slug'] : 'story-' . $b['id'];
                    ?>
                        <article class="bg-white/95 backdrop-blur-md rounded-3xl border border-white/90 shadow-xl hover:shadow-2xl hover:shadow-pink-500/15 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group overflow-hidden relative">
                            <div>
                                <!-- Card Image with Category Badge -->
                                <div class="aspect-[16/10] bg-slate-100 overflow-hidden relative">
                                    <a href="/blog/<?= htmlspecialchars($storySlug, ENT_QUOTES, 'UTF-8') ?>" class="block w-full h-full">
                                        <img
                                            src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>"
                                            onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                                            alt="<?= htmlspecialchars($b['title'] ?? 'Dance Story', ENT_QUOTES, 'UTF-8') ?>"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    </a>
                                    <span class="absolute top-4 left-4 px-3.5 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-pink-600 shadow-sm border border-white/80 pointer-events-none">
                                        <?= htmlspecialchars($storyCategory, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6 sm:p-7 space-y-3">
                                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-500">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <?= htmlspecialchars($storyDate, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <?= htmlspecialchars($storyAuthor, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </div>

                                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-pink-600 transition-colors leading-snug">
                                        <a href="/blog/<?= htmlspecialchars($storySlug, ENT_QUOTES, 'UTF-8') ?>">
                                            <?= htmlspecialchars($b['title'] ?? 'Test Story Title', ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </h2>

                                    <?php
                                    $excerpt = !empty($b['excerpt']) ? $b['excerpt'] : strip_tags($b['content'] ?? '');
                                    if (!empty($excerpt)):
                                    ?>
                                        <p class="text-sm text-slate-600 leading-relaxed font-normal line-clamp-3">
                                            <?= htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Card Footer Link -->
                            <div class="p-6 sm:p-7 pt-0">
                                <a
                                    href="/blog/<?= htmlspecialchars($storySlug, ENT_QUOTES, 'UTF-8') ?>"
                                    class="inline-flex items-center gap-2 text-sm font-bold text-pink-600 hover:text-pink-700 transition-colors group/link"
                                >
                                    <span>Read Full Article</span>
                                    <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-white/80 rounded-3xl border border-slate-200 max-w-2xl mx-auto p-8 space-y-4">
                    <svg class="h-12 w-12 text-pink-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <h3 class="text-xl font-bold text-slate-900">Articles in Editorial Review</h3>
                    <p class="text-sm text-slate-600">
                        New articles and dance pedagogy insights are currently being compiled by Director Tirthraj Trivedi and the academy faculty. Check back soon!
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/public.php';
