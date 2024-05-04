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
        'admin' => [
            'manager' => 'a,v,e,d',
            'collector' => 'a,v,e,d',
            'claim' => 'a,v,e,d',
            'company' => 'v,e'

        ],
        'manager' => [
            'collector' => 'a,v,e,d',
            'claim' => 'a,d,v,e',
            // 'company' => 'v,e'
        ],
        'collector' => [
            'claim' => 'v',
            // 'company' => 'v,e'
        ],
        // 'role_name' => [
        //     'module_1_name' => 'c,r,u,d',
        // ]
    ],

    'permissions_map' => [
        'a' => 'add',
        'v' => 'view',
        'e' => 'edit',
        'd' => 'delete',
        // 'a' => 'all-permissions'
        
    ]
];
