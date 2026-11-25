<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Models\User;

class UsersController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('users:manage');
        $users = Database::fetchAll('SELECT id, email, full_name, role, is_active, last_login_at, created_at FROM users ORDER BY id ASC');
        return $this->render('admin.users.index', [
            'title' => 'Staff & RBAC Management — Dynamice CMS',
            'users' => $users,
        ]);
    }

    public function store(Request $request): Response
    {
        $this->checkPermission('users:manage');
        $data = $request->getBody();

        $email = trim($data['email'] ?? '');
        $fullName = trim($data['full_name'] ?? '');
        $role = $data['role'] ?? 'EDITOR';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($fullName) || empty($password)) {
            return $this->redirect('/admin/users', null, 'All fields including password are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->redirect('/admin/users', null, 'Invalid email address.');
        }

        if (User::findByEmail($email)) {
            return $this->redirect('/admin/users', null, 'A user with this email already exists.');
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $newId = User::create([
            'email' => $email,
            'password_hash' => $passwordHash,
            'full_name' => $fullName,
            'role' => $role,
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ]);

        $this->logAudit('CREATE', 'User', (string)$newId, ['email' => $email, 'role' => $role]);
        return $this->redirect('/admin/users', 'Staff member created successfully.');
    }

    public function update(Request $request, array $params): Response
    {
        $this->checkPermission('users:manage');
        $id = (int)($params['id'] ?? 0);
        $user = User::findById($id);

        if (!$user) {
            return $this->redirect('/admin/users', null, 'User not found.');
        }

        $data = $request->getBody();
        $fullName = trim($data['full_name'] ?? $user['full_name']);
        $role = $data['role'] ?? $user['role'];
        $isActive = isset($data['is_active']) ? 1 : 0;

        // Prevent deactivating or demoting the last SUPER_ADMIN
        if ($user['role'] === 'SUPER_ADMIN' && ($role !== 'SUPER_ADMIN' || $isActive === 0)) {
            $superAdmins = Database::fetchOne('SELECT COUNT(*) as c FROM users WHERE role = "SUPER_ADMIN" AND is_active = 1')['c'] ?? 0;
            if ($superAdmins <= 1) {
                return $this->redirect('/admin/users', null, 'Cannot demote or deactivate the only active SUPER_ADMIN.');
            }
        }

        Database::query(
            'UPDATE users SET full_name = :full_name, role = :role, is_active = :is_active, updated_at = NOW() WHERE id = :id',
            ['full_name' => $fullName, 'role' => $role, 'is_active' => $isActive, 'id' => $id]
        );

        if (!empty($data['password'])) {
            User::updatePassword($id, password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));
        }

        $this->logAudit('UPDATE', 'User', (string)$id, ['role' => $role, 'is_active' => $isActive]);
        return $this->redirect('/admin/users', 'Staff member updated successfully.');
    }

    public function delete(Request $request, array $params): Response
    {
        $this->checkPermission('users:manage');
        $id = (int)($params['id'] ?? 0);

        if ($id === ($this->user['id'] ?? 0)) {
            return $this->redirect('/admin/users', null, 'Cannot delete your own account.');
        }

        $user = User::findById($id);
        if (!$user) {
            return $this->redirect('/admin/users', null, 'User not found.');
        }

        if ($user['role'] === 'SUPER_ADMIN') {
            $superAdmins = Database::fetchOne('SELECT COUNT(*) as c FROM users WHERE role = "SUPER_ADMIN" AND is_active = 1')['c'] ?? 0;
            if ($superAdmins <= 1) {
                return $this->redirect('/admin/users', null, 'Cannot delete the only active SUPER_ADMIN.');
            }
        }

        Database::query('DELETE FROM users WHERE id = :id', ['id' => $id]);
        $this->logAudit('DELETE', 'User', (string)$id, ['email' => $user['email']]);
        return $this->redirect('/admin/users', 'Staff member deleted successfully.');
    }
}
