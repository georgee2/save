<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProjectBuildingComponent;
use App\Models\BuildingComponent;
use App\Models\Project;

class ProjectBuildingComponentController extends Controller
{
    protected $projectBuildingComponent;

    public function __construct(ProjectBuildingComponent $projectBuildingComponent)
    {
        $this->projectBuildingComponent = $projectBuildingComponent;
    }

    /**
     * Store building component for project (AJAX)
     */
    public function store(Request $request, $projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            $data = $request->validate([
                'building_component_id' => 'required|exists:building_components,id',
                'construction_cost' => 'required|numeric|min:0',
            ]);
            
            $data['project_id'] = $projectId;
            
            // Check if component already exists for this project
            $exists = ProjectBuildingComponent::where('project_id', $projectId)
                ->where('building_component_id', $data['building_component_id'])
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This building component is already added to the project!'
                ], 422);
            }
            
            ProjectBuildingComponent::create($data);
            
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
    public function update(Request $request, $projectId, $id)
    {
        try {
            $component = ProjectBuildingComponent::findOrFail($id);
            
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
     * Delete building component from project (AJAX)
     */
    public function destroy($projectId, $id)
    {
        try {
            $component = ProjectBuildingComponent::findOrFail($id);
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
    public function restore($projectId, $id)
    {
        try {
            $component = ProjectBuildingComponent::withTrashed()->findOrFail($id);
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
     * Get available building components for project (AJAX)
     */
    public function getAvailableComponents($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get building components filtered by project type (exclude is_length components)
            $buildingComponents = BuildingComponent::where('project_type_id', $project->type_id)
                ->where('is_length', false)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            // Get already added component IDs
            $addedComponentIds = ProjectBuildingComponent::where('project_id', $projectId)
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

