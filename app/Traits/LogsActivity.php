<?php

namespace App\Traits;

use App\Services\ActivityLogService;

/**
 * Trait to automatically log model activity (create, update, delete, restore)
 * Add this trait to any Eloquent model to enable automatic activity logging.
 * 
 * Usage: 
 * 1. Add `use \App\Traits\LogsActivity;` to your model
 * 2. Optionally define $logTitleField to specify which field to use as record title
 * 3. Optionally define $logExcludedFields to exclude specific fields from logging
 */
trait LogsActivity
{
    /**
     * Temporary storage for original values (not persisted to database)
     */
    protected static array $logOriginalValues = [];

    /**
     * Boot the trait and register model events
     */
    public static function bootLogsActivity()
    {
        // Log when model is created
        static::created(function ($model) {
            ActivityLogService::logCreate($model, $model->getLogTitle());
        });

        // Log when model is updated
        static::updating(function ($model) {
            // Store original values before update in static array using model key
            $key = get_class($model) . '_' . $model->getKey();
            static::$logOriginalValues[$key] = $model->getOriginal();
        });

        static::updated(function ($model) {
            $key = get_class($model) . '_' . $model->getKey();
            $oldValues = static::$logOriginalValues[$key] ?? $model->getOriginal();
            ActivityLogService::logUpdate($model, $oldValues, $model->getLogTitle());
            // Clean up
            unset(static::$logOriginalValues[$key]);
        });

        // Log when model is deleted (soft delete)
        static::deleted(function ($model) {
            // Check if this is a soft delete or force delete
            if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                ActivityLogService::logForceDelete($model, $model->getLogTitle());
            } else {
                ActivityLogService::logDelete($model, $model->getLogTitle());
            }
        });

        // Log when model is restored (if using SoftDeletes)
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                ActivityLogService::logRestore($model, $model->getLogTitle());
            });
        }
    }

    /**
     * Get the title/name to use in activity logs
     */
    public function getLogTitle(): ?string
    {
        // Check if model defines a custom title field
        if (property_exists($this, 'logTitleField') && $this->logTitleField) {
            return $this->{$this->logTitleField};
        }

        // Try common title fields
        $titleFields = [
            'title_english',
            'name_english',
            'title',
            'name',
            'subject',
            'slug',
        ];

        foreach ($titleFields as $field) {
            if (!empty($this->{$field})) {
                return $this->{$field};
            }
        }

        return "ID: {$this->id}";
    }

    /**
     * Get fields to exclude from logging
     */
    public function getLogExcludedFields(): array
    {
        if (property_exists($this, 'logExcludedFields')) {
            return $this->logExcludedFields;
        }

        return [];
    }
}
