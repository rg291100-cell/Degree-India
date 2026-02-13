<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'module' => 'dashboard'],
            
            // Course Management
            ['name' => 'View Courses', 'slug' => 'view-courses', 'module' => 'courses'],
            ['name' => 'Create Courses', 'slug' => 'create-courses', 'module' => 'courses'],
            ['name' => 'Edit Courses', 'slug' => 'edit-courses', 'module' => 'courses'],
            ['name' => 'Delete Courses', 'slug' => 'delete-courses', 'module' => 'courses'],
            
            // College Management
            ['name' => 'View Colleges', 'slug' => 'view-colleges', 'module' => 'colleges'],
            ['name' => 'Create Colleges', 'slug' => 'create-colleges', 'module' => 'colleges'],
            ['name' => 'Edit Colleges', 'slug' => 'edit-colleges', 'module' => 'colleges'],
            ['name' => 'Delete Colleges', 'slug' => 'delete-colleges', 'module' => 'colleges'],
            
            // Category Management
            ['name' => 'View Categories', 'slug' => 'view-categories', 'module' => 'categories'],
            ['name' => 'Create Categories', 'slug' => 'create-categories', 'module' => 'categories'],
            ['name' => 'Edit Categories', 'slug' => 'edit-categories', 'module' => 'categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories', 'module' => 'categories'],
            
            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'module' => 'users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'module' => 'users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'module' => 'users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'module' => 'users'],
            
            // Role & Permission Management
            ['name' => 'View Roles', 'slug' => 'view-roles', 'module' => 'roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'module' => 'roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'module' => 'roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'module' => 'roles'],
            ['name' => 'View Permissions', 'slug' => 'view-permissions', 'module' => 'permissions'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'module' => 'permissions'],
            
            // Content Management
            ['name' => 'View Blogs', 'slug' => 'view-blogs', 'module' => 'content'],
            ['name' => 'Create Blogs', 'slug' => 'create-blogs', 'module' => 'content'],
            ['name' => 'Edit Blogs', 'slug' => 'edit-blogs', 'module' => 'content'],
            ['name' => 'Delete Blogs', 'slug' => 'delete-blogs', 'module' => 'content'],
            
            // Settings
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create Roles
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'description' => 'Has full system access',
            'is_default' => false
        ]);

        $student = Role::create([
            'name' => 'Student',
            'slug' => 'student',
            'description' => 'Regular student user',
            'is_default' => true
        ]);

        // Assign all permissions to Super Admin
        $superAdmin->permissions()->sync(Permission::all()->pluck('id'));

        // Assign basic permissions to Student
        $studentPermissions = Permission::whereIn('slug', [
            'view-dashboard',
            'view-courses',
            'view-colleges',
            'view-categories'
        ])->pluck('id');
        
        $student->permissions()->sync($studentPermissions);

        
    }
}