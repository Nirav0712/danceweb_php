<?php

namespace App\Services;

class Permissions
{
    public const ROLES = [
        'SUPER_ADMIN' => 'SUPER_ADMIN',
        'ADMIN' => 'ADMIN',
        'EDITOR' => 'EDITOR',
    ];

    public const PERMISSIONS = [
        'SUPER_ADMIN' => [
            '*', // wildcard
        ],
        'ADMIN' => [
            'dashboard:view',
            'pages:view',
            'pages:create',
            'pages:edit',
            'pages:delete',
            'sections:manage',
            'homepage:manage',
            'menus:manage',
            'media:view',
            'media:upload',
            'media:delete',
            'dance_forms:manage',
            'gallery:view',
            'gallery:manage',
            'awards:manage',
            'associations:manage',
            'journey:manage',
            'news:manage',
            'blogs:manage',
            'testimonials:manage',
            'enquiries:view',
            'enquiries:update',
            'newsletter:manage',
            'branches:manage',
            'settings:manage',
            'seo:manage',
            'audit_logs:view',
        ],
        'EDITOR' => [
            'dashboard:view',
            'pages:view',
            'media:view',
            'media:upload',
            'gallery:view',
            'gallery:manage',
            'news:manage',
            'blogs:manage',
            'testimonials:manage',
        ],
    ];

    public static function can(string $role, string $permission): bool
    {
        if ($role === 'SUPER_ADMIN') {
            return true;
        }

        $rolePermissions = static::PERMISSIONS[$role] ?? [];
        if (in_array('*', $rolePermissions, true)) {
            return true;
        }

        return in_array($permission, $rolePermissions, true);
    }
}
