<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'module',
        'action',
        'description',
        'order',
    ];

    /**
     * Get the roles that have this permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission')
            ->withTimestamps();
    }

    /**
     * Get all permissions grouped by module
     */
    public static function getGroupedByModule()
    {
        return self::orderBy('module')
            ->orderBy('order')
            ->get()
            ->groupBy('module');
    }

    /**
     * Get all permissions for a specific module
     */
    public static function getByModule(string $module)
    {
        return self::where('module', $module)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get all distinct modules
     */
    public static function getModules(): array
    {
        return self::select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module')
            ->toArray();
    }

    /**
     * Create permission with auto-generated slug
     */
    public static function createPermission(string $module, string $action, ?string $name = null, ?string $description = null): self
    {
        $slug = Str::slug($module . '-' . $action);
        $name = $name ?? ucfirst($action) . ' ' . ucwords(str_replace('-', ' ', $module));
        
        return self::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'module' => $module,
                'action' => $action,
                'description' => $description,
            ]
        );
    }

    /**
     * Create standard CRUD permissions for a module
     */
    public static function createCrudPermissions(string $module, string $moduleName, array $actions = null): array
    {
        $defaultActions = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'restore' => 'Restore',
            'force_delete' => 'Force Delete',
        ];

        $actions = $actions ?? $defaultActions;
        $permissions = [];
        $order = 0;

        foreach ($actions as $action => $actionName) {
            $slug = Str::slug($module . '-' . $action);
            $name = $actionName . ' ' . $moduleName;
            
            $permissions[] = self::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'module' => $module,
                    'action' => $action,
                    'description' => $name,
                    'order' => $order++,
                ]
            );
        }

        return $permissions;
    }

    /**
     * Get action label with icon
     */
    public function getActionInfo(): array
    {
        $actions = [
            'view' => ['label' => 'View', 'icon' => 'fa-eye', 'color' => 'info'],
            'create' => ['label' => 'Create', 'icon' => 'fa-plus', 'color' => 'success'],
            'edit' => ['label' => 'Edit', 'icon' => 'fa-edit', 'color' => 'warning'],
            'delete' => ['label' => 'Delete', 'icon' => 'fa-trash', 'color' => 'danger'],
            'restore' => ['label' => 'Restore', 'icon' => 'fa-undo', 'color' => 'primary'],
            'force_delete' => ['label' => 'Force Delete', 'icon' => 'fa-times', 'color' => 'dark'],
        ];

        return $actions[$this->action] ?? ['label' => ucfirst($this->action), 'icon' => 'fa-circle', 'color' => 'secondary'];
    }
}
