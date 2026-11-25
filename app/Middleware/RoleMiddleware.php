<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\Permissions;

class RoleMiddleware
{
    protected array $allowedRoles;

    public function __construct(array $allowedRoles = [])
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function handle(Request $request): ?Response
    {
        $user = AuthService::user();
        if (!$user) {
            return (new Response())->redirect('/admin/login');
        }

        if (!in_array($user['role'], $this->allowedRoles, true)) {
            $resp = new Response();
            $resp->status(403);
            return $resp->html(View::render('errors.403', [
                'title' => '403 Forbidden',
                'message' => 'You do not have administrative permission to access this area.',
                'user' => $user
            ]), 403);
        }

        return null;
    }
}
