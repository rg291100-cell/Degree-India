<?php 
// app/Helpers/MenuHelper.php
namespace App\Helpers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function getSidebarMenu()
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        
        // Define menus based on role
        $menus = [
            'super_admin' => [
                // All menus
            ],
            'admin' => [
                'main' => ['dashboard'],
                'content_management' => ['courses', 'colleges', 'categories'],
                'admissions' => ['admission_desk'],
                'guidance' => ['expert_videos', 'career_counselling'],
                'content' => ['blogs'],
                'user_management' => ['users', 'notifications'],
                'system' => ['settings', 'profile'],
                'access_control' => ['roles']
            ],
            'content_manager' => [
                'main' => ['dashboard'],
                'content_management' => ['courses', 'categories'],
                'content' => ['blogs']
            ],
            'admission_officer' => [
                'main' => ['dashboard'],
                'admissions' => ['admission_desk']
            ],
            'counsellor' => [
                'main' => ['dashboard'],
                'guidance' => ['career_counselling']
            ]
        ];
        
        // Map role_id to role name
        $roleMap = [
            1 => 'super_admin',
            2 => 'admin',
            3 => 'content_manager',
            4 => 'content_editor',
            5 => 'admission_officer',
            6 => 'counsellor'
        ];
        
        $userRole = $roleMap[$roleId] ?? 'guest';
        
        return $menus[$userRole] ?? [];
    }
}