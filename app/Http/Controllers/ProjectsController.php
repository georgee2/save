<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Specification;
use App\Models\ProjectSpecification;
use App\Models\PageBanner;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    /**
     * Apply sorting to the query
     */
    private function applySorting($query, Request $request)
    {
        $sortby = $request->get('sortby', 'newest');
        
        switch ($sortby) {
            case 'oldest':
                $query->orderBy('projects.created_at', 'ASC');
                break;
            case 'area_low':
                $query->orderBy('sqft', 'ASC');
                break;
            case 'area_high':
                $query->orderBy('sqft', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('projects.created_at', 'DESC');
                break;
        }
        return $query;
    }
    
    /**
     * Apply common filters to the query
     */
    private function applyFilters($query, Request $request)
    {
        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Subcategory filter
        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
        
        // Style filter
        if ($request->filled('style_id')) {
            $query->where('style_id', $request->style_id);
        }
        
        // Type filter
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }
        
        // SQFT Range filter
        if ($request->filled('sqft_min') && $request->sqft_min != 50) {
            $query->where('sqft', '>=', $request->sqft_min);
        }
        if ($request->filled('sqft_max') && $request->sqft_max != 15000) {
            $query->where('sqft', '<=', $request->sqft_max);
        }
        
        // SQM Range filter
        if ($request->filled('sqm_min') && $request->sqm_min != 5) {
            $query->where('sqm', '>=', $request->sqm_min);
        }
        if ($request->filled('sqm_max') && $request->sqm_max != 1400) {
            $query->where('sqm', '<=', $request->sqm_max);
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
        
        // Specifications filter with value
        if ($request->filled('specification_id')) {
            $specId = $request->specification_id;
            $specValue = $request->get('specification_value', '');
            
            $query->whereHas('specifications', function($q) use ($specId, $specValue) {
                $q->where('specification_id', $specId);
                if (!empty($specValue)) {
                    $q->where(function($subQ) use ($specValue) {
                        $subQ->where('value_english', 'like', "%{$specValue}%")
                             ->orWhere('value_arabic', 'like', "%{$specValue}%");
                    });
                }
            });
        }
        
        return $query;
    }
    
    /**
     * Get filter data for views
     */
    private function getFilterData()
    {
        return [
            'categories' => EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get(),
            'subcategories' => EngineeringSubCategory::whereNull('deleted_at')->orderBy('title_english')->get(),
            'styles' => ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get(),
            'types' => ProjectType::whereNull('deleted_at')->where('status', 0)->orderBy('name_english')->get(),
            'specifications' => Specification::whereNull('deleted_at')->orderBy('title_english')->get(),
            // Subcategories with project counts for slider filter
            'subcategoriesWithCount' => EngineeringSubCategory::withCount(['projects' => function($query) {
                    $query->where('publish_status', 0)->whereNull('deleted_at');
                }])
                ->whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(),
        ];
    }
    
    /**
     * Get specification values for a given specification ID (AJAX endpoint)
     */
    public function getSpecificationValues(Request $request)
    {
        $specificationId = $request->get('specification_id');
        
        if (!$specificationId) {
            return response()->json(['values' => []]);
        }
        
        $locale = app()->getLocale();
        $valueColumn = $locale == 'ar' ? 'value_arabic' : 'value_english';
        
        // Get distinct values for this specification from project_specifications
        $values = DB::table('project_specifications')
            ->join('projects', 'project_specifications.project_id', '=', 'projects.id')
            ->where('project_specifications.specification_id', $specificationId)
            ->where('projects.publish_status', 0)
            ->whereNull('project_specifications.deleted_at')
            ->whereNull('projects.deleted_at')
            ->select("project_specifications.{$valueColumn} as value")
            ->distinct()
            ->orderBy('value')
            ->pluck('value')
            ->filter()
            ->values()
            ->toArray();
        
        return response()->json(['values' => $values]);
    }

    public function index(Request $request)
    {
        // Get filter data
        $filterData = $this->getFilterData();
        $categories = $filterData['categories'];
        $subcategories = $filterData['subcategories'];
        $styles = $filterData['styles'];
        $types = $filterData['types'];
        $specifications = $filterData['specifications'];
        
        // Get specification values if a specification is selected
        $specificationValues = [];
        if ($request->filled('specification_id')) {
            $locale = app()->getLocale();
            $valueColumn = $locale == 'ar' ? 'value_arabic' : 'value_english';
            
            $specificationValues = DB::table('project_specifications')
                ->join('projects', 'project_specifications.project_id', '=', 'projects.id')
                ->where('project_specifications.specification_id', $request->specification_id)
                ->where('projects.publish_status', 0)
                ->whereNull('project_specifications.deleted_at')
                ->whereNull('projects.deleted_at')
                ->select("project_specifications.{$valueColumn} as value")
                ->distinct()
                ->orderBy('value')
                ->pluck('value')
                ->filter()
                ->values()
                ->toArray();
        }
        
        // Build query
        $query = Project::where('publish_status', 0)
                       ->whereNull('deleted_at')
                       ->with(['category', 'subcategory', 'style', 'specifications.specification'])
                       ->withCount('images');
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $projects = $query->paginate(10)
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
        
        $subcategoriesWithCount = $filterData['subcategoriesWithCount'];
        
        return view('pages.projects.index', compact('projects', 'categories', 'subcategories', 'subcategoriesWithCount', 'styles', 'types', 'specifications', 'specificationValues', 'pageBanner'));
    }
    
    /**
     * Display featured projects page
     */
    public function featured(Request $request)
    {
        // Get filter data
        $filterData = $this->getFilterData();
        $categories = $filterData['categories'];
        $subcategories = $filterData['subcategories'];
        $styles = $filterData['styles'];
        $types = $filterData['types'];
        $specifications = $filterData['specifications'];
        
        // Get specification values if a specification is selected
        $specificationValues = [];
        if ($request->filled('specification_id')) {
            $locale = app()->getLocale();
            $valueColumn = $locale == 'ar' ? 'value_arabic' : 'value_english';
            
            $specificationValues = DB::table('project_specifications')
                ->join('projects', 'project_specifications.project_id', '=', 'projects.id')
                ->where('project_specifications.specification_id', $request->specification_id)
                ->where('projects.publish_status', 0)
                ->where('projects.home_status', 0)
                ->whereNull('project_specifications.deleted_at')
                ->whereNull('projects.deleted_at')
                ->select("project_specifications.{$valueColumn} as value")
                ->distinct()
                ->orderBy('value')
                ->pluck('value')
                ->filter()
                ->values()
                ->toArray();
        }
        
        // Build query for featured projects (home_status = 0)
        $query = Project::where('publish_status', 0)
                       ->where('home_status', 0)
                       ->whereNull('deleted_at')
                       ->with(['category', 'subcategory', 'style', 'specifications.specification'])
                       ->withCount('images');
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $projects = $query->paginate(10)
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
        
        $subcategoriesWithCount = $filterData['subcategoriesWithCount'];
        
        return view('pages.projects.featured.featured', compact(
            'projects', 'categories', 'subcategories', 'subcategoriesWithCount', 'styles', 'types', 'specifications', 'specificationValues', 'pageBanner'
        ));
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
