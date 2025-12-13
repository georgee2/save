<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectFloor;
use App\Models\ProjectFloorAmenity;
use App\Models\Amenity;

class ProjectFloorAmenityController extends Controller
{
    /**
     * Get available amenities for floor (AJAX)
     */
    public function getAvailableAmenities($projectId, $floorId)
    {
        try {
            // Get all active amenities
            $amenities = Amenity::whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            // Get already added amenity IDs
            $addedAmenityIds = ProjectFloorAmenity::where('floor_id', $floorId)
                ->whereNull('deleted_at')
                ->pluck('amenity_id')
                ->toArray();
            
            // Filter out already added amenities
            $availableAmenities = $amenities->whereNotIn('id', $addedAmenityIds)->values();
            
            return response()->json([
                'success' => true,
                'amenities' => $availableAmenities
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created amenity (AJAX)
     */
    public function store(Request $request, $projectId, $floorId)
    {
        try {
            $request->validate([
                'amenity_id' => 'required|exists:amenities,id',
            ]);
            
            // Check if already exists
            $exists = ProjectFloorAmenity::where('floor_id', $floorId)
                ->where('amenity_id', $request->amenity_id)
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This amenity is already added to this floor!'
                ], 422);
            }
            
            ProjectFloorAmenity::create([
                'project_id' => $projectId,
                'floor_id' => $floorId,
                'amenity_id' => $request->amenity_id,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Amenity added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Soft delete the amenity (AJAX)
     */
    public function destroy($projectId, $floorId, $id)
    {
        try {
            $floorAmenity = ProjectFloorAmenity::findOrFail($id);
            $floorAmenity->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Amenity removed successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Restore trashed amenity (AJAX)
     */
    public function restore($projectId, $floorId, $id)
    {
        try {
            $floorAmenity = ProjectFloorAmenity::withTrashed()->findOrFail($id);
            $floorAmenity->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Amenity restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

