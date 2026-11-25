<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\AuditService;
use App\Services\Permissions;

abstract class BaseAdminController
{
    protected array $user;

    public function __construct()
    {
        $this->user = AuthService::user() ?? [];
    }

    protected function checkPermission(string $permission): void
    {
        $role = $this->user['role'] ?? 'GUEST';
        if (!Permissions::can($role, $permission)) {
            http_response_code(403);
            echo View::render('errors.403', ['message' => "Forbidden: You do not have permission '{$permission}'"]);
            exit;
        }
    }

    protected function json(array $data, int $status = 200): Response
    {
        return (new Response())->json($data, $status);
    }

    protected function redirect(string $url, string $flashSuccess = null, string $flashError = null): Response
    {
        if ($flashSuccess) {
            \App\Core\Session::flash('success', $flashSuccess);
        }
        if ($flashError) {
            \App\Core\Session::flash('error', $flashError);
        }
        return (new Response())->redirect($url);
    }

    protected function render(string $view, array $data = []): Response
    {
        $data['user'] = $this->user;
        $data['flash_success'] = \App\Core\Session::flash('success');
        $data['flash_error'] = \App\Core\Session::flash('error');
        $data['csrf_token'] = \App\Core\CSRF::token();

        return (new Response())->html(View::render($view, $data));
    }

    protected function logAudit(string $action, string $entity, ?string $entityId = null, ?array $details = null): void
    {
        $userId = $this->user['id'] ?? null;
        AuditService::log($userId, $action, $entity, $entityId, $details);
    }
}
