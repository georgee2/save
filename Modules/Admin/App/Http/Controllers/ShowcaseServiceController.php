<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use App\Models\Service;
use App\Models\ShowcaseService;
use Illuminate\Support\Facades\DB;

class ShowcaseServiceController extends Controller
{
    /**
     * Get available services for a showcase
     */
    public function getAvailableServices($showcaseId)
    {
        try {
            $showcase = Showcase::findOrFail($showcaseId);
            
            // Get IDs of services already attached to this showcase
            $attachedServiceIds = DB::table('showcase_service')
                ->where('showcase_id', $showcaseId)
                ->pluck('service_id')
                ->toArray();
            
            // Get all published services that are not yet attached
            // Note: publish_status = 0 means "Published"
            // Using DB query for better performance and explicit deleted_at check
            $query = DB::table('services')
                ->where('publish_status', 0)
                ->whereNull('deleted_at')
                ->select('id', 'title_english', 'title_arabic')
                ->orderBy('title_english');
            
            // Only add whereNotIn if there are attached services
            if (!empty($attachedServiceIds)) {
                $query->whereNotIn('id', $attachedServiceIds);
            }
            
            $availableServices = $query->get();
            
            return response()->json($availableServices);
        } catch (\Exception $e) {
            \Log::error('Error loading available services: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load services',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a new service relation
     */
    public function store(Request $request, $showcaseId)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id'
        ]);
        
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Check if already exists
        $exists = ShowcaseService::where('showcase_id', $showcaseId)
            ->where('service_id', $request->service_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This service is already added to the showcase.'
            ], 422);
        }
        
        // Attach the service
        $showcase->services()->attach($request->service_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Service added successfully!'
        ]);
    }
    
    /**
     * Remove a service relation
     */
    public function destroy($showcaseId, $id)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        $showcaseService = ShowcaseService::where('showcase_id', $showcaseId)
            ->where('id', $id)
            ->firstOrFail();
        
        // Detach the service
        $showcase->services()->detach($showcaseService->service_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Service removed successfully!'
        ]);
    }
}

