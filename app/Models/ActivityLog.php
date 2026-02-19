<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'action',
        'model_type',
        'model_name',
        'model_id',
        'record_title',
        'old_values',
        'new_values',
        'changed_fields',
        'ip_address',
        'user_agent',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
    ];

    /**
     * Action constants
     */
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_RESTORE = 'restore';
    const ACTION_FORCE_DELETE = 'force_delete';
    const ACTION_TOGGLE_STATUS = 'toggle_status';
    const ACTION_REORDER = 'reorder';
    const ACTION_BULK_CREATE = 'bulk_create';
    const ACTION_BULK_DELETE = 'bulk_delete';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';

    /**
     * Get the user that performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get action label with color
     */
    public function getActionLabel(): array
    {
        $labels = [
            self::ACTION_CREATE => ['label' => 'Created', 'color' => 'success', 'icon' => 'fa-plus'],
            self::ACTION_UPDATE => ['label' => 'Updated', 'color' => 'info', 'icon' => 'fa-edit'],
            self::ACTION_DELETE => ['label' => 'Deleted', 'color' => 'danger', 'icon' => 'fa-trash'],
            self::ACTION_RESTORE => ['label' => 'Restored', 'color' => 'warning', 'icon' => 'fa-undo'],
            self::ACTION_FORCE_DELETE => ['label' => 'Permanently Deleted', 'color' => 'dark', 'icon' => 'fa-times'],
            self::ACTION_TOGGLE_STATUS => ['label' => 'Status Changed', 'color' => 'secondary', 'icon' => 'fa-toggle-on'],
            self::ACTION_REORDER => ['label' => 'Reordered', 'color' => 'primary', 'icon' => 'fa-sort'],
            self::ACTION_BULK_CREATE => ['label' => 'Bulk Created', 'color' => 'success', 'icon' => 'fa-plus-circle'],
            self::ACTION_BULK_DELETE => ['label' => 'Bulk Deleted', 'color' => 'danger', 'icon' => 'fa-trash-alt'],
            self::ACTION_LOGIN => ['label' => 'Logged In', 'color' => 'primary', 'icon' => 'fa-sign-in-alt'],
            self::ACTION_LOGOUT => ['label' => 'Logged Out', 'color' => 'secondary', 'icon' => 'fa-sign-out-alt'],
        ];

        return $labels[$this->action] ?? ['label' => ucfirst($this->action), 'color' => 'secondary', 'icon' => 'fa-circle'];
    }

    /**
     * Get paginated logs with filters
     */
    public static function getFiltered(array $filters = [], int $perPage = 20)
    {
        $query = self::query()->orderBy('created_at', 'desc');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['model_type'])) {
            $query->where('model_type', $filters['model_type']);
        }

        if (!empty($filters['model_name'])) {
            $query->where('model_name', $filters['model_name']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('record_title', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get distinct model names for filter dropdown
     */
    public static function getDistinctModelNames(): array
    {
        return self::select('model_name')
            ->distinct()
            ->orderBy('model_name')
            ->pluck('model_name')
            ->toArray();
    }

    /**
     * Get distinct actions for filter dropdown
     */
    public static function getDistinctActions(): array
    {
        return self::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
    }

    /**
     * Get users who have activity logs
     */
    public static function getDistinctUsers(): \Illuminate\Support\Collection
    {
        return self::select('user_id', 'user_name')
            ->whereNotNull('user_id')
            ->distinct()
            ->orderBy('user_name')
            ->get();
    }
}
