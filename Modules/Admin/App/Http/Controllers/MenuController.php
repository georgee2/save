<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuSetting;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\InteriorCategory;
use App\Models\Service;

class MenuController extends Controller
{
    protected $menu;
    protected $menuItem;

    public function __construct(Menu $menu, MenuItem $menuItem)
    {
        $this->menu = $menu;
        $this->menuItem = $menuItem;
    }

    /**
     * Display a listing of menus
     */
    public function index()
    {
        $menus = Menu::withCount('items')
            ->orderBy('is_primary', 'desc')
            ->orderBy('order')
            ->get();
            
        return view('admin::menus.index', compact('menus'));
    }

    /**
     * Display the user guide
     */
    public function guide()
    {
        return view('admin::menus.guide');
    }

    /**
     * Show the form for creating a new menu
     */
    public function create()
    {
        return view('admin::menus.create');
    }

    /**
     * Store a newly created menu
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'nullable|string|max:100',
            'slug' => 'required|string|max:100|unique:menus,slug',
            'description_english' => 'nullable|string|max:500',
            'description_arabic' => 'nullable|string|max:500',
            'location' => 'required|string|max:50',
            'is_active' => 'required|in:0,1',
        ]);

        $data['is_primary'] = false;
        $data['is_deletable'] = true;
        $data['order'] = Menu::max('order') + 1;

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu created successfully!');
    }

    /**
     * Show menu with its items for editing
     */
    public function show($id)
    {
        $menu = Menu::with(['items' => function($query) {
            $query->whereNull('parent_id')->orderBy('order');
        }])->findOrFail($id);
        
        $menuItems = $menu->getAllHierarchicalItems();
        
        return view('admin::menus.show', compact('menu', 'menuItems'));
    }

    /**
     * Show the form for editing the specified menu
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin::menus.edit', compact('menu'));
    }

    /**
     * Update the specified menu
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'nullable|string|max:100',
            'slug' => 'required|string|max:100|unique:menus,slug,' . $id,
            'description_english' => 'nullable|string|max:500',
            'description_arabic' => 'nullable|string|max:500',
            'location' => 'required|string|max:50',
            'is_active' => 'required|in:0,1',
        ]);

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully!');
    }

    /**
     * Toggle menu active status
     */
    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();
        
