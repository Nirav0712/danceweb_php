<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Core\CSRF;
use App\Services\AuthService;
use App\Models\User;

class AuthController
{
    public function showLogin(Request $request): Response
    {
        if (AuthService::check()) {
            return (new Response())->redirect('/admin');
        }

        return (new Response())->html(View::render('admin.login', [
            'title' => 'Admin Login — Dynamice Children Academy',
            'error' => null,
            'csrf_token' => CSRF::getToken(),
        ]));
    }

    public function login(Request $request): Response
    {
        $token = $request->post('csrf_token');
        if (!CSRF::validate($token)) {
            return (new Response())->html(View::render('admin.login', [
                'title' => 'Admin Login — Dynamice Children Academy',
                'error' => 'Security token invalid or expired. Please refresh and try again.',
                'csrf_token' => CSRF::getToken(),
            ]), 400);
        }

        $email = trim((string) $request->post('email'));
        $password = (string) $request->post('password');

        if (empty($email) || empty($password)) {
            return (new Response())->html(View::render('admin.login', [
                'title' => 'Admin Login — Dynamice Children Academy',
                'error' => 'Email and password are required.',
                'csrf_token' => CSRF::getToken(),
            ]), 422);
        }

        $result = AuthService::attempt($email, $password);
        if (!$result['success']) {
            return (new Response())->html(View::render('admin.login', [
                'title' => 'Admin Login — Dynamice Children Academy',
                'error' => $result['message'],
                'csrf_token' => CSRF::getToken(),
            ]), 401);
        }

        return (new Response())->redirect('/admin');
    }

    public function logout(Request $request): Response
    {
        AuthService::logout();
        return (new Response())->redirect('/admin/login');
    }

    public function showSetup(Request $request): Response
    {
        // One-time setup: only allowed if users table is empty OR explicitly invited
        $userCount = User::count();
        if ($userCount > 0) {
            return (new Response())->html(View::render('admin.setup_locked', [
                'title' => 'Setup Already Completed',
                'message' => 'The administrative account has already been initialized. Please log in.',
            ]), 403);
        }

        return (new Response())->html(View::render('admin.setup', [
            'title' => 'Initial Admin Setup — Dynamice Children Academy',
            'error' => null,
            'csrf_token' => CSRF::getToken(),
        ]));
    }

    public function setup(Request $request): Response
    {
        $userCount = User::count();
        if ($userCount > 0) {
            return (new Response())->redirect('/admin/login');
        }

        $token = $request->post('csrf_token');
        if (!CSRF::validate($token)) {
            return (new Response())->html(View::render('admin.setup', [
                'title' => 'Initial Admin Setup',
                'error' => 'Invalid CSRF token.',
                'csrf_token' => CSRF::getToken(),
            ]), 400);
        }

        $email = trim((string) $request->post('email'));
        $fullName = trim((string) $request->post('full_name'));
        $password = (string) $request->post('password');
        $confirmPassword = (string) $request->post('confirm_password');

        if (empty($email) || empty($fullName) || empty($password)) {
            return (new Response())->html(View::render('admin.setup', [
                'title' => 'Initial Admin Setup',
                'error' => 'All fields are required.',
                'csrf_token' => CSRF::getToken(),
            ]), 422);
        }

        if (strlen($password) < 12) {
            return (new Response())->html(View::render('admin.setup', [
                'title' => 'Initial Admin Setup',
                'error' => 'Password must be at least 12 characters long for production security.',
                'csrf_token' => CSRF::getToken(),
            ]), 422);
        }

        if ($password === 'Admin@12345') {
            return (new Response())->html(View::render('admin.setup', [
                'title' => 'Initial Admin Setup',
                'error' => 'Default password "Admin@12345" is strictly disallowed.',
                'csrf_token' => CSRF::getToken(),
            ]), 422);
        }

        if ($password !== $confirmPassword) {
            return (new Response())->html(View::render('admin.setup', [
                'title' => 'Initial Admin Setup',
                'error' => 'Passwords do not match.',
                'csrf_token' => CSRF::getToken(),
            ]), 422);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        User::create([
            'email' => $email,
            'full_name' => $fullName,
            'password_hash' => $hash,
            'role' => 'SUPER_ADMIN',
            'is_active' => 1,
        ]);

        return (new Response())->redirect('/admin/login');
    }
}
