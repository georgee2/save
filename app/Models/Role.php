<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Role extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'name';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system',
        'is_active',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    /**
     * Get the permissions for the role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission')
            ->withTimestamps();
    }

    /**
     * Get the users for the role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role')
            ->withTimestamps();
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Check if role has any of the given permissions
     */
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        return $this->permissions()->whereIn('slug', $permissionSlugs)->exists();
    }

    /**
     * Check if role has all of the given permissions
     */
    public function hasAllPermissions(array $permissionSlugs): bool
    {
        return $this->permissions()->whereIn('slug', $permissionSlugs)->count() === count($permissionSlugs);
    }

    /**
     * Give permission to role
     */
    public function givePermission($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }

        $this->permissions()->syncWithoutDetaching([$permission->id]);
    }

    /**
     * Give multiple permissions to role
     */
    public function givePermissions(array $permissions): void
    {
        $permissionIds = [];
        
        foreach ($permissions as $permission) {
            if (is_string($permission)) {
                $perm = Permission::where('slug', $permission)->first();
                if ($perm) {
                    $permissionIds[] = $perm->id;
                }
            } elseif (is_numeric($permission)) {
                $permissionIds[] = $permission;
            } elseif ($permission instanceof Permission) {
                $permissionIds[] = $permission->id;
            }
        }

        $this->permissions()->syncWithoutDetaching($permissionIds);
    }

    /**
     * Revoke permission from role
     */
    public function revokePermission($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission->id);
    }

    /**
     * Sync permissions for role
     */
    public function syncPermissions(array $permissionIds): void
    {
        $this->permissions()->sync($permissionIds);
    }

    /**
     * Get all active roles
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all roles for listing
     */
    public static function list()
    {
        return self::withCount(['users', 'permissions'])
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get trashed roles
     */
    public static function getTrashed()
    {
        return self::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
    }

    /**
     * Check if role is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->slug === 'super-admin';
    }
}
