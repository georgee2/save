<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Model name mappings for human-readable names
     */
    protected static array $modelNames = [
        'App\Models\Project' => 'Project',
        'App\Models\ProjectImage' => 'Project Image',
        'App\Models\ProjectFloor' => 'Project Floor',
        'App\Models\Offer' => 'Offer',
        'App\Models\OfferImage' => 'Offer Image',
        'App\Models\OfferFloor' => 'Offer Floor',
        'App\Models\OfferCategory' => 'Offer Category',
        'App\Models\OfferSubCategory' => 'Offer Subcategory',
        'App\Models\EngineeringCategory' => 'Project Category',
        'App\Models\EngineeringSubCategory' => 'Project Subcategory',
        'App\Models\Service' => 'Service',
        'App\Models\News' => 'News',
        'App\Models\NewsCategory' => 'News Category',
        'App\Models\Team' => 'Team Member',
        'App\Models\Partner' => 'Partner',
        'App\Models\Portfolio' => 'Portfolio',
        'App\Models\Slider' => 'Slider',
        'App\Models\Menu' => 'Menu',
        'App\Models\MenuItem' => 'Menu Item',
        'App\Models\AboutInformation' => 'About Information',
        'App\Models\AboutFeature' => 'About Feature',
        'App\Models\AboutCustomBlock' => 'About Custom Block',
        'App\Models\ContactInformation' => 'Contact Information',
        'App\Models\Certificate' => 'Certificate',
        'App\Models\InteriorDesignGallery' => 'Interior Gallery',
        'App\Models\InteriorCategory' => 'Interior Category',
        'App\Models\JobPosting' => 'Job Posting',
        'App\Models\JobApplication' => 'Job Application',
        'App\Models\Amenity' => 'Amenity',
        'App\Models\BuildingComponent' => 'Building Component',
        'App\Models\FloorComponent' => 'Floor Component',
        'App\Models\IncomeComponent' => 'Income Component',
        'App\Models\LengthComponent' => 'Length Component',
        'App\Models\Currency' => 'Currency',
        'App\Models\Emirate' => 'Emirate',
        'App\Models\ProjectType' => 'Project Type',
        'App\Models\ProjectStyle' => 'Project Style',
        'App\Models\JobTitle' => 'Job Title',
        'App\Models\Rank' => 'Rank',
        'App\Models\HomeSection' => 'Home Section',
        'App\Models\SiteSetting' => 'Site Setting',
        'App\Models\User' => 'User',
    ];

    /**
     * Fields to exclude from logging (sensitive data)
     */
    protected static array $excludedFields = [
        'password',
        'remember_token',
        'api_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Log a create action
     */
    public static function logCreate(Model $model, ?string $recordTitle = null): ?ActivityLog
    {
        return self::log(
            ActivityLog::ACTION_CREATE,
            $model,
            null,
            $model->toArray(),
            $recordTitle
        );
    }

    /**
     * Log an update action
     */
    public static function logUpdate(Model $model, array $oldValues, ?string $recordTitle = null): ?ActivityLog
    {
        $newValues = $model->toArray();
        $changedFields = self::getChangedFields($oldValues, $newValues);
        
        if (empty($changedFields)) {
            return null;
        }

        return self::log(
            ActivityLog::ACTION_UPDATE,
            $model,
            $oldValues,
            $newValues,
            $recordTitle,
            $changedFields
        );
    }

    /**
     * Log a delete action
     */
    public static function logDelete(Model $model, ?string $recordTitle = null): ?ActivityLog
    {
        return self::log(
            ActivityLog::ACTION_DELETE,
            $model,
            $model->toArray(),
            null,
            $recordTitle
        );
    }

    /**
     * Log a restore action
     */
    public static function logRestore(Model $model, ?string $recordTitle = null): ?ActivityLog
    {
        return self::log(
            ActivityLog::ACTION_RESTORE,
            $model,
            null,
            $model->toArray(),
            $recordTitle
        );
    }

    /**
     * Log a force delete action
     */
    public static function logForceDelete(Model $model, ?string $recordTitle = null): ?ActivityLog
    {
        return self::log(
            ActivityLog::ACTION_FORCE_DELETE,
            $model,
            $model->toArray(),
            null,
            $recordTitle
        );
    }

    /**
     * Log a status toggle action
     */
    public static function logToggleStatus(Model $model, string $field, $oldValue, $newValue, ?string $recordTitle = null): ?ActivityLog
    {
        return self::log(
            ActivityLog::ACTION_TOGGLE_STATUS,
            $model,
            [$field => $oldValue],
            [$field => $newValue],
            $recordTitle,
            [$field]
        );
    }

    /**
     * Log a reorder action
     */
    public static function logReorder(string $modelClass, array $items, ?string $description = null): ?ActivityLog
    {
        $modelName = self::getModelName($modelClass);
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'System',
            'user_email' => Auth::user()?->email,
            'action' => ActivityLog::ACTION_REORDER,
            'model_type' => $modelClass,
            'model_name' => $modelName,
            'model_id' => null,
            'record_title' => null,
            'old_values' => null,
            'new_values' => ['items' => $items],
            'changed_fields' => ['order'],
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description ?? "Reordered {$modelName} items",
        ]);
    }

    /**
     * Log a bulk create action
     */
    public static function logBulkCreate(string $modelClass, int $count, ?string $description = null): ?ActivityLog
    {
        $modelName = self::getModelName($modelClass);
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'System',
            'user_email' => Auth::user()?->email,
            'action' => ActivityLog::ACTION_BULK_CREATE,
            'model_type' => $modelClass,
            'model_name' => $modelName,
            'model_id' => null,
            'record_title' => null,
            'old_values' => null,
            'new_values' => ['count' => $count],
            'changed_fields' => null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description ?? "Bulk created {$count} {$modelName} records",
        ]);
    }

    /**
     * Log a custom action
     */
    public static function logCustom(
        string $action,
        ?Model $model = null,
        ?string $modelClass = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $recordTitle = null,
        ?string $description = null
    ): ?ActivityLog {
        $modelType = $model ? get_class($model) : $modelClass;
        $modelName = $modelType ? self::getModelName($modelType) : 'System';
        
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'System',
            'user_email' => Auth::user()?->email,
            'action' => $action,
            'model_type' => $modelType,
            'model_name' => $modelName,
            'model_id' => $model?->id,
            'record_title' => $recordTitle,
            'old_values' => self::filterSensitiveData($oldValues),
            'new_values' => self::filterSensitiveData($newValues),
            'changed_fields' => $oldValues && $newValues ? self::getChangedFields($oldValues, $newValues) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Main logging method
     */
    public static function log(
        string $action,
        Model $model,
        ?array $oldValues,
        ?array $newValues,
        ?string $recordTitle = null,
        ?array $changedFields = null
    ): ?ActivityLog {
        $modelClass = get_class($model);
        $modelName = self::getModelName($modelClass);
        
        // Try to get record title from common fields
        if (!$recordTitle) {
            $recordTitle = self::extractRecordTitle($model);
        }

        // Generate description
        $description = self::generateDescription($action, $modelName, $recordTitle, $changedFields);

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'System',
            'user_email' => Auth::user()?->email,
            'action' => $action,
            'model_type' => $modelClass,
            'model_name' => $modelName,
            'model_id' => $model->id,
            'record_title' => $recordTitle,
            'old_values' => self::filterSensitiveData($oldValues),
            'new_values' => self::filterSensitiveData($newValues),
            'changed_fields' => $changedFields,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Log authentication events (login, logout, etc.)
     */
    public static function logAuth(
        string $action,
        ?Model $user = null,
        ?array $metadata = null
    ): ?ActivityLog {
        $authUser = $user ?? Auth::user();
        
        $description = match($action) {
            'login' => 'User logged in successfully',
            'logout' => 'User logged out',
            'failed_login' => 'Failed login attempt',
            default => ucfirst($action),
        };

        return ActivityLog::create([
            'user_id' => $authUser?->id,
            'user_name' => $authUser?->name ?? 'Unknown',
            'user_email' => $authUser?->email,
            'action' => $action,
            'model_type' => 'App\Models\User',
            'model_name' => 'Authentication',
            'model_id' => $authUser?->id,
            'record_title' => $authUser?->name ?? 'Unknown User',
            'old_values' => null,
            'new_values' => $metadata,
            'changed_fields' => null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Get human-readable model name
     */
    protected static function getModelName(string $modelClass): string
    {
        if (isset(self::$modelNames[$modelClass])) {
            return self::$modelNames[$modelClass];
        }

        // Extract class name from namespace
        $parts = explode('\\', $modelClass);
        $className = end($parts);
        
        // Convert CamelCase to words
        return preg_replace('/(?<!^)[A-Z]/', ' $0', $className);
    }

    /**
     * Extract record title from model
     */
    protected static function extractRecordTitle(Model $model): ?string
    {
        $titleFields = [
            'title_english',
            'name_english',
            'title',
            'name',
            'subject',
            'slug',
        ];

        foreach ($titleFields as $field) {
            if (!empty($model->{$field})) {
                return $model->{$field};
            }
        }

        return "ID: {$model->id}";
    }

    /**
     * Get changed fields between old and new values
     */
    protected static function getChangedFields(array $oldValues, array $newValues): array
    {
        $changed = [];
        
        foreach ($newValues as $key => $value) {
            // Skip excluded fields
            if (in_array($key, self::$excludedFields)) {
                continue;
            }
            
            // Skip timestamps and internal fields
            if (in_array($key, ['created_at', 'updated_at', 'deleted_at'])) {
                continue;
            }

            $oldValue = $oldValues[$key] ?? null;
            
            // Compare values (handle arrays/json)
            if (is_array($value) || is_array($oldValue)) {
                if (json_encode($value) !== json_encode($oldValue)) {
                    $changed[] = $key;
                }
            } elseif ($value != $oldValue) {
                $changed[] = $key;
            }
        }

        return $changed;
    }

    /**
     * Filter sensitive data from values
     */
    protected static function filterSensitiveData(?array $values): ?array
    {
        if (!$values) {
            return null;
        }

        foreach (self::$excludedFields as $field) {
            if (isset($values[$field])) {
                $values[$field] = '[HIDDEN]';
            }
        }

        return $values;
    }

    /**
     * Generate human-readable description
     */
    protected static function generateDescription(
        string $action,
        string $modelName,
        ?string $recordTitle,
        ?array $changedFields
    ): string {
        $title = $recordTitle ? "'{$recordTitle}'" : '';
        
        switch ($action) {
            case ActivityLog::ACTION_CREATE:
                return "Created {$modelName} {$title}";
            case ActivityLog::ACTION_UPDATE:
                $fields = $changedFields ? implode(', ', $changedFields) : 'fields';
                return "Updated {$modelName} {$title} ({$fields})";
            case ActivityLog::ACTION_DELETE:
                return "Deleted {$modelName} {$title}";
            case ActivityLog::ACTION_RESTORE:
                return "Restored {$modelName} {$title}";
            case ActivityLog::ACTION_FORCE_DELETE:
                return "Permanently deleted {$modelName} {$title}";
            case ActivityLog::ACTION_TOGGLE_STATUS:
                return "Changed status of {$modelName} {$title}";
            default:
                return ucfirst($action) . " {$modelName} {$title}";
        }
    }
}
