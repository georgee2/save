<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use App\Models\Offer;
use App\Models\Project;
use App\Models\InteriorDesignGallery;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\InteriorCategory;
use App\Models\Service;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title_english',
        'title_arabic',
        'description_english',
        'description_arabic',
        'url',
        'route_name',
        'route_params',
        'link_target',
        'icon',
        'icon_type',
        'css_class',
        'item_type',
        'query_source',
        'query_category_ids',
        'query_subcategory_ids',
        'query_type',
        'query_options',
        'show_children',
        'max_children',
        'service_id', // For single service selection
        'is_active',
        'is_visible_desktop',
        'is_visible_mobile',
        'requires_auth',
        'requires_guest',
        'permission',
        'order',
        'depth',
    ];

    protected $casts = [
        'route_params' => 'array',
        'query_category_ids' => 'array',
        'query_subcategory_ids' => 'array',
        'query_options' => 'array',
        'show_children' => 'boolean',
        'is_active' => 'boolean',
        'is_visible_desktop' => 'boolean',
        'is_visible_mobile' => 'boolean',
        'requires_auth' => 'boolean',
        'requires_guest' => 'boolean',
    ];

    /**
     * Item type constants
     */
    const TYPE_STATIC = 'static';
    const TYPE_DYNAMIC_SERVICES = 'dynamic_services';
    const TYPE_DYNAMIC_OFFERS = 'dynamic_offers';
    const TYPE_DYNAMIC_PROJECTS = 'dynamic_projects';
    const TYPE_DYNAMIC_NEWS = 'dynamic_news';
    const TYPE_DYNAMIC_QUERY = 'dynamic_query'; // Custom query from categories
    const TYPE_CATEGORY_WITH_SUBS = 'category_with_subs'; // Single category with subcategories as children
    const TYPE_DIVIDER = 'divider';
    const TYPE_HEADER = 'header';
    
    /**
     * Query source constants
     */
    const QUERY_SOURCE_OFFERS = 'offers';
    const QUERY_SOURCE_PROJECTS = 'projects';
    const QUERY_SOURCE_INTERIOR = 'interior';

    /**
     * Get the menu this item belongs to
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get child menu items
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Get all child menu items (including inactive)
     */
    public function allChildren(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the service associated with this menu item (for single service selection)
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
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
     * Get the resolved URL for this menu item
     */
    public function getUrl(): ?string
    {
        // For dividers and headers, no URL
        if (in_array($this->item_type, [self::TYPE_DIVIDER, self::TYPE_HEADER])) {
            return null;
        }

        // For dynamic_services with a specific service selected:
        // Link directly to that service page
        if ($this->item_type === self::TYPE_DYNAMIC_SERVICES && $this->service_id) {
            if ($this->url) {
                return $this->url;
            }
            try {
                $service = $this->service ?? Service::find($this->service_id);
                if ($service && Route::has('services.show')) {
                    return route('services.show', $service->slug);
                }
            } catch (\Exception $e) {
                // Route generation failed
            }
        }

        // For dynamic_query items:
        // - If show_children is enabled: return null so menu acts as dropdown parent
        // - If show_children is disabled: generate direct URL to category/subcategory page
        if ($this->item_type === self::TYPE_DYNAMIC_QUERY) {
            if ($this->show_children) {
                // Show as dropdown - return custom URL if set, otherwise null
                return $this->url ?: null;
            } else {
                // Show as direct link - custom URL takes priority
                if ($this->url) {
                    return $this->url;
                }
                // Generate direct URL to the first category or subcategory
                return $this->generateDynamicQueryUrl();
            }
        }

        // For category_with_subs items:
        // Parent links to category page, children are subcategories
        if ($this->item_type === self::TYPE_CATEGORY_WITH_SUBS) {
            return $this->generateCategoryWithSubsUrl();
        }

        // If route name is set, generate URL from route
        if ($this->route_name) {
            try {
                $params = $this->route_params ?? [];
                if (Route::has($this->route_name)) {
                    return route($this->route_name, $params);
                }
            } catch (\Exception $e) {
                // Route generation failed, fall back to URL
            }
        }

        // Return the direct URL or null
        return $this->url;
    }

    /**
     * Generate URL for dynamic_query items based on selected categories/subcategories
     * Redirects directly to the existing category/subcategory pages
     */
    protected function generateDynamicQueryUrl(): ?string
    {
        $categoryIds = $this->query_category_ids ?? [];
        $subcategoryIds = $this->query_subcategory_ids ?? [];

        try {
            switch ($this->query_source) {
                case self::QUERY_SOURCE_OFFERS:
                    // If subcategories selected, go to first subcategory page
                    if (!empty($subcategoryIds)) {
                        $subcategory = OfferSubCategory::find($subcategoryIds[0]);
                        if ($subcategory && Route::has('offers.subcategory')) {
                            return route('offers.subcategory', $subcategory->slug);
                        }
                    }
                    // If categories selected, go to first category page
                    if (!empty($categoryIds)) {
                        $category = OfferCategory::find($categoryIds[0]);
                        if ($category && Route::has('offers.category')) {
                            return route('offers.category', $category->slug);
                        }
                    }
                    // Fallback to offers index
                    if (Route::has('offers.index')) {
                        return route('offers.index');
                    }
                    break;

                case self::QUERY_SOURCE_PROJECTS:
                    // If subcategories selected, go to first subcategory page
                    if (!empty($subcategoryIds)) {
                        $subcategory = EngineeringSubCategory::find($subcategoryIds[0]);
                        if ($subcategory && Route::has('subcategory.show')) {
                            return route('subcategory.show', $subcategory->slug);
                        }
                    }
                    // If categories selected, go to first category page
                    if (!empty($categoryIds)) {
                        $category = EngineeringCategory::find($categoryIds[0]);
                        if ($category && Route::has('category.show')) {
                            return route('category.show', $category->slug);
                        }
                    }
                    // Fallback to projects index
                    if (Route::has('projects.index')) {
                        return route('projects.index');
                    }
                    break;

                case self::QUERY_SOURCE_INTERIOR:
                    // If categories selected, go to first category page
                    if (!empty($categoryIds)) {
                        $category = InteriorCategory::find($categoryIds[0]);
                        if ($category && Route::has('interior.category')) {
                            return route('interior.category', $category->slug ?? $category->id);
                        }
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Route generation failed
        }

        return null;
    }

    /**
     * Generate URL for category_with_subs items - links to the category page
     */
    protected function generateCategoryWithSubsUrl(): ?string
    {
        $categoryIds = $this->query_category_ids ?? [];
        
        if (empty($categoryIds)) {
            return null;
        }

        $categoryId = is_array($categoryIds) ? $categoryIds[0] : $categoryIds;

        try {
            switch ($this->query_source) {
                case self::QUERY_SOURCE_OFFERS:
                    $category = OfferCategory::find($categoryId);
                    if ($category && Route::has('offers.category')) {
                        return route('offers.category', $category->slug);
                    }
                    break;

                case self::QUERY_SOURCE_PROJECTS:
                    $category = EngineeringCategory::find($categoryId);
                    if ($category && Route::has('category.show')) {
                        return route('category.show', $category->slug);
                    }
                    break;

                case self::QUERY_SOURCE_INTERIOR:
                    $category = InteriorCategory::find($categoryId);
                    if ($category && Route::has('interior.category')) {
                        return route('interior.category', $category->slug ?? $category->id);
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Route generation failed
        }

        return null;
    }

    /**
     * Check if this is a category_with_subs item
     */
    public function isCategoryWithSubs(): bool
    {
        return $this->item_type === self::TYPE_CATEGORY_WITH_SUBS && !empty($this->query_source) && !empty($this->query_category_ids);
    }

    /**
     * Get subcategories for category_with_subs type
     * Returns subcategories of the selected category as menu children
     * Only returns subcategories that have at least one published item
     */
    public function getCategorySubcategories(): \Illuminate\Support\Collection
    {
        if (!$this->isCategoryWithSubs()) {
            return collect();
        }

        $categoryIds = $this->query_category_ids ?? [];
        if (empty($categoryIds)) {
            return collect();
        }

        $categoryId = is_array($categoryIds) ? $categoryIds[0] : $categoryIds;

        switch ($this->query_source) {
            case self::QUERY_SOURCE_OFFERS:
                // Get subcategories that have at least one published offer
                $query = OfferSubCategory::where('category_id', $categoryId)
                    ->whereNull('deleted_at')
                    ->whereHas('offers', function($q) {
                        $q->where('publish_status', 0)->whereNull('deleted_at');
                    })
                    ->orderBy('title_english');
                
                $subcategories = $query->get();
                
                $subcategories->each(function($item) {
                    $item->is_subcategory = true;
                    $item->route_name = 'offers.subcategory';
                    $item->menu_url = Route::has('offers.subcategory') ? route('offers.subcategory', $item->slug) : null;
                });
                
                // Apply max_children limit after filtering
                if ($this->max_children && $subcategories->count() > $this->max_children) {
                    $subcategories = $subcategories->take($this->max_children);
                }
                
                return $subcategories;

            case self::QUERY_SOURCE_PROJECTS:
                // Get subcategories that have at least one published project
                $query = EngineeringSubCategory::where('category_id', $categoryId)
                    ->whereNull('deleted_at')
                    ->whereHas('projects', function($q) {
                        $q->where('publish_status', 0)->whereNull('deleted_at');
                    })
                    ->orderBy('title_english');
                
                $subcategories = $query->get();
                
                $subcategories->each(function($item) {
                    $item->is_subcategory = true;
                    $item->route_name = 'subcategory.show';
                    $item->menu_url = Route::has('subcategory.show') ? route('subcategory.show', $item->slug) : null;
                });
                
                // Apply max_children limit after filtering
                if ($this->max_children && $subcategories->count() > $this->max_children) {
                    $subcategories = $subcategories->take($this->max_children);
                }
                
                return $subcategories;

            case self::QUERY_SOURCE_INTERIOR:
                // Interior design doesn't have subcategories
                return collect();

            default:
                return collect();
        }
    }

    /**
     * Check if this item has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Check if this is a dynamic item
     */
    public function isDynamic(): bool
    {
        return in_array($this->item_type, [
            self::TYPE_DYNAMIC_SERVICES,
            self::TYPE_DYNAMIC_OFFERS,
            self::TYPE_DYNAMIC_PROJECTS,
            self::TYPE_DYNAMIC_NEWS,
        ]);
    }

    /**
     * Get dynamic children based on item type
     */
    public function getDynamicChildren(): \Illuminate\Support\Collection
    {
        if (!$this->isDynamic() || !$this->show_children) {
            return collect();
        }

        switch ($this->item_type) {
            case self::TYPE_DYNAMIC_SERVICES:
                return $this->getDynamicServices();
            case self::TYPE_DYNAMIC_OFFERS:
                return $this->getDynamicOffers();
            case self::TYPE_DYNAMIC_PROJECTS:
                return $this->getDynamicProjects();
            case self::TYPE_DYNAMIC_NEWS:
                return $this->getDynamicNews();
            default:
                return collect();
        }
    }

    /**
     * Get services for dynamic menu
     */
    protected function getDynamicServices(): \Illuminate\Support\Collection
    {
        $query = Service::with(['subServices' => function($q) {
            $q->where('publish_status', 0)->orderBy('created_at', 'ASC');
        }])
            ->where('is_sub_service', 0)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'ASC');

        if ($this->max_children) {
            $query->limit($this->max_children);
        }

        return $query->get();
    }

    /**
     * Get offer categories for dynamic menu
     */
    protected function getDynamicOffers(): \Illuminate\Support\Collection
    {
        $query = OfferCategory::with(['subCategories' => function($q) {
            $q->whereNull('deleted_at')->orderBy('created_at', 'DESC');
        }])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC');

        if ($this->max_children) {
            $query->limit($this->max_children);
        }

        return $query->get();
    }

    /**
     * Get project categories for dynamic menu
     */
    protected function getDynamicProjects(): \Illuminate\Support\Collection
    {
        $query = EngineeringCategory::with(['subCategories' => function($q) {
            $q->whereNull('deleted_at')->orderBy('created_at', 'DESC');
        }])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC');

        if ($this->max_children) {
            $query->limit($this->max_children);
        }

        return $query->get();
    }

    /**
     * Get news categories for dynamic menu
     */
    protected function getDynamicNews(): \Illuminate\Support\Collection
    {
        return collect(\DB::table('newscategories')
            ->select('id', 'name_english', 'name_arabic')
            ->whereNull('deleted_at')
            ->whereExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('news')
                    ->whereColumn('news.category_code', 'newscategories.id');
            })
            ->orderBy('name_english', 'ASC')
            ->when($this->max_children, function($q) {
                return $q->limit($this->max_children);
            })
            ->get());
    }

    /**
     * Check if item should be visible for current user/context
     */
    public function isVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Check auth requirements
        if ($this->requires_auth && !auth()->check()) {
            return false;
        }

        if ($this->requires_guest && auth()->check()) {
            return false;
        }

        // Check permission if set
        if ($this->permission && auth()->check()) {
            // Assuming you have a permission system
            // return auth()->user()->can($this->permission);
        }

        return true;
    }

    /**
     * Get icon HTML
     */
    public function getIconHtml(): string
    {
        if (!$this->icon) {
            return '';
        }

        switch ($this->icon_type) {
            case 'image':
                return '<img src="' . asset($this->icon) . '" alt="" class="menu-icon" style="width: 18px; height: 18px; object-fit: contain;">';
            case 'svg':
                return $this->icon; // Assuming SVG code is stored
            case 'fontawesome':
            default:
                return '<i class="' . $this->icon . '"></i>';
        }
    }

    /**
     * Scope to get desktop visible items
     */
    public function scopeDesktop($query)
    {
        return $query->where('is_visible_desktop', true);
    }

    /**
     * Scope to get mobile visible items
     */
    public function scopeMobile($query)
    {
        return $query->where('is_visible_mobile', true);
    }

    /**
     * Scope to get root items (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check if this is a dynamic query item
     */
    public function isDynamicQuery(): bool
    {
        return $this->item_type === self::TYPE_DYNAMIC_QUERY && !empty($this->query_source);
    }

    /**
     * Get query results based on configured filters
     * Returns CATEGORIES/SUBCATEGORIES (not direct items) for menu display
     * If subcategories are selected: returns those subcategories
     * If categories are selected: returns those categories with their subcategories
     */
    public function getQueryResults(): \Illuminate\Support\Collection
    {
        if (!$this->isDynamicQuery()) {
            return collect();
        }

        switch ($this->query_source) {
            case self::QUERY_SOURCE_OFFERS:
                return $this->getOffersCategoriesForMenu();
            case self::QUERY_SOURCE_PROJECTS:
                return $this->getProjectsCategoriesForMenu();
            case self::QUERY_SOURCE_INTERIOR:
                return $this->getInteriorCategoriesForMenu();
            default:
                return collect();
        }
    }

    /**
     * Get offer categories/subcategories for menu display
     * If subcategories selected: return subcategories as menu items
     * If categories selected: return categories with their subcategories
     */
    protected function getOffersCategoriesForMenu(): \Illuminate\Support\Collection
    {
        // If specific subcategories are selected, return them directly
        if (!empty($this->query_subcategory_ids) && is_array($this->query_subcategory_ids)) {
            $query = OfferSubCategory::whereIn('id', $this->query_subcategory_ids)
                ->whereNull('deleted_at')
                ->with('category')
                ->orderBy('title_english');
            
            if ($this->max_children) {
                $query->limit($this->max_children);
            }
            
            $subcategories = $query->get();
            
            // Mark these as subcategories for the view to know how to render
            $subcategories->each(function($item) {
                $item->is_subcategory = true;
                $item->route_name = 'offers.subcategory';
            });
            
            return $subcategories;
        }
        
        // If categories are selected, return categories with their subcategories
        if (!empty($this->query_category_ids) && is_array($this->query_category_ids)) {
            $query = OfferCategory::whereIn('id', $this->query_category_ids)
                ->whereNull('deleted_at')
                ->with(['subCategories' => function($q) {
                    $q->whereNull('deleted_at')->orderBy('title_english');
                }])
                ->orderBy('title_english');
            
            if ($this->max_children) {
                $query->limit($this->max_children);
            }
            
            $categories = $query->get();
            
            // Mark these as categories for the view
            $categories->each(function($item) {
                $item->is_subcategory = false;
                $item->route_name = 'offers.category';
            });
            
            return $categories;
        }
        
        return collect();
    }

    /**
     * Get project categories/subcategories for menu display
     */
    protected function getProjectsCategoriesForMenu(): \Illuminate\Support\Collection
    {
        // If specific subcategories are selected, return them directly
        if (!empty($this->query_subcategory_ids) && is_array($this->query_subcategory_ids)) {
            $query = EngineeringSubCategory::whereIn('id', $this->query_subcategory_ids)
                ->whereNull('deleted_at')
                ->with('category')
                ->orderBy('title_english');
            
            if ($this->max_children) {
                $query->limit($this->max_children);
            }
            
            $subcategories = $query->get();
            
            $subcategories->each(function($item) {
                $item->is_subcategory = true;
                $item->route_name = 'subcategory.show';
            });
            
            return $subcategories;
        }
        
        // If categories are selected, return categories with their subcategories
        if (!empty($this->query_category_ids) && is_array($this->query_category_ids)) {
            $query = EngineeringCategory::whereIn('id', $this->query_category_ids)
                ->whereNull('deleted_at')
                ->with(['subCategories' => function($q) {
                    $q->whereNull('deleted_at')->orderBy('title_english');
                }])
                ->orderBy('title_english');
            
            if ($this->max_children) {
                $query->limit($this->max_children);
            }
            
            $categories = $query->get();
            
            $categories->each(function($item) {
                $item->is_subcategory = false;
                $item->route_name = 'category.show';
            });
            
            return $categories;
        }
        
        return collect();
    }

    /**
     * Get interior categories for menu display (interior has no subcategories)
     * If no specific categories selected, returns ALL active categories
     */
    protected function getInteriorCategoriesForMenu(): \Illuminate\Support\Collection
    {
        $query = InteriorCategory::whereNull('deleted_at')
            ->orderBy('title_english');
        
        // If specific categories are selected, filter by them
        if (!empty($this->query_category_ids) && is_array($this->query_category_ids)) {
            $query->whereIn('id', $this->query_category_ids);
        }
        
        if ($this->max_children) {
            $query->limit($this->max_children);
        }
        
        $categories = $query->get();
        
        $categories->each(function($item) {
            $item->is_subcategory = false;
            $item->route_name = 'interior.category';
        });
        
        return $categories;
    }

    /**
     * Get selected categories info for display
     */
    public function getSelectedCategoriesInfo(): array
    {
        if (!$this->isDynamicQuery() || empty($this->query_category_ids)) {
            return [];
        }

        $categories = [];

        switch ($this->query_source) {
            case self::QUERY_SOURCE_OFFERS:
                $categories = OfferCategory::whereIn('id', $this->query_category_ids)
                    ->whereNull('deleted_at')
                    ->get(['id', 'title_english', 'title_arabic'])
                    ->toArray();
                break;
            case self::QUERY_SOURCE_PROJECTS:
                $categories = EngineeringCategory::whereIn('id', $this->query_category_ids)
                    ->whereNull('deleted_at')
                    ->get(['id', 'title_english', 'title_arabic'])
                    ->toArray();
                break;
            case self::QUERY_SOURCE_INTERIOR:
                $categories = InteriorCategory::whereIn('id', $this->query_category_ids)
                    ->whereNull('deleted_at')
                    ->get(['id', 'title_english', 'title_arabic'])
                    ->toArray();
                break;
        }

        return $categories;
    }

    /**
     * Get selected subcategories info for display
     */
    public function getSelectedSubcategoriesInfo(): array
    {
        if (!$this->isDynamicQuery() || empty($this->query_subcategory_ids)) {
            return [];
        }

        $subcategories = [];

        switch ($this->query_source) {
            case self::QUERY_SOURCE_OFFERS:
                $subcategories = OfferSubCategory::whereIn('id', $this->query_subcategory_ids)
                    ->whereNull('deleted_at')
                    ->get(['id', 'title_english', 'title_arabic'])
                    ->toArray();
                break;
            case self::QUERY_SOURCE_PROJECTS:
                $subcategories = EngineeringSubCategory::whereIn('id', $this->query_subcategory_ids)
                    ->whereNull('deleted_at')
                    ->get(['id', 'title_english', 'title_arabic'])
                    ->toArray();
                break;
        }

        return $subcategories;
    }
}
