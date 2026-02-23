<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeInteriorSetting;
use App\Models\HomeInteriorItem;
use App\Models\InteriorDesignGallery;

class HomeInteriorSettingController extends Controller
{
    /**
     * Display the home interior settings page
     */
    public function index()
    {
        $settings = HomeInteriorSetting::getSettings();
        $selectedCount = HomeInteriorItem::count();
        $hasManualSelection = $selectedCount > 0;
        
        return view('admin::home-interior-settings.index', compact('settings', 'selectedCount', 'hasManualSelection'));
    }

    /**
     * Show the image selection page
     */
    public function selectImages()
    {
        $settings = HomeInteriorSetting::getSettings();
        
        // Get all published interior galleries
        $availableGalleries = InteriorDesignGallery::with('category')
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get selected gallery IDs in order
        $selectedItems = HomeInteriorItem::with('gallery')
            ->orderBy('ordering', 'asc')
            ->get();
        
        $selectedGalleryIds = $selectedItems->pluck('interior_gallery_id')->toArray();
        
        return view('admin::home-interior-settings.select-images', compact(
            'settings', 
            'availableGalleries', 
            'selectedItems',
            'selectedGalleryIds'
        ));
    }

    /**
     * Save selected images via AJAX
     */
    public function saveImages(Request $request)
    {
        $galleryIds = $request->input('galleries', []);
        
        // Delete existing selections
        HomeInteriorItem::truncate();
        
        // Add new selections
        foreach ($galleryIds as $index => $galleryId) {
            HomeInteriorItem::create([
                'interior_gallery_id' => $galleryId,
                'ordering' => $index + 1,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Images saved successfully!',
            'count' => count($galleryIds),
        ]);
    }

    /**
     * Clear all selected images (switch to auto mode)
     */
    public function clearImages()
    {
        HomeInteriorItem::truncate();
        
        return response()->json([
            'success' => true,
            'message' => 'Switched to automatic mode (latest images).',
        ]);
    }

    /**
     * Update settings via AJAX
     */
    public function update(Request $request)
    {
        $settings = HomeInteriorSetting::getSettings();
        
        $data = $request->validate([
            'max_show' => 'required|integer|min:1|max:50',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $settings->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully!',
        ]);
    }

    /**
     * Update ordering via AJAX (for selected images)
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            HomeInteriorItem::where('interior_gallery_id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }
}
