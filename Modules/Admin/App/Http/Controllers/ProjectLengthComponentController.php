<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProjectLengthComponent;
use App\Models\BuildingComponent;
use App\Models\LengthComponent;
use App\Models\Project;

class ProjectLengthComponentController extends Controller
{
    protected $projectLengthComponent;

    public function __construct(ProjectLengthComponent $projectLengthComponent)
    {
        $this->projectLengthComponent = $projectLengthComponent;
    }

    /**
     * Store length component for project (AJAX)
     */
    public function store(Request $request, $projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            $data = $request->validate([
                'building_component_id' => 'required|exists:building_components,id',
                'length_component_id' => 'required|exists:length_components,id',
                'unit_cost' => 'required|numeric|min:0',
            ]);
            
            $data['project_id'] = $projectId;
            
            // Check if component already exists for this project
            $exists = ProjectLengthComponent::where('project_id', $projectId)
                ->where('building_component_id', $data['building_component_id'])
                ->where('length_component_id', $data['length_component_id'])
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This length component is already added to the project!'
                ], 422);
            }
            
            ProjectLengthComponent::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Length component added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update length component (AJAX)
     */
    public function update(Request $request, $projectId, $id)
    {
        try {
            $component = ProjectLengthComponent::findOrFail($id);
            
            $data = $request->validate([
                'unit_cost' => 'required|numeric|min:0',
            ]);
            
            $component->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Length component updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete length component from project (AJAX)
     */
    public function destroy($projectId, $id)
    {
        try {
            $component = ProjectLengthComponent::findOrFail($id);
            $component->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Length component removed successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore trashed length component (AJAX)
     */
    public function restore($projectId, $id)
    {
        try {
            $component = ProjectLengthComponent::withTrashed()->findOrFail($id);
            $component->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Length component restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available building components (only length components) for project (AJAX)
     */
    public function getAvailableBuildingComponents($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get building components filtered by project type and is_length = true
            $buildingComponents = BuildingComponent::where('project_type_id', $project->type_id)
                ->where('is_length', true)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            return response()->json([
                'success' => true,
                'components' => $buildingComponents
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available length components filtered by building component (AJAX)
     */
    public function getAvailableLengthComponents(Request $request, $projectId)
    {
        try {
            $buildingComponentId = $request->get('building_component_id');
            
            if (!$buildingComponentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Building component ID is required'
                ], 422);
            }
            
            // Get length components filtered by building component
            $lengthComponents = LengthComponent::where('building_component_id', $buildingComponentId)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            // Get already added length component IDs for this building component
            $addedComponentIds = ProjectLengthComponent::where('project_id', $projectId)
                ->where('building_component_id', $buildingComponentId)
                ->whereNull('deleted_at')
                ->pluck('length_component_id')
                ->toArray();
            
            // Filter out already added components
            $availableComponents = $lengthComponents->whereNotIn('id', $addedComponentIds)->values();
            
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

