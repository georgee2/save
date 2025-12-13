<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProjectConstructionCost;
use App\Models\FeasibilityStudyComponent;
use App\Models\SubstationRoom;
use App\Models\PumpsRoom;
use App\Models\Project;

class ProjectConstructionCostController extends Controller
{
    protected $projectConstructionCost;

    public function __construct(ProjectConstructionCost $projectConstructionCost)
    {
        $this->projectConstructionCost = $projectConstructionCost;
    }

    /**
     * Store construction cost for project (AJAX)
     */
    public function store(Request $request, $projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            $data = $request->validate([
                'feasibility_study_component_id' => 'required|exists:feasibility_study_components,id',
                'substation_room_id' => 'nullable|exists:substation_rooms,id',
                'pumps_room_id' => 'nullable|exists:pumps_rooms,id',
            ]);
            
            $data['project_id'] = $projectId;
            
            // Check if this feasibility study component already exists for this project
            $exists = ProjectConstructionCost::where('project_id', $projectId)
                ->where('feasibility_study_component_id', $data['feasibility_study_component_id'])
                ->whereNull('deleted_at')
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'This feasibility study component is already added to the project!'
                ], 422);
            }
            
            ProjectConstructionCost::create($data);
            
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
    public function update(Request $request, $projectId, $id)
    {
        try {
            $cost = ProjectConstructionCost::findOrFail($id);
            
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
     * Delete construction cost from project (AJAX)
     */
    public function destroy($projectId, $id)
    {
        try {
            $cost = ProjectConstructionCost::findOrFail($id);
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
    public function restore($projectId, $id)
    {
        try {
            $cost = ProjectConstructionCost::withTrashed()->findOrFail($id);
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
     * Get available feasibility study components for project (AJAX)
     */
    public function getAvailableFeasibilityComponents($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get feasibility study components filtered by project type and status
            $components = FeasibilityStudyComponent::where('project_type_id', $project->type_id)
                ->where('status', 'Active')
                ->whereNull('deleted_at')
                ->orderBy('header_english')
                ->get();
            
            // Get already added component IDs
            $addedComponentIds = ProjectConstructionCost::where('project_id', $projectId)
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
     * Get available substation rooms for project (AJAX)
     */
    public function getAvailableSubstationRooms($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get substation rooms filtered by project type
            $rooms = SubstationRoom::where('project_type_id', $project->type_id)
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
     * Get available pumps rooms for project (AJAX)
     */
    public function getAvailablePumpsRooms($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get pumps rooms filtered by project type
            $rooms = PumpsRoom::where('project_type_id', $project->type_id)
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

