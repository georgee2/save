<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectIncomeComponent;
use App\Models\IncomeComponent;

class ProjectIncomeComponentController extends Controller
{
    /**
     * Get available income components for project (AJAX)
     */
    public function getAvailableComponents($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get income components filtered by project type
            $incomeComponents = IncomeComponent::where('project_type_id', $project->type_id)
                ->whereNull('deleted_at')
                ->orderBy('name_english')
                ->get();
            
            // Get already added component IDs
            $addedComponentIds = ProjectIncomeComponent::where('project_id', $projectId)
                ->whereNull('deleted_at')
                ->pluck('income_component_id')
                ->toArray();
            
            // Filter out already added components
            $availableComponents = $incomeComponents->whereNotIn('id', $addedComponentIds)->values();
            
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
     * Store a newly created income component (AJAX)
     */
    public function store(Request $request, $projectId)
    {
        try {
            $request->validate([
                'income_component_id' => 'required|exists:income_components,id',
                'number_of_units' => 'required|integer|min:1',
                'rent_per_year' => 'required|numeric|min:0',
            ]);
            
            ProjectIncomeComponent::create([
                'project_id' => $projectId,
                'income_component_id' => $request->income_component_id,
                'number_of_units' => $request->number_of_units,
                'rent_per_year' => $request->rent_per_year,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Income component added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update the specified income component (AJAX)
     */
    public function update(Request $request, $projectId, $id)
    {
        try {
            $component = ProjectIncomeComponent::findOrFail($id);
            
            $request->validate([
                'number_of_units' => 'required|integer|min:1',
                'rent_per_year' => 'required|numeric|min:0',
            ]);
            
            $component->update([
                'number_of_units' => $request->number_of_units,
                'rent_per_year' => $request->rent_per_year,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Income component updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Soft delete the income component (AJAX)
     */
    public function destroy($projectId, $id)
    {
        try {
            $component = ProjectIncomeComponent::findOrFail($id);
            $component->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Income component deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Restore trashed income component (AJAX)
     */
    public function restore($projectId, $id)
    {
        try {
            $component = ProjectIncomeComponent::withTrashed()->findOrFail($id);
            $component->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Income component restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

