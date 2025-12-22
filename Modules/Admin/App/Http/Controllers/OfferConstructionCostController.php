<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OfferConstructionCost;
use App\Models\FeasibilityStudyComponent;
use App\Models\SubstationRoom;
use App\Models\PumpsRoom;
use App\Models\Offer;

class OfferConstructionCostController extends Controller
{
    /**
     * Store construction cost for offer (AJAX)
     */
    public function store(Request $request, $offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            $data = $request->validate([
                'feasibility_study_component_id' => 'required|exists:feasibility_study_components,id',
                'substation_room_id' => 'nullable|exists:substation_rooms,id',
                'pumps_room_id' => 'nullable|exists:pumps_rooms,id',
            ]);
            
            $data['offer_id'] = $offerId;
            
            // Check if this feasibility study component already exists for this offer
            $exists = OfferConstructionCost::where('offer_id', $offerId)
                ->where('feasibility_study_component_id', $data['feasibility_study_component_id'])
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This feasibility study component is already added to the offer!'
                ], 422);
            }
            
            OfferConstructionCost::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Construction cost added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update construction cost (AJAX)
     */
    public function update(Request $request, $offerId, $id)
    {
        try {
            $cost = OfferConstructionCost::findOrFail($id);
            
            $data = $request->validate([
                'substation_room_id' => 'nullable|exists:substation_rooms,id',
                'pumps_room_id' => 'nullable|exists:pumps_rooms,id',
            ]);
            
            $cost->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Construction cost updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete construction cost from offer (AJAX)
     */
    public function destroy($offerId, $id)
    {
        try {
            $cost = OfferConstructionCost::findOrFail($id);
            $cost->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Construction cost removed successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore trashed construction cost (AJAX)
     */
    public function restore($offerId, $id)
    {
        try {
            $cost = OfferConstructionCost::withTrashed()->findOrFail($id);
            $cost->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Construction cost restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available feasibility study components for offer (AJAX)
     */
    public function getAvailableFeasibilityComponents($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            // Get feasibility study components filtered by offer type and status
            $components = FeasibilityStudyComponent::where('project_type_id', $offer->type_id)
                ->where('status', 'Active')
                ->whereNull('deleted_at')
                ->orderBy('header_english')
                ->get();
            
            // Get already added component IDs
            $addedComponentIds = OfferConstructionCost::where('offer_id', $offerId)
                ->whereNull('deleted_at')
                ->pluck('feasibility_study_component_id')
                ->toArray();
            
            // Filter out already added components
            $availableComponents = $components->whereNotIn('id', $addedComponentIds)->values();
            
            return response()->json([
                'success' => true,
                'components' => $availableComponents
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available substation rooms for offer (AJAX)
     */
    public function getAvailableSubstationRooms($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            // Get substation rooms filtered by offer type
            $rooms = SubstationRoom::where('project_type_id', $offer->type_id)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            return response()->json([
                'success' => true,
                'rooms' => $rooms
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available pumps rooms for offer (AJAX)
     */
    public function getAvailablePumpsRooms($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            // Get pumps rooms filtered by offer type
            $rooms = PumpsRoom::where('project_type_id', $offer->type_id)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            return response()->json([
                'success' => true,
                'rooms' => $rooms
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

