<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(20);

        $roles = Role::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $totalUsers = User::count();
        $usersWithRoles = User::whereHas('roles')->count();
        $usersWithoutRoles = $totalUsers - $usersWithRoles;

        return view('admin::users.roles', compact('users', 'roles', 'totalUsers', 'usersWithRoles', 'usersWithoutRoles'));
    }

    public function edit(User $user)
    {
        // Check if user is a Super Admin - cannot edit their roles
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.roles.index')
                ->with('error', 'You cannot modify the roles of a Super Admin user.');
        }

        // Get all active roles EXCEPT Super Admin (unless current user is Super Admin)
        $roles = Role::where('is_active', true)
            ->whereNull('deleted_at')
            ->when(!auth()->user()->isSuperAdmin(), function ($query) {
                $query->where('slug', '!=', 'super-admin');
            })
            ->orderBy('name')
            ->get();

        $userRoleIds = $user->roles->pluck('id')->toArray();

        return view('admin::users.edit-roles', compact('user', 'roles', 'userRoleIds'));
    }

    public function update(Request $request, User $user)
    {
        // Check if user is a Super Admin - cannot edit their roles
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.roles.index')
                ->with('error', 'You cannot modify the roles of a Super Admin user.');
        }

        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Get the Super Admin role
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        // Filter out Super Admin role if current user is not a Super Admin
        $roleIds = $request->roles ?? [];
        if (!auth()->user()->isSuperAdmin() && $superAdminRole) {
            $roleIds = array_filter($roleIds, function ($id) use ($superAdminRole) {
                return $id != $superAdminRole->id;
            });
            
            // If user already has Super Admin role, keep it
            if ($user->hasRole('super-admin')) {
                $roleIds[] = $superAdminRole->id;
            }
        }

        $user->roles()->sync($roleIds);

        return redirect()->route('admin.users.roles.index')
            ->with('success', 'User roles updated successfully.');
    }

    public function permissions(User $user)
    {
        $user->load('roles.permissions');
        $permissions = $user->getAllPermissions()->groupBy('module');

        return view('admin::users.permissions', compact('user', 'permissions'));
    }
}
