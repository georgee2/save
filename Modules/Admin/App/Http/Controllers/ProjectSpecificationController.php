<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectSpecification;
use App\Models\Specification;

class ProjectSpecificationController extends Controller
{
    /**
     * Get available specifications for project (AJAX)
     */
    public function getAvailableComponents($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            // Get specifications filtered by project type
            $specifications = Specification::where('type_id', $project->type_id)
                ->where('status', 0) // Active only
                ->whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(['id', 'title_english', 'title_arabic', 'icon']);
            
            // Get already added specification IDs
            $addedSpecIds = ProjectSpecification::where('project_id', $projectId)
                ->whereNull('deleted_at')
                ->pluck('specification_id')
                ->toArray();
            
            // Filter out already added specifications
            $availableSpecs = $specifications->whereNotIn('id', $addedSpecIds)->values();
            
            return response()->json([
                'success' => true,
                'components' => $availableSpecs
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a newly created specification (AJAX)
     */
    public function store(Request $request, $projectId)
    {
        try {
            $request->validate([
                'specification_id' => 'required|exists:specifications,id',
                'value_english' => 'required|string|max:255',
                'value_arabic' => 'required|string|max:255',
            ]);
            
            ProjectSpecification::create([
                'project_id' => $projectId,
                'specification_id' => $request->specification_id,
                'value_english' => $request->value_english,
                'value_arabic' => $request->value_arabic,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Specification added successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Bulk store multiple specifications (AJAX)
     */
    public function bulkStore(Request $request, $projectId)
    {
        try {
            $request->validate([
                'specifications' => 'required|array|min:1',
                'specifications.*.specification_id' => 'required|exists:specifications,id',
                'specifications.*.value_english' => 'required|string|max:255',
                'specifications.*.value_arabic' => 'required|string|max:255',
            ]);
            
            $addedCount = 0;
            $skippedCount = 0;
            
            // Get already added specification IDs
            $existingSpecIds = ProjectSpecification::where('project_id', $projectId)
                ->whereNull('deleted_at')
                ->pluck('specification_id')
                ->toArray();
            
            foreach ($request->specifications as $spec) {
                // Skip if specification already exists for this project
                if (in_array($spec['specification_id'], $existingSpecIds)) {
                    $skippedCount++;
                    continue;
                }
                
                ProjectSpecification::create([
                    'project_id' => $projectId,
                    'specification_id' => $spec['specification_id'],
                    'value_english' => $spec['value_english'],
                    'value_arabic' => $spec['value_arabic'],
                ]);
                
                $addedCount++;
                $existingSpecIds[] = $spec['specification_id']; // Prevent duplicates in same batch
            }
            
            $message = "{$addedCount} specification(s) added successfully!";
            if ($skippedCount > 0) {
                $message .= " ({$skippedCount} skipped as already exists)";
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $addedCount,
                'skipped' => $skippedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update the specified specification (AJAX)
     */
    public function update(Request $request, $projectId, $id)
    {
        try {
            $specification = ProjectSpecification::findOrFail($id);
            
            $request->validate([
                'value_english' => 'required|string|max:255',
                'value_arabic' => 'required|string|max:255',
            ]);
            
            $specification->update([
                'value_english' => $request->value_english,
                'value_arabic' => $request->value_arabic,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Specification updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Soft delete the specification (AJAX)
     */
    public function destroy($projectId, $id)
    {
        try {
            $specification = ProjectSpecification::findOrFail($id);
            $specification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Specification deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Restore trashed specification (AJAX)
     */
    public function restore($projectId, $id)
    {
        try {
            $specification = ProjectSpecification::withTrashed()->findOrFail($id);
            $specification->restore();
            
            return response()->json([
                'success' => true,
                'message' => 'Specification restored successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Force delete the specification permanently (AJAX)
     */
    public function forceDelete($projectId, $id)
    {
        try {
            $specification = ProjectSpecification::withTrashed()->findOrFail($id);
            $specification->forceDelete();
            
            return response()->json([
                'success' => true,
                'message' => 'Specification permanently deleted!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

