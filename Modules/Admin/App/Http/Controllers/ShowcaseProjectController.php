<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use App\Models\Project;
use App\Models\ShowcaseProject;
use Illuminate\Support\Facades\DB;

class ShowcaseProjectController extends Controller
{
    /**
     * Get available projects for a showcase
     */
    public function getAvailableProjects($showcaseId)
    {
        try {
            $showcase = Showcase::findOrFail($showcaseId);
            
            // Get IDs of projects already attached to this showcase
            $attachedProjectIds = DB::table('showcase_project')
                ->where('showcase_id', $showcaseId)
                ->pluck('project_id')
                ->toArray();
            
            // Get all published projects that are not yet attached
            // Note: publish_status = 0 means "Published"
            // Using DB query for better performance and explicit deleted_at check
            $query = DB::table('projects')
                ->where('publish_status', 0)
                ->whereNull('deleted_at')
                ->select('id', 'title_english', 'title_arabic')
                ->orderBy('title_english');
            
            // Only add whereNotIn if there are attached projects
            if (!empty($attachedProjectIds)) {
                $query->whereNotIn('id', $attachedProjectIds);
            }
            
            $availableProjects = $query->get();
            
            return response()->json($availableProjects);
        } catch (\Exception $e) {
            \Log::error('Error loading available projects: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load projects',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a new project relation
     */
    public function store(Request $request, $showcaseId)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id'
        ]);
        
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Check if already exists
        $exists = ShowcaseProject::where('showcase_id', $showcaseId)
            ->where('project_id', $request->project_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This project is already added to the showcase.'
            ], 422);
        }
        
        // Attach the project
        $showcase->projects()->attach($request->project_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Project added successfully!'
        ]);
    }
    
    /**
     * Remove a project relation
     */
    public function destroy($showcaseId, $id)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        $showcaseProject = ShowcaseProject::where('showcase_id', $showcaseId)
            ->where('id', $id)
            ->firstOrFail();
        
        // Detach the project
        $showcase->projects()->detach($showcaseProject->project_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Project removed successfully!'
        ]);
    }
}

