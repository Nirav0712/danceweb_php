<?php
namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class AuditLogsController extends BaseAdminController
{
    public function index(Request $request): Response
    {
        $this->checkPermission('audit_logs:view');
        $entity = trim((string)($request->query('entity') ?? $request->getParam('entity') ?? ''));
        $action = trim((string)($request->query('action') ?? $request->getParam('action') ?? ''));

        $sql = 'SELECT a.*, u.email as user_email, u.full_name as user_name FROM audit_logs a LEFT JOIN users u ON a.user_id = u.id WHERE 1=1';
        $params = [];

        if (!empty($entity)) {
            $sql .= ' AND a.entity = :entity';
            $params['entity'] = $entity;
        }

        if (!empty($action)) {
            $sql .= ' AND a.action = :action';
            $params['action'] = $action;
        }

        $sql .= ' ORDER BY a.created_at DESC LIMIT 100';
        $logs = Database::fetchAll($sql, $params);

        return $this->render('admin.audit_logs.index', [
            'title' => 'Audit Activity Logs — Dynamice CMS',
            'logs' => $logs,
            'selected_entity' => $entity,
            'selected_action' => $action,
        ]);
    }
}
