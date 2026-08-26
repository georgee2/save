<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, SoftDeletes;
    
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
        'account_type',
        'phone',
        'is_active',
        'preferred_locale',
        'consent_at',
        'source',
        'assigned_agent_id',
        'erp_customer_id',
        'erp_user_id',
        'password_set_at',
        'synced_at',
        'pending_email',
        'pending_email_token',
        'notification_prefs',
        'favourites_token',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // Both are bearer-equivalent: pending_email_token completes an email change and
        // favourites_token is the favourites authorization key.
        'pending_email_token',
        'favourites_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'consent_at' => 'datetime',
        'password_set_at' => 'datetime',
        'synced_at' => 'datetime',
        'notification_prefs' => 'array',
        'locked_until' => 'datetime',
    ];

    /**
     * Whether a brute-force lockout is currently in force.
     */
    public function isLockedOut(): bool
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    /**
     * Get the roles for the user
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')
            ->withTimestamps();
    }

    /**
     * The sales agent assigned to this customer (CRM).
     */
    public function assignedAgent()
    {
        return $this->belongsTo(Agent::class, 'assigned_agent_id');
    }

    /**
     * Determine if the user is a back-office staff account.
     */
    public function isStaff(): bool
    {
        return ($this->account_type ?? 'staff') === 'staff';
    }

    /**
     * Determine if the user is a front-end customer account.
     */
    public function isCustomer(): bool
    {
        return $this->account_type === 'customer';
    }

    /**
     * The customer's favourites (the account-linked wishlist).
     */
    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'user_id');
    }

    /**
     * The customer's FCM push token - at most one per user (see
     * UserFcmToken::saveForUser()); logging in on a new device replaces it.
     */
    public function fcmToken()
    {
        return $this->hasOne(UserFcmToken::class);
    }

    /**
     * The customer's canonical favourites list id — a stable random UUID that
     * becomes their `favourites.session_id` across devices (and share token).
     * Generated + persisted lazily on first use.
     */
    public function favouritesToken(): string
    {
        if (empty($this->favourites_token)) {
            $this->favourites_token = (string) \Illuminate\Support\Str::uuid();
            $this->save();
        }

        return $this->favourites_token;
    }

    /**
     * Whether the user may receive staff-initiated direct emails.
     *
     * Strict gate: the customer must have given consent (consent_at set) and must not
     * have opted out of email updates. Missing/null notification prefs default to allowed
     * (mirrors the settings UI default), but a missing consent_at blocks the send.
     */
    public function acceptsDirectEmail(): bool
    {
        if ($this->consent_at === null) {
            return false;
        }

        $prefs = $this->notification_prefs ?? [];

        return !array_key_exists('email_updates', $prefs) || $prefs['email_updates'] === true;
    }

    /**
     * Scope a query to only staff accounts.
     */
    public function scopeStaff($query)
    {
        return $query->where('account_type', 'staff');
    }

    /**
     * Scope a query to only customer accounts.
     */
    public function scopeCustomers($query)
    {
        return $query->where('account_type', 'customer');
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
            WHERE users.account_type = "staff"
              AND users.deleted_at IS NULL
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
