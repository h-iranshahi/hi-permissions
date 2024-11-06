<?php

return [

     // Default table name for roles
    'roles_table' => 'usermanager_roles', 

     // Default table name for permissions
    'permissions_table' => 'usermanager_permissions', 

    // Default pivot table name for users and roles
    'user_role_table' => 'usermanager_user_role',

    // Default pivot table name for roles and permissions
    'role_permission_table' => 'usermanager_role_permission',

    // Default pivot table name for users and permissions
    'user_permission_table' => 'usermanager_user_permission',

    // Default table name for access levels
    'access_levels_table' => 'usermanager_access_levels',

    // Default user model
    'user_model' => App\Models\User::class,
];
