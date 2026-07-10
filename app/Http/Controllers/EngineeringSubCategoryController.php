<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EngineeringSubCategory;
use App\Models\EngineeringCategory;
use App\Models\Project;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Specification;
use App\Models\PageBanner;
use Illuminate\Support\Facades\DB;

class EngineeringSubCategoryController extends Controller
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
     * Only returns categories and subcategories that have at least one published project
     */
    private function getFilterData($categoryId = null)
    {
        // Get categories that have at least one published project
        $categories = EngineeringCategory::whereNull('deleted_at')
            ->whereHas('projects', function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            })
            ->orderBy('title_english')
            ->get();
        
        // Get subcategories that have at least one published project
        $subcategoriesQuery = EngineeringSubCategory::whereNull('deleted_at')
            ->whereHas('projects', function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            })
            ->orderBy('title_english');
        
        if ($categoryId) {
            $subcategoriesQuery->where('category_id', $categoryId);
        }
        
        // Subcategories with project counts for slider filter (only those with projects)
        $subcategoriesWithCountQuery = EngineeringSubCategory::withCount(['projects' => function($query) {
                $query->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->whereNull('deleted_at')
            ->having('projects_count', '>', 0)
            ->orderBy('title_english');
        
        if ($categoryId) {
            $subcategoriesWithCountQuery->where('category_id', $categoryId);
        }
        
        return [
            'categories' => $categories,
            'subcategories' => $subcategoriesQuery->get(),
            'styles' => ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get(),
            'types' => ProjectType::whereNull('deleted_at')->where('status', 0)->orderBy('name_english')->get(),
            'specifications' => Specification::whereNull('deleted_at')->orderBy('title_english')->get(),
            'subcategoriesWithCount' => $subcategoriesWithCountQuery->get(),
        ];
    }
    
    /**
     * Display the subcategory page with its projects
     */
    public function show(Request $request, $slug)
    {
        // Find the subcategory by slug with its category
        $subcategory = EngineeringSubCategory::with('category')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();
        
        // Get filter data scoped to the same parent category
        $filterData = $this->getFilterData($subcategory->category_id);
        $categories = $filterData['categories'];
        $subcategories = $filterData['subcategories'];
        $subcategoriesWithCount = $filterData['subcategoriesWithCount'];
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
                ->where('projects.subcategory_id', $subcategory->id)
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
                       ->where('subcategory_id', $subcategory->id)
                       ->whereNull('deleted_at')
                       ->with(['category', 'subcategory', 'style', 'specifications.specification'])
                       ->withCount('images');
        
        // Apply filters
        $query = $this->applyFilters($query, $request);
        
        // Apply sorting
        $query = $this->applySorting($query, $request);
        
        // Get paginated results
        $projects = $query->paginate(9)
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

        // Soft-404 guard: a subcategory with zero published projects (and no user filter) is a 404, not a thin 200.
        if ($projects->total() === 0 && !$this->listingHasActiveFilters($request)) {
            abort(404);
        }

        // Get page banner for subcategory page
        $pageBanner = PageBanner::getByTarget('subcategory');
        
        return view('pages.projects.subcategories.subcategories', compact(
            'subcategory', 'projects', 'categories', 'subcategories', 'subcategoriesWithCount', 'styles', 'types', 'specifications', 'specificationValues', 'pageBanner'
        ));
    }
}
