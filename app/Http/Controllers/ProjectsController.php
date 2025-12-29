<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\ProjectStyle;
use App\Models\Specification;
use App\Models\PageBanner;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter data
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $subcategories = EngineeringSubCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $specifications = Specification::whereNull('deleted_at')->orderBy('title_english')->get();
        
        // Build query
        $query = Project::where('publish_status', 0)
                       ->whereNull('deleted_at')
                       ->with(['category', 'subcategory', 'style', 'specifications.specification'])
                       ->withCount('images');
        
        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
        
        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }
        
        if ($request->filled('sqft_from')) {
            $query->where('sqft', '>=', $request->sqft_from);
        }
        
        if ($request->filled('sqft_to')) {
            $query->where('sqft', '<=', $request->sqft_to);
        }
        
        if ($request->filled('sqm_from')) {
            $query->where('sqm', '>=', $request->sqm_from);
        }
        
        if ($request->filled('sqm_to')) {
            $query->where('sqm', '<=', $request->sqm_to);
        }
        
        // Keyword search (title and SEO tags)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title_english', 'like', "%{$keyword}%")
                  ->orWhere('title_arabic', 'like', "%{$keyword}%")
                  ->orWhere('seo_tags', 'like', "%{$keyword}%");
            });
        }
        
        // Specification filter
        if ($request->filled('specification_id') && $request->filled('specification_value')) {
            $query->whereHas('specifications', function($q) use ($request) {
                $q->where('specification_id', $request->specification_id)
                  ->where(function($subQ) use ($request) {
                      $subQ->where('value_english', 'like', "%{$request->specification_value}%")
                           ->orWhere('value_arabic', 'like', "%{$request->specification_value}%");
                  });
            });
        }
        
        // Get paginated results
        $projects = $query->orderBy('created_at', 'DESC')->paginate(10)
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
        
        // Get page banner for projects page
        $pageBanner = PageBanner::getByTarget('projects');
        
        return view('pages.projects.index', compact('projects', 'categories', 'subcategories', 'styles', 'specifications', 'pageBanner'));
    }
    
    /**
     * Display featured projects page
     */
    public function featured()
    {
        // Get filter data
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $subcategories = EngineeringSubCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        
        // Fetch featured projects (home_status = 0) with relationships
        $projects = Project::with(['category', 'subcategory', 'specifications.specification'])
            ->withCount('images')
            ->where('publish_status', 0) // Published
            ->where('home_status', 0)    // Featured (shown on home)
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
        
        // Get page banner for featured projects page
        $pageBanner = PageBanner::getByTarget('featured-projects');
        
        return view('pages.projects.featured.featured', compact('projects', 'categories', 'subcategories', 'pageBanner'));
    }
    
    public function show($slug)
    {
        $project = Project::where('slug', $slug)
                         ->where('publish_status', 0)
                         ->whereNull('deleted_at')
                         ->with([
                             'category',
                             'subcategory',
                             'currency',
                             'style',
                             'type',
                             'partner',
                             'emirate', // Load emirate for location
                             'images', // Load project gallery images
                             'floors.floorComponent', // Load floor component details
                             'floors.buildingComponent', // Load building component details
                             'floors.specifications.specification', // Load floor specifications with icons
                             'floors.amenities.amenity', // Load floor amenities with icons
                             'specifications.specification', // Load project specification details with icon
                             'constructionCosts',
                             'feasibilityStudies' => function($query) {
                                 $query->where('status', 'Active')->whereNull('deleted_at');
                             },
                             'feasibilityStudies.currency',
                             'feasibilityStudies.buildingComponents.buildingComponent',
                             'feasibilityStudies.incomeComponents.incomeComponent',
                             'feasibilityStudies.constructionCosts.substationRoom',
                             'feasibilityStudies.constructionCosts.pumpsRoom',
                             'feasibilityStudies.projectCost'
                         ])
                         ->firstOrFail();
        
        return view('pages.projects.project', compact('project'));
    }
}
