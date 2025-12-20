<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OfferBuildingComponent;
use App\Models\BuildingComponent;
use App\Models\Offer;

class OfferBuildingComponentController extends Controller
{
    protected $offerBuildingComponent;

    public function __construct(OfferBuildingComponent $offerBuildingComponent)
    {
        $this->offerBuildingComponent = $offerBuildingComponent;
    }

    /**
     * Store building component for offer (AJAX)
     */
    public function store(Request $request, $offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            $data = $request->validate([
                'building_component_id' => 'required|exists:building_components,id',
                'construction_cost' => 'required|numeric|min:0',
            ]);
            
            $data['offer_id'] = $offerId;
            
            // Check if component already exists for this offer
            $exists = OfferBuildingComponent::where('offer_id', $offerId)
                ->where('building_component_id', $data['building_component_id'])
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This building component is already added to the offer!'
                ], 422);
            }
            
            OfferBuildingComponent::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Building component added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update building component (AJAX)
     */
    public function update(Request $request, $offerId, $id)
    {
        try {
            $component = OfferBuildingComponent::findOrFail($id);
            
            $data = $request->validate([
                'construction_cost' => 'required|numeric|min:0',
            ]);
            
            $component->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Building component updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete building component from offer (AJAX)
     */
    public function destroy($offerId, $id)
    {
        try {
            $component = OfferBuildingComponent::findOrFail($id);
            $component->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Building component removed successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore trashed building component (AJAX)
     */
    public function restore($offerId, $id)
    {
        try {
            $component = OfferBuildingComponent::withTrashed()->findOrFail($id);
            $component->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Building component restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available building components for offer (AJAX)
     */
    public function getAvailableComponents($offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            
            // Get building components filtered by offer type (exclude is_length components)
            $buildingComponents = BuildingComponent::where('project_type_id', $offer->type_id)
                ->where('is_length', false)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            // Get already added component IDs
            $addedComponentIds = OfferBuildingComponent::where('offer_id', $offerId)
                ->whereNull('deleted_at')
                ->pluck('building_component_id')
                ->toArray();
            
            // Filter out already added components
            $availableComponents = $buildingComponents->whereNotIn('id', $addedComponentIds)->values();
            
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
}

