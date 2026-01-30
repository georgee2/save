<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label_english',
        'label_arabic',
        'description_english',
        'description_arabic',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value
     */
    public static function setValue(string $key, $value, string $type = 'string'): self
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = is_array($value) ? json_encode($value) : $value;
        $setting->type = $type;
        $setting->save();

        return $setting;
    }

    /**
     * Cast value to appropriate type
     */
    protected static function castValue($value, string $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
            case 'array':
                return json_decode($value, true);
            case 'string':
            default:
                return $value;
        }
    }

    /**
     * Get label based on current locale
     */
    public function getLabel(): ?string
    {
        if (app()->getLocale() === 'ar' && $this->label_arabic) {
            return $this->label_arabic;
        }
        return $this->label_english;
    }

    /**
     * Get description based on current locale
     */
    public function getDescription(): ?string
    {
        if (app()->getLocale() === 'ar' && $this->description_arabic) {
            return $this->description_arabic;
        }
        return $this->description_english;
    }

    /**
     * Get all settings for a group
     */
    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('group', $group)->get();
    }

    /**
     * Check if setting can be deleted
     */
    public function canBeDeleted(): bool
    {
        return !$this->is_system;
    }
}
