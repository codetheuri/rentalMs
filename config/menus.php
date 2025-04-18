<?php
require_once __DIR__ . '/wrapper.php';
$userMenu = [
    // ['title' => 'Dashboard', 'icon' => 'home', 'url'=>'/dashboard'], 
   
     ['title' => 'User management', 'icon' => 'shield', 'submenus' => [
        ['title' => 'User Management', 'url' => '/dashboard/profile/index'],
        ['title' => 'Manage Roles', 'url' => '/dashboard/role/index'],
        ['title' => 'Manage Permissions', 'url' => '/dashboard/permission/index'],
        // ['title' => 'Manage Rules', 'url' => 'rule/index'],
    ]],
    
    

    ];

// return array_merge($userMenu, (new ConfigWrapper())->load('apiMenus'));
return $userMenu;
