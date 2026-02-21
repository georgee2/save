<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $trashedCount = Role::onlyTrashed()->count();

        return view('admin::roles.index', compact('roles', 'trashedCount'));
    }

    public function trashed()
    {
        $roles = Role::onlyTrashed()
            ->withCount(['users', 'permissions'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin::roles.trashed', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::getGroupedByModule();

        return view('admin::roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'is_system' => false,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        $permissionsByModule = $role->permissions->groupBy('module');

        return view('admin::roles.show', compact('role', 'permissionsByModule'));
    }

    public function edit(Role $role)
    {
        if ($role->is_system && $role->slug === 'super-admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Super Admin role cannot be edited.');
        }

        $permissions = Permission::getGroupedByModule();
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('admin::roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->is_system && $role->slug === 'super-admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Super Admin role cannot be edited.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'System roles cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role that has users assigned. Please reassign users first.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function restore($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);
        $role->restore();

        return redirect()->route('admin.roles.trashed')
            ->with('success', 'Role restored successfully.');
    }

    public function forceDelete($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);

        if ($role->is_system) {
            return redirect()->route('admin.roles.trashed')
                ->with('error', 'System roles cannot be permanently deleted.');
        }

        $role->permissions()->detach();
        $role->forceDelete();

        return redirect()->route('admin.roles.trashed')
            ->with('success', 'Role permanently deleted.');
    }

    public function toggleActive(Role $role)
    {
        if ($role->is_system && $role->slug === 'super-admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Super Admin role cannot be deactivated.');
        }

        $role->update(['is_active' => !$role->is_active]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role status updated successfully.');
    }
}
