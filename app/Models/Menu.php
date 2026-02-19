<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title_english',
        'title_arabic',
        'slug',
        'description_english',
        'description_arabic',
        'location',
        'is_primary',
        'is_active',
        'is_deletable',
        'order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'is_deletable' => 'boolean',
    ];

    /**
     * Get all menu items for this menu
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    /**
     * Get only root level menu items (no parent)
     */
    public function rootItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Get active menu items
     */
    public function activeItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Get the primary menu (only if active)
     */
    public static function getPrimaryMenu(): ?self
    {
        return self::where('is_primary', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get the header menu with fallback logic:
     * 1. If primary menu exists and is active, use it
     * 2. If primary menu is inactive, use the last active custom menu (by updated_at)
     * 3. If no active menus, return null
     */
    public static function getHeaderMenu(): ?self
    {
        // First, try to get the active primary menu
        $primaryMenu = self::where('is_primary', true)
            ->where('is_active', true)
            ->first();

        if ($primaryMenu) {
            return $primaryMenu;
        }

        // If primary menu is not active, get the last active custom menu
        // Order by updated_at DESC to get the most recently updated active menu
        return self::where('is_primary', false)
            ->where('is_active', true)
            ->where('location', 'header') // Only menus designated for header location
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    /**
     * Get all active menus for a specific location
     */
    public static function getActiveMenusByLocation(string $location): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('location', $location)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get the last active custom menu (most recently updated)
     */
    public static function getLastActiveCustomMenu(?string $location = null): ?self
    {
        $query = self::where('is_primary', false)
            ->where('is_active', true);

        if ($location) {
            $query->where('location', $location);
        }

        return $query->orderBy('updated_at', 'desc')->first();
    }

    /**
     * Get menu by location
     */
    public static function getByLocation(string $location): ?self
    {
        return self::where('location', $location)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get menu by slug
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get footer Quick Links menu
     */
    public static function getFooterQuickLinksMenu(): ?self
    {
        return self::where('location', 'footer_quick_links')
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get footer Company menu
     */
    public static function getFooterCompanyMenu(): ?self
    {
        return self::where('location', 'footer_company')
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all footer menus
     */
    public static function getFooterMenus(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('location', 'like', 'footer_%')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get all active menus
     */
    public static function getAllActive(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('is_active', true)
            ->orderBy('is_primary', 'desc') // Primary first
            ->orderBy('order')
            ->get();
    }

    /**
     * Get title based on current locale
     */
    public function getTitle(): string
    {
        if (app()->getLocale() === 'ar' && $this->title_arabic) {
            return $this->title_arabic;
        }
        return $this->title_english;
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
     * Check if menu can be deleted
     */
    public function canBeDeleted(): bool
    {
        return $this->is_deletable && !$this->is_primary;
    }

    /**
     * Get hierarchical menu items (nested structure) - for frontend (active only)
     */
    public function getHierarchicalItems(): \Illuminate\Support\Collection
    {
        $items = $this->items()
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();

        return $this->buildTree($items);
    }

    /**
     * Get all hierarchical menu items (nested structure) - for admin (including inactive)
     */
    public function getAllHierarchicalItems(): \Illuminate\Support\Collection
    {
        $items = $this->items()
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();

        return $this->buildTree($items);
    }

    /**
     * Build nested tree from flat collection
     */
    protected function buildTree($items, $parentId = null): \Illuminate\Support\Collection
    {
        $branch = collect();

        foreach ($items as $item) {
            if ($item->parent_id === $parentId) {
                $children = $this->buildTree($items, $item->id);
                if ($children->isNotEmpty()) {
                    $item->setRelation('children', $children);
                }
                $branch->push($item);
            }
        }

        return $branch;
    }
}
