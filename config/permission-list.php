<?php

/**
 * [EM TESTE]
 */

return [
    'generic' => [
        'viewAny',
        'create',
        'update',
        'view',
        'delete',
        'forceDelete',
        'forceDeleteAny',
        'restore',
        'reorder',
        'send-a-feedback',
    ],
    'article' => [
        'edit articles',
        'delete articles',
        'publish articles',
        'unpublish articles',
    ],
    'painel' => [
        'painel:access',
    ],
    'tenant-management' => [
        'view-tenant-list',
        'impersonate-a-tenant',
    ],

    /**
     * ! CAUTION !
     * 'global_permissions' arw shared permissions for all users
     * All user will has this persmissions
     * Use only for non secure permissions
     */
    'global_permissions' => [
        'send-a-feedback',
    ],
];
