<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;
    
    protected $logTitleField = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the roles for the user
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')
            ->withTimestamps();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->exists();
    }

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permissionSlug): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionSlug) {
                $query->where('slug', $permissionSlug);
            })
            ->exists();
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionSlugs) {
                $query->whereIn('slug', $permissionSlugs);
            })
            ->exists();
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions(array $permissionSlugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $userPermissions = $this->getAllPermissions()->pluck('slug')->toArray();
        
        foreach ($permissionSlugs as $slug) {
            if (!in_array($slug, $userPermissions)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get all permissions for the user (through roles)
     */
    public function getAllPermissions()
    {
        if ($this->isSuperAdmin()) {
            return Permission::all();
        }

        return Permission::whereHas('roles', function ($query) {
            $query->whereIn('roles.id', $this->roles()->pluck('roles.id'));
        })->get();
    }

    /**
     * Get all permission slugs for the user
     */
    public function getPermissionSlugs(): array
    {
        if ($this->isSuperAdmin()) {
            return Permission::pluck('slug')->toArray();
        }

        return $this->getAllPermissions()->pluck('slug')->toArray();
    }

    /**
     * Assign role to user
     */
    public function assignRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    /**
     * Assign multiple roles to user
     */
    public function assignRoles(array $roles): void
    {
        $roleIds = [];
        
        foreach ($roles as $role) {
            if (is_string($role)) {
                $r = Role::where('slug', $role)->first();
                if ($r) {
                    $roleIds[] = $r->id;
                }
            } elseif (is_numeric($role)) {
                $roleIds[] = $role;
            } elseif ($role instanceof Role) {
                $roleIds[] = $role->id;
            }
        }

        $this->roles()->syncWithoutDetaching($roleIds);
    }

    /**
     * Remove role from user
     */
    public function removeRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->detach($role->id);
    }

    /**
     * Sync roles for user
     */
    public function syncRoles(array $roleIds): void
    {
        $this->roles()->sync($roleIds);
    }

    /**
     * Get role names as comma-separated string
     */
    public function getRoleNames(): string
    {
        return $this->roles()->pluck('name')->implode(', ');
    }

    public function NewRecord(array $data){
       return $this->create($data);
    }

    public function list(){
        $user = DB::select('
            SELECT 
                users.id AS "Code",
                users.name AS "User Name",
                users.email AS "E-mail"
            FROM users 
            ');
        return $user;
    }

    public function find(int $id){
        return $this->findOrFail($id);
    }

    public function updateRecord(int $id , array $data){

        $this->findOrFail($id)->update($data);
    }

    public function deleteRecord(int $id){

        $this->findOrFail($id)->delete();
    }
}
