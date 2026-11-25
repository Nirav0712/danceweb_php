<?php
namespace App\Services;

use App\Core\Database;

class AuditService
{
    public static function log(?int $userId, string $action, string $entity, ?string $entityId = null, ?array $details = null, ?string $ip = null): void
    {
        try {
            Database::query(
                'INSERT INTO audit_logs (user_id, action, entity, entity_id, details, ip_address, created_at) 
                 VALUES (:user_id, :action, :entity, :entity_id, :details, :ip_address, NOW())',
                [
                    'user_id' => $userId,
                    'action' => strtoupper($action),
                    'entity' => $entity,
                    'entity_id' => $entityId ? (string)$entityId : null,
                    'details' => $details ? json_encode($details, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                    'ip_address' => $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'),
                ]
            );
        } catch (\Throwable $e) {
            // Fail safely without blocking the main workflow
        }
    }
}
