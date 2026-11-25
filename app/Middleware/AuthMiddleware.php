<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;

class AuthMiddleware
{
    public function handle(Request $request): ?Response
    {
        if (!AuthService::check()) {
            return (new Response())->redirect('/admin/login');
        }
        return null;
    }
}