        $statusText = $menu->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Menu {$statusText} successfully!");
    }

    /**
     * Soft delete the specified menu
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Check if menu can be deleted
        if (!$menu->canBeDeleted()) {
            return redirect()->back()->with('error', 'This menu cannot be deleted. It is a primary or system menu.');
        }
        
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully!');
    }

    /**
     * Display trashed menus
     */
    public function trashed()
    {
        $menus = Menu::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin::menus.trashed', compact('menus'));
    }

    /**
     * Restore a trashed menu
     */
    public function restore($id)
    {
        $menu = Menu::withTrashed()->findOrFail($id);
        $menu->restore();

        return redirect()->route('admin.menu.trashed')->with('success', 'Menu restored successfully!');
    }

    // =====================================================
    // MENU ITEMS MANAGEMENT
    // =====================================================

    /**
     * Show menu items management page
     */
    public function items($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $menuItems = $menu->getAllHierarchicalItems();
        $allItems = MenuItem::where('menu_id', $menuId)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();
        
        return view('admin::menus.items', compact('menu', 'menuItems', 'allItems'));
    }

    /**
     * Show the form for creating a new menu item
     */
    public function createItem($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $parentItems = MenuItem::where('menu_id', $menuId)
            ->whereNull('parent_id')
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();
        
        $itemTypes = [
            'static' => 'Static Link',
            'dynamic_services' => 'Dynamic: Services',
            'dynamic_offers' => 'Dynamic: Offer Categories',
            'dynamic_projects' => 'Dynamic: Project Categories',
            'dynamic_news' => 'Dynamic: News Categories',
            'dynamic_query' => 'Dynamic Query: Custom Categories/Subcategories',
            'divider' => 'Divider',
            'header' => 'Section Header',
        ];
        
        $querySources = [
            'offers' => 'Offers',
            'projects' => 'Projects',
            'interior' => 'Interior Design',
        ];
        
        // Get available services for dynamic_services type
        $services = Service::whereNull('deleted_at')
            ->where('publish_status', 0)
            ->orderBy('title_english')
            ->get(['id', 'title_english', 'title_arabic', 'slug']);
        
        return view('admin::menus.item-create', compact('menu', 'parentItems', 'itemTypes', 'querySources', 'services'));
    }

    /**
     * Store a newly created menu item
     */
    public function storeItem(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);
        
        $data = $request->validate([
            'parent_id' => 'nullable|exists:menu_items,id',
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'nullable|string|max:150',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:150',
            'route_params' => 'nullable|string',
            'link_target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'icon_type' => 'required|in:fontawesome,image,svg',
            'css_class' => 'nullable|string|max:200',
            'item_type' => 'required|in:static,dynamic_services,dynamic_offers,dynamic_projects,dynamic_news,dynamic_query,divider,header',
            'service_id' => 'nullable|integer|exists:services,id',
            'query_source' => 'nullable|in:offers,projects,interior',
            'query_category_ids' => 'nullable|array',
            'query_category_ids.*' => 'integer',
            'query_subcategory_ids' => 'nullable|array',
            'query_subcategory_ids.*' => 'integer',
            'query_type' => 'nullable|in:category,subcategory,all',
            'show_children' => 'required|in:0,1',
            'max_children' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
            'is_visible_desktop' => 'required|in:0,1',
            'is_visible_mobile' => 'required|in:0,1',
        ]);

        // Calculate order
        $maxOrder = MenuItem::where('menu_id', $menuId)
            ->where('parent_id', $data['parent_id'] ?? null)
            ->max('order');
        $data['order'] = ($maxOrder ?? 0) + 1;
        
        // Calculate depth
        $data['depth'] = 0;
        if (!empty($data['parent_id'])) {
            $parent = MenuItem::find($data['parent_id']);
            $data['depth'] = $parent ? $parent->depth + 1 : 0;
        }
        
        // Parse route_params if provided
        if (!empty($data['route_params'])) {
            $data['route_params'] = json_decode($data['route_params'], true);
        }
        
        // Handle query filters for dynamic_query type
        if ($data['item_type'] === 'dynamic_query') {
            // Keep the arrays as-is (they will be cast to JSON by Eloquent)
            if (empty($data['query_category_ids'])) {
                $data['query_category_ids'] = null;
            }
            if (empty($data['query_subcategory_ids'])) {
                $data['query_subcategory_ids'] = null;
            }
            // Clear service_id for query type
            $data['service_id'] = null;
        } else if ($data['item_type'] !== 'dynamic_services') {
            // Clear query fields and service_id for non-query/non-service types
            $data['query_source'] = null;
            $data['query_category_ids'] = null;
            $data['query_subcategory_ids'] = null;
            $data['query_type'] = null;
            $data['service_id'] = null;
        } else {
            // dynamic_services - clear query fields but keep service_id
            $data['query_source'] = null;
            $data['query_category_ids'] = null;
            $data['query_subcategory_ids'] = null;
            $data['query_type'] = null;
        }
        
        $data['menu_id'] = $menuId;
        
        MenuItem::create($data);

        return redirect()->route('admin.menu.items', $menuId)->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing a menu item
     */
    public function editItem($menuId, $itemId)
    {
        $menu = Menu::findOrFail($menuId);
        $item = MenuItem::where('menu_id', $menuId)->where('id', $itemId)->firstOrFail();
        
        $parentItems = MenuItem::where('menu_id', $menuId)
            ->whereNull('parent_id')
            ->where('id', '!=', $itemId)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();
        
        $itemTypes = [
            'static' => 'Static Link',
            'dynamic_services' => 'Dynamic: Services',
            'dynamic_offers' => 'Dynamic: Offer Categories',
            'dynamic_projects' => 'Dynamic: Project Categories',
            'dynamic_news' => 'Dynamic: News Categories',
            'dynamic_query' => 'Dynamic Query: Custom Categories/Subcategories',
            'divider' => 'Divider',
            'header' => 'Section Header',
        ];
        
        $querySources = [
            'offers' => 'Offers',
            'projects' => 'Projects',
            'interior' => 'Interior Design',
        ];
        
        // Get selected categories and subcategories info for display
        $selectedCategories = $item->getSelectedCategoriesInfo();
        $selectedSubcategories = $item->getSelectedSubcategoriesInfo();
        
        // Get available services for dynamic_services type
        $services = Service::whereNull('deleted_at')
            ->where('publish_status', 0)
            ->orderBy('title_english')
            ->get(['id', 'title_english', 'title_arabic', 'slug']);
        
        return view('admin::menus.item-edit', compact('menu', 'item', 'parentItems', 'itemTypes', 'querySources', 'selectedCategories', 'selectedSubcategories', 'services'));
    }

    /**
     * Update the specified menu item
     */
    public function updateItem(Request $request, $menuId, $itemId)
    {
        $menu = Menu::findOrFail($menuId);
        $item = MenuItem::where('menu_id', $menuId)->where('id', $itemId)->firstOrFail();
        
        $data = $request->validate([
            'parent_id' => 'nullable|exists:menu_items,id',
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'nullable|string|max:150',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:150',
            'route_params' => 'nullable|string',
            'link_target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'icon_type' => 'required|in:fontawesome,image,svg',
            'css_class' => 'nullable|string|max:200',
            'item_type' => 'required|in:static,dynamic_services,dynamic_offers,dynamic_projects,dynamic_news,dynamic_query,divider,header',
            'service_id' => 'nullable|integer|exists:services,id',
            'query_source' => 'nullable|in:offers,projects,interior',
            'query_category_ids' => 'nullable|array',
            'query_category_ids.*' => 'integer',
            'query_subcategory_ids' => 'nullable|array',
            'query_subcategory_ids.*' => 'integer',
            'query_type' => 'nullable|in:category,subcategory,all',
            'show_children' => 'required|in:0,1',
            'max_children' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
            'is_visible_desktop' => 'required|in:0,1',
            'is_visible_mobile' => 'required|in:0,1',
        ]);
        
        // Clear service_id if not dynamic_services type
        if ($data['item_type'] !== 'dynamic_services') {
            $data['service_id'] = null;
        }
        
        // Recalculate depth if parent changed
        $data['depth'] = 0;
        if (!empty($data['parent_id'])) {
            $parent = MenuItem::find($data['parent_id']);
            $data['depth'] = $parent ? $parent->depth + 1 : 0;
        }
        
        // Parse route_params if provided
        if (!empty($data['route_params'])) {
            $data['route_params'] = json_decode($data['route_params'], true);
        } else {
            $data['route_params'] = null;
        }
        
        // Handle query filters for dynamic_query type
        if ($data['item_type'] === 'dynamic_query') {
            if (empty($data['query_category_ids'])) {
                $data['query_category_ids'] = null;
            }
            if (empty($data['query_subcategory_ids'])) {
                $data['query_subcategory_ids'] = null;
            }
        } else {
            // Clear query fields for non-query types
            $data['query_source'] = null;
            $data['query_category_ids'] = null;
            $data['query_subcategory_ids'] = null;
            $data['query_type'] = null;
        }
        
        $item->update($data);

        return redirect()->route('admin.menu.items', $menuId)->with('success', 'Menu item updated successfully!');
    }

    /**
     * Toggle menu item active status
     */
    public function toggleItemStatus($menuId, $itemId)
    {
        $item = MenuItem::where('menu_id', $menuId)->where('id', $itemId)->firstOrFail();
        $item->is_active = !$item->is_active;
        $item->save();
        
        $statusText = $item->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Menu item {$statusText} successfully!");
    }

    /**
     * Delete a menu item
     */
    public function destroyItem($menuId, $itemId)
    {
        $item = MenuItem::where('menu_id', $menuId)->where('id', $itemId)->firstOrFail();
        $item->delete();

        return redirect()->route('admin.menu.items', $menuId)->with('success', 'Menu item deleted successfully!');
    }

    /**
     * Display trashed menu items
     */
    public function trashedItems($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $items = MenuItem::where('menu_id', $menuId)
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
            
        return view('admin::menus.items-trashed', compact('menu', 'items'));
    }

    /**
     * Restore a trashed menu item
     */
    public function restoreItem($menuId, $itemId)
    {
        $item = MenuItem::where('menu_id', $menuId)->withTrashed()->findOrFail($itemId);
        $item->restore();

        return redirect()->route('admin.menu.items.trashed', $menuId)->with('success', 'Menu item restored successfully!');
    }

    /**
     * Update menu items order via AJAX (drag and drop)
     */
    public function updateItemsOrder(Request $request, $menuId)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.order' => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|integer|exists:menu_items,id',
            'items.*.depth' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $itemData) {
            MenuItem::where('id', $itemData['id'])
                ->where('menu_id', $menuId)
                ->update([
                    'order' => $itemData['order'],
                    'parent_id' => $itemData['parent_id'] ?? null,
                    'depth' => $itemData['depth'],
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Menu order updated successfully!']);
    }

    // =====================================================
    // MENU SETTINGS
    // =====================================================

    /**
     * Show menu settings page
     */
    public function settings()
    {
        $settings = MenuSetting::orderBy('group')->orderBy('key')->get();
        $groupedSettings = $settings->groupBy('group');
        
        return view('admin::menus.settings', compact('groupedSettings'));
    }

    /**
     * Update menu settings
     */
    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string',
        ]);

        foreach ($data['settings'] as $key => $value) {
            $setting = MenuSetting::where('key', $key)->first();
            if ($setting) {
                // Handle boolean values
                if ($setting->type === 'boolean') {
                    $value = $value === '1' || $value === 'true' ? 'true' : 'false';
                }
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Menu settings updated successfully!');
    }

    // =====================================================
    // AJAX ENDPOINTS FOR CATEGORY/SUBCATEGORY SELECTION
    // =====================================================

    /**
     * Get categories by source (AJAX)
     */
    public function getCategories(Request $request)
    {
        $source = $request->get('source');
        $categories = [];

        switch ($source) {
            case 'offers':
                $categories = OfferCategory::whereNull('deleted_at')
                    ->orderBy('title_english')
                    ->get(['id', 'title_english', 'title_arabic']);
                break;
            case 'projects':
                $categories = EngineeringCategory::whereNull('deleted_at')
                    ->orderBy('title_english')
                    ->get(['id', 'title_english', 'title_arabic']);
                break;
            case 'interior':
                $categories = InteriorCategory::whereNull('deleted_at')
                    ->orderBy('title_english')
                    ->get(['id', 'title_english', 'title_arabic']);
                break;
        }

        return response()->json([
            'success' => true,
            'categories' => $categories,
            'has_subcategories' => $source !== 'interior', // Interior has no subcategories
        ]);
    }

    /**
     * Get subcategories by category IDs (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $source = $request->get('source');
        $categoryIds = $request->get('category_ids', []);
        
        if (!is_array($categoryIds)) {
            $categoryIds = [$categoryIds];
        }
        
        $subcategories = [];

        switch ($source) {
            case 'offers':
                $query = OfferSubCategory::whereNull('deleted_at')
                    ->orderBy('title_english');
                    
                if (!empty($categoryIds)) {
                    $query->whereIn('category_id', $categoryIds);
                }
                
                $subcategories = $query->get(['id', 'title_english', 'title_arabic', 'category_id']);
                break;
                
            case 'projects':
                $query = EngineeringSubCategory::whereNull('deleted_at')
                    ->orderBy('title_english');
                    
                if (!empty($categoryIds)) {
                    $query->whereIn('category_id', $categoryIds);
                }
                
                $subcategories = $query->get(['id', 'title_english', 'title_arabic', 'category_id']);
                break;
                
            case 'interior':
                // Interior has no subcategories
                $subcategories = [];
                break;
        }

        return response()->json([
            'success' => true,
            'subcategories' => $subcategories,
        ]);
    }
}
