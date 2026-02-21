<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ChecksPermissions
{
    /**
     * Check if current user has permission
     */
    protected function userCan(string $permission): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasPermission($permission);
    }

    /**
     * Check if current user has any of the given permissions
     */
    protected function userCanAny(array $permissions): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        return $user->hasAnyPermission($permissions);
    }

    /**
     * Abort if user doesn't have permission
     */
    protected function authorizePermission(string $permission, ?string $message = null): void
    {
        if (!$this->userCan($permission)) {
            abort(403, $message ?? 'You do not have permission to perform this action.');
        }
    }

    /**
     * Abort if user doesn't have any of the given permissions
     */
    protected function authorizeAnyPermission(array $permissions, ?string $message = null): void
    {
        if (!$this->userCanAny($permissions)) {
            abort(403, $message ?? 'You do not have permission to perform this action.');
        }
    }

    /**
     * Get permission slug for module action
     */
    protected function getPermissionSlug(string $module, string $action): string
    {
        return $module . '-' . $action;
    }

    /**
     * Check view permission for module
     */
    protected function canView(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'view'));
    }

    /**
     * Check create permission for module
     */
    protected function canCreate(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'create'));
    }

    /**
     * Check edit permission for module
     */
    protected function canEdit(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'edit'));
    }

    /**
     * Check delete permission for module
     */
    protected function canDelete(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'delete'));
    }

    /**
     * Check restore permission for module
     */
    protected function canRestore(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'restore'));
    }

    /**
     * Check force delete permission for module
     */
    protected function canForceDelete(string $module): bool
    {
        return $this->userCan($this->getPermissionSlug($module, 'force_delete'));
    }
}
