<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeInteriorSetting extends Model
{
    use HasFactory;

    protected $table = 'home_interior_settings';
    
    protected $fillable = [
        'max_show',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the singleton settings instance
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'max_show' => 12,
            'is_active' => true,
        ]);
    }

    /**
     * Get selected items for home display
     */
    public function selectedItems()
    {
        return $this->hasMany(HomeInteriorItem::class, 'id', 'id')
            ->orderBy('ordering', 'asc');
    }

    /**
     * Check if manual selection mode is active
     */
    public function hasManualSelection()
    {
        return HomeInteriorItem::count() > 0;
    }

    /**
     * Get interior galleries for home display
     * Returns manually selected if available, otherwise auto (latest)
     */
    public static function getGalleriesForHome()
    {
        $settings = self::getSettings();
        $manualItems = HomeInteriorItem::with('gallery')
            ->orderBy('ordering', 'asc')
            ->get();

        if ($manualItems->count() > 0) {
            return $manualItems
                ->filter(fn($item) => $item->gallery && $item->gallery->publish_status == 0)
                ->take($settings->max_show)
                ->pluck('gallery');
        }

        // Auto mode: get latest published galleries shown on home
        return InteriorDesignGallery::with(['category', 'projectType', 'project', 'projectStyle', 'emirate'])
            ->where('publish_status', 0)
            ->where('home_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit($settings->max_show)
            ->get();
    }
}
