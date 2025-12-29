<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\EngineeringCategory;
use App\Models\PageBanner;

class CategoryController extends Controller
{
    /**
     * Display projects for a specific category
     */
    public function show($slug)
    {
        // Find the category by slug
        $category = EngineeringCategory::where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();
        
        // Fetch published projects for this category with relationships
        $projects = Project::with(['category', 'subcategory', 'specifications.specification'])
            ->withCount('images')
            ->where('publish_status', 0) // Published
            ->where('category_id', $category->id)
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
        
        // Get page banner for category page
        $pageBanner = PageBanner::getByTarget('category');
        
        return view('pages.projects.categories.categories', compact('projects', 'category', 'pageBanner'));
    }
}
