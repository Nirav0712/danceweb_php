<?php ob_start(); ?>
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Staff & RBAC Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage administrative staff and permissions (SUPER_ADMIN, ADMIN, EDITOR)</p>
        </div>
        <button onclick="document.getElementById('createUserModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">
            + Add Staff Member
        </button>
    </div>

    <?php if (!empty($flash_success)): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl"><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($flash_error)): ?>
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl"><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-slate-400 font-semibold text-[11px]">
                    <tr>
                        <th class="px-6 py-3.5">User</th>
                        <th class="px-6 py-3.5">Role</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Last Login</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users as $u): ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div><?= htmlspecialchars($u['full_name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="text-[11px] text-slate-400"><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase <?= $u['role'] === 'SUPER_ADMIN' ? 'bg-purple-50 text-purple-700 border border-purple-100' : ($u['role'] === 'ADMIN' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-slate-100 text-slate-700') ?>">
                                <?= htmlspecialchars($u['role'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 <?= $u['is_active'] ? 'text-emerald-700' : 'text-slate-400' ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $u['is_active'] ? 'bg-emerald-500' : 'bg-slate-300' ?>"></span>
                                <?= $u['is_active'] ? 'Active' : 'Disabled' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">
                            <?= $u['last_login_at'] ? htmlspecialchars(date('M j, Y H:i', strtotime($u['last_login_at'])), ENT_QUOTES, 'UTF-8') : 'Never' ?>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <form method="POST" action="/admin/users/<?= $u['id'] ?>/delete" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div id="createUserModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Add Staff Member</h3>
        <form method="POST" action="/admin/users" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
                <input type="text" name="full_name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Role</label>
                <select name="role" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                    <option value="EDITOR">EDITOR (Media, Gallery, Stories, Testimonials)</option>
                    <option value="ADMIN">ADMIN (Full CMS Content & Curriculum)</option>
                    <option value="SUPER_ADMIN">SUPER_ADMIN (Full Access & Staff Control)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="isActive" checked class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="isActive" class="text-xs text-slate-600">Active Account</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('createUserModal').classList.add('hidden')" class="px-4 py-2 border border-slate-200 rounded-xl text-xs text-slate-600 font-semibold hover:bg-slate-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs">Create Staff</button>
            </div>
        </form>
    </div>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../../layouts/admin.php'; ?>
