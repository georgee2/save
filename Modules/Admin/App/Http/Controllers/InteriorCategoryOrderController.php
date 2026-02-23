<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\InteriorCategory;
use App\Models\InteriorDesignGallery;
use Illuminate\Support\Facades\DB;

class InteriorCategoryOrderController extends Controller
{
    /**
     * Display the category ordering page
     */
    public function index()
    {
        $categories = InteriorCategory::withCount(['galleries' => function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        return view('admin::interior-category-order.index', compact('categories'));
    }

    /**
     * Update category ordering via AJAX
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            DB::table('interior_categories')
                ->where('id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Category order updated successfully!',
        ]);
    }

    /**
     * Toggle category publish status
     */
    public function togglePublish($id)
    {
        $category = InteriorCategory::findOrFail($id);
        
        // Toggle publish_status (0 = published, 1 = unpublished)
        $newStatus = $category->publish_status == 0 ? 1 : 0;
        
        DB::table('interior_categories')
            ->where('id', $id)
            ->update(['publish_status' => $newStatus]);
        
        return response()->json([
            'success' => true,
            'publish_status' => $newStatus,
            'message' => $newStatus == 0 ? 'Category published!' : 'Category unpublished!',
        ]);
    }

    /**
     * Show category images for ordering
     */
    public function categoryImages($id)
    {
        $category = InteriorCategory::findOrFail($id);
        
        $galleries = InteriorDesignGallery::where('category_id', $id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        return view('admin::interior-category-order.category-images', compact('category', 'galleries'));
    }

    /**
     * Update images ordering within a category
     */
    public function updateCategoryImagesOrder(Request $request, $id)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            InteriorDesignGallery::where('id', $order['id'])
                ->where('category_id', $id)
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Image order updated successfully!',
        ]);
    }
}
