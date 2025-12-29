<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineeringSubCategory;
use App\Models\Project;
use App\Models\PageBanner;

class EngineeringSubCategoryController extends Controller
{
    /**
     * Display the subcategory page with its projects
     */
    public function show($slug)
    {
        // Find the subcategory by slug with its category
        $subcategory = EngineeringSubCategory::with('category')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();
        
        // Fetch published projects for this subcategory with relationships
        $projects = Project::with(['category', 'subcategory', 'specifications.specification'])
            ->withCount('images')
            ->where('subcategory_id', $subcategory->id)
            ->where('publish_status', 0) // Published
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->through(function($project) {
                // Count videos (video_url and tour_url)
                $videoCount = 0;
                if (!empty($project->video_url)) $videoCount++;
                if (!empty($project->tour_url)) $videoCount++;
                $project->video_count = $videoCount;
                
                // Add 1 for main image to images_count
                $project->total_images = $project->images_count + 1;
                
                return $project;
            });
        
        // Get page banner for subcategory page
        $pageBanner = PageBanner::getByTarget('subcategory');
        
        return view('pages.projects.subcategories.subcategories', compact('subcategory', 'projects', 'pageBanner'));
    }
}
