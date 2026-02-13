<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        // Don't paginate, get all permissions for datatable
        $permissions = Permission::with('roles')->get();
        $modules = Permission::distinct()->pluck('module');
        
        return view('admin.permissions.index', compact('permissions', 'modules'));
    }

    public function create()
    {
        $modules = Permission::distinct()->pluck('module');
        return view('admin.permissions.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Permission::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'module' => $request->module,
            'description' => $request->description
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $modules = Permission::distinct()->pluck('module');
        return view('admin.permissions.edit', compact('permission', 'modules'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'module' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $permission->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'module' => $request->module,
            'description' => $request->description
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Cannot delete permission assigned to roles.');
        }

        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}