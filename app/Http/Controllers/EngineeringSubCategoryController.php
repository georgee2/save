<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineeringSubCategory;
use App\Models\Project;

class EngineeringSubCategoryController extends Controller
{
    /**
     * Display the subcategory page with its projects
     */
    public function show($slug)
    {
        // Find the subcategory by slug
        $subcategory = EngineeringSubCategory::with('category')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();
        
        // Fetch published projects for this subcategory
        $projects = Project::with(['category', 'subcategory', 'currency', 'style', 'type'])
            ->where('subcategory_id', $subcategory->id)
            ->where('publish_status', 0) // Published
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        // Get total count of projects
        $projectsCount = Project::where('subcategory_id', $subcategory->id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->count();
        
        return view('subcategory.show', compact('subcategory', 'projects', 'projectsCount'));
    }
}


