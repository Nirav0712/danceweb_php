<?php ob_start(); ?>
<div class="space-y-8">
    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dance Stories & Blog Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage public blog articles, stories, categories, and page banner settings</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/blog" target="_blank" class="px-3.5 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>View Public Page</span>
            </a>
            <button onclick="document.getElementById('createBlogModal').classList.remove('hidden')" class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Write New Story</span>
            </button>
        </div>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>
    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
    <?php endif; ?>

    <!-- =========================================================================
        1. PAGE BANNER & CMS SETTINGS (Perspectives & Wisdom Header)
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Page Header & Banner CMS Settings</h2>
                <p class="text-xs text-slate-500 mt-0.5">Customize the top rainbow hero badge, headline, and subtitle</p>
            </div>
            <span class="px-2.5 py-1 bg-pink-50 text-pink-700 text-[11px] font-bold rounded-lg border border-pink-100">Public Page: /blog</span>
        </div>

        <form method="POST" action="/admin/blogs/settings" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Pill Badge</label>
                    <input type="text" name="badge_label" value="<?= htmlspecialchars($section['content'] ?? 'PERSPECTIVES & WISDOM', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. PERSPECTIVES & WISDOM</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Page Title / Heading</label>
                    <input type="text" name="page_title" value="<?= htmlspecialchars($page['title'] ?? 'Dance Stories & Insights', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">e.g. Dance Stories & Insights</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Hero Subtitle</label>
                    <input type="text" name="page_subtitle" value="<?= htmlspecialchars($page['subtitle'] ?? 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                    <p class="text-[10px] text-slate-400 mt-1">Short descriptive sentence</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? 'Dynamice Children Academy | Dance Stories & Insights', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">SEO Meta Description</label>
                    <input type="text" name="meta_description" value="<?= htmlspecialchars($page['meta_description'] ?? 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-xs">
                    Save Header Settings
                </button>
            </div>
        </form>
    </div>

    <!-- =========================================================================
        2. STORIES TABLE LIST
        ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Published & Draft Stories (<?= count($posts) ?>)</h2>
            <span class="text-xs text-slate-400">All stories display on /blog</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">Cover</th>
                        <th class="px-6 py-3.5">Title & Author</th>
                        <th class="px-6 py-3.5">Category</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Published Date</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($posts)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">No blog stories written yet. Click "+ Write New Story" above.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-16 h-11 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img
                                        src="<?= htmlspecialchars(!empty($post['featured_image_url']) ? $post['featured_image_url'] : '/assets/gallery/5.jpg', ENT_QUOTES, 'UTF-8') ?>"
                                        onerror="this.onerror=null;this.src='/assets/gallery/5.jpg';"
                                        alt=""
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <a href="/blog/<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="hover:text-pink-600 transition-colors line-clamp-1">
                                    <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                                <div class="text-[11px] text-slate-400 font-normal">By <?= htmlspecialchars($post['author_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100">
                                    <?= htmlspecialchars($post['category'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold <?= $post['status'] === 'PUBLISHED' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-700 border border-slate-200' ?>">
                                    <?= htmlspecialchars($post['status'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-500">
                                <?= !empty($post['published_at']) ? date('M j, Y', strtotime($post['published_at'])) : '-' ?>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="/blog/<?= htmlspecialchars($post['slug'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="text-slate-500 hover:text-slate-700 font-semibold text-xs">View</a>
                                <button type="button" onclick="editBlog(<?= htmlspecialchars(json_encode($post), ENT_QUOTES, 'UTF-8') ?>)" class="text-pink-600 hover:text-pink-800 font-semibold text-xs">Edit</button>
                                <form method="POST" action="/admin/blogs/<?= $post['id'] ?>/delete" class="inline" onsubmit="return confirm('Are you sure you want to delete this story?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =========================================================================
    MODAL 1: CREATE NEW STORY
    ========================================================================= -->
<div id="createBlogModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Write New Story</h3>
            <button type="button" onclick="document.getElementById('createBlogModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="/admin/blogs" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Story Title <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Test Story Title" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" name="category" value="Culture" placeholder="e.g. Culture, Dance Education" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Author Name</label>
                    <input type="text" name="author_name" value="<?= htmlspecialchars($user['full_name'] ?? 'Test Author', ENT_QUOTES, 'UTF-8') ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Custom URL Slug (Optional)</label>
                    <input type="text" name="slug" placeholder="e.g. test-culture-story" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                        <option value="PUBLISHED" selected>PUBLISHED (Visible)</option>
                        <option value="DRAFT">DRAFT (Hidden)</option>
                        <option value="ARCHIVED">ARCHIVED</option>
                    </select>
                </div>
            </div>

            <!-- Featured Cover Image with direct file upload -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Cover Image</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Upload New File:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Or Existing Image URL:</span>
                        <input type="text" name="featured_image_url" placeholder="/assets/gallery/5.jpg" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Short Excerpt (Summary)</label>
                <textarea name="excerpt" rows="2" placeholder="Brief 1-2 sentence preview for the card..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Article Content <span class="text-rose-500">*</span></label>
                <textarea name="content" rows="6" required placeholder="Full story text and reflections..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500 font-sans"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('createBlogModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Publish Story</button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
    MODAL 2: EDIT STORY
    ========================================================================= -->
<div id="editBlogModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-100 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <h3 class="text-base font-bold text-slate-900">Edit Story</h3>
            <button type="button" onclick="document.getElementById('editBlogModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form id="editBlogForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Story Title <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_b_title" name="title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Category</label>
                    <input type="text" id="edit_b_category" name="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Author Name</label>
                    <input type="text" id="edit_b_author_name" name="author_name" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">URL Slug</label>
                    <input type="text" id="edit_b_slug" name="slug" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publish Status</label>
                    <select id="edit_b_status" name="status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500">
                        <option value="PUBLISHED">PUBLISHED (Visible)</option>
                        <option value="DRAFT">DRAFT (Hidden)</option>
                        <option value="ARCHIVED">ARCHIVED</option>
                    </select>
                </div>
            </div>

            <!-- Cover Image section -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                <label class="block text-xs font-semibold text-slate-700">Cover Image</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Upload New File:</span>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-500 block mb-1">Or Existing Image URL:</span>
                        <input type="text" id="edit_b_featured_image_url" name="featured_image_url" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Short Excerpt (Summary)</label>
                <textarea id="edit_b_excerpt" name="excerpt" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Article Content <span class="text-rose-500">*</span></label>
                <textarea id="edit_b_content" name="content" rows="6" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs outline-none focus:border-pink-500 font-sans"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editBlogModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-pink-500 to-rose-600 hover:opacity-95 text-white rounded-xl text-xs font-semibold shadow-xs">Update Story</button>
            </div>
        </form>
    </div>
</div>

<script>
function editBlog(post) {
    document.getElementById('editBlogForm').action = '/admin/blogs/' + post.id + '/update';
    document.getElementById('edit_b_title').value = post.title || '';
    document.getElementById('edit_b_slug').value = post.slug || '';
    document.getElementById('edit_b_category').value = post.category || 'Culture';
    document.getElementById('edit_b_author_name').value = post.author_name || '';
    document.getElementById('edit_b_featured_image_url').value = post.featured_image_url || '';
    document.getElementById('edit_b_status').value = post.status || 'PUBLISHED';
    document.getElementById('edit_b_excerpt').value = post.excerpt || '';
    document.getElementById('edit_b_content').value = post.content || '';
    document.getElementById('editBlogModal').classList.remove('hidden');
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
