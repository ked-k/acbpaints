<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'dashboard' => 'c,r,u,d',
            'profile' => 'r,u',
            'operations'=> 'c,r,u,d'
        ],
        'administrator' => [
            'dashboard' => 'c,r,u,d',
            'profile' => 'r,u',
            'operations'=> 'c,r,u,d'
        ],
        'user' => [
            'profile' => 'r,u',
            'operations'=> 'c,r,u',
            'dashboard' => 'r,u'
        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
