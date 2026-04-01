<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Emirate;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\EngineeringCategory;
use App\Models\EngineeringSubCategory;
use App\Models\ProjectType;
use App\Models\ProjectStyle;
use Illuminate\Support\Facades\DB;

class GlobalSearchController extends Controller
{
    /**
     * Live search API - Returns brief results as user types
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all'); // 'all', 'offers', 'projects'
        $emirateId = $request->get('emirate_id');
        $limit = $request->get('limit', 5);
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'results' => [],
                'total' => 0
            ]);
        }
        
        $results = [];
        $locale = app()->getLocale();
        
        // Search Offers
        if ($type === 'all' || $type === 'offers') {
            $offersQuery = Offer::where('publish_status', 0)
                ->whereNull('deleted_at')
                ->where(function($q) use ($query) {
                    $q->where('title_english', 'like', "%{$query}%")
                      ->orWhere('title_arabic', 'like', "%{$query}%")
                      ->orWhere('offer_code', 'like', "%{$query}%")
                      ->orWhere('offer_number', 'like', "%{$query}%")
                      ->orWhere('seo_tags', 'like', "%{$query}%");
                })
                ->with(['category', 'subcategory']);
            
            // Filter by emirate if provided (through prices)
            if ($emirateId) {
                $offersQuery->whereHas('prices', function($q) use ($emirateId) {
                    $q->where('emirate_id', $emirateId)
                      ->where('status', 0);
                });
            }
            
            $offers = $offersQuery->limit($limit)->get();
            
            foreach ($offers as $offer) {
                $results[] = [
                    'id' => $offer->id,
                    'type' => 'offer',
                    'type_label' => __('lang.offer'),
                    'title' => $locale === 'ar' ? $offer->title_arabic : $offer->title_english,
                    'code' => $offer->offer_code,
                    'image' => $offer->main_image ? url('/storage' . $offer->main_image) : null,
                    'category' => $offer->category ? ($locale === 'ar' ? $offer->category->title_arabic : $offer->category->title_english) : null,
                    'url' => route('offers.show', $offer->slug),
                    'sqft' => $offer->sqft ? number_format($offer->sqft) : null,
                ];
            }
        }
        
        // Search Projects
        if ($type === 'all' || $type === 'projects') {
            $projectsQuery = Project::where('publish_status', 0)
                ->whereNull('deleted_at')
                ->where(function($q) use ($query) {
                    $q->where('title_english', 'like', "%{$query}%")
                      ->orWhere('title_arabic', 'like', "%{$query}%")
                      ->orWhere('project_code', 'like', "%{$query}%")
                      ->orWhere('project_number', 'like', "%{$query}%")
                      ->orWhere('seo_tags', 'like', "%{$query}%")
                      ->orWhere('location_english', 'like', "%{$query}%")
                      ->orWhere('location_arabic', 'like', "%{$query}%");
                })
                ->with(['category', 'subcategory', 'emirate']);
            
            // Filter by emirate if provided
            if ($emirateId) {
                $projectsQuery->where('emirate_id', $emirateId);
            }
            
            $projects = $projectsQuery->limit($limit)->get();
            
            foreach ($projects as $project) {
                $results[] = [
                    'id' => $project->id,
                    'type' => 'project',
                    'type_label' => __('lang.project'),
                    'title' => $locale === 'ar' ? $project->title_arabic : $project->title_english,
                    'code' => $project->project_code,
                    'image' => $project->main_image ? url('/storage' . $project->main_image) : null,
                    'category' => $project->category ? ($locale === 'ar' ? $project->category->title_arabic : $project->category->title_english) : null,
                    'location' => $project->emirate ? ($locale === 'ar' ? $project->emirate->title_arabic : $project->emirate->title_english) : null,
                    'url' => route('projects.show', $project->slug),
                    'sqft' => $project->sqft ? number_format($project->sqft) : null,
                ];
            }
        }
        
        // Sort results by relevance (exact matches first)
        usort($results, function($a, $b) use ($query) {
            $aExact = stripos($a['title'], $query) === 0 ? 0 : 1;
            $bExact = stripos($b['title'], $query) === 0 ? 0 : 1;
            return $aExact - $bExact;
        });
        
        return response()->json([
            'success' => true,
            'results' => array_slice($results, 0, $limit * 2),
            'total' => count($results),
            'query' => $query
        ]);
    }
    
    /**
     * Full search with pagination - Redirects to appropriate listing page
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $type = $request->get('search_type', 'offers'); // 'offers' or 'projects'
        $keyword = $request->get('keyword', '');
        $emirateId = $request->get('emirate_id');
        $categoryId = $request->get('category_id');
        $subcategoryId = $request->get('subcategory_id');
        $typeId = $request->get('type_id');
        $styleId = $request->get('style_id');
        $minSqft = $request->get('min_sqft');
        $maxSqft = $request->get('max_sqft');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        
        // Build query parameters
        $params = array_filter([
            'keyword' => $keyword,
            'emirate_id' => $emirateId,
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId,
            'type_id' => $typeId,
            'style_id' => $styleId,
            'min_sqft' => $minSqft,
            'max_sqft' => $maxSqft,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);
        
        // Redirect to appropriate listing page
        if ($type === 'projects') {
            return redirect()->route('projects.index', $params);
        }
        
        return redirect()->route('offers.index', $params);
    }
    
    /**
     * Get emirates for dropdown
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmirates()
    {
        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english')
            ->get(['id', 'title_english', 'title_arabic', 'icon']);
        
        $locale = app()->getLocale();
        
        $data = $emirates->map(function($emirate) use ($locale) {
            return [
                'id' => $emirate->id,
                'name' => $locale === 'ar' ? $emirate->title_arabic : $emirate->title_english,
                'icon' => $emirate->icon ? url('/storage' . $emirate->icon) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'emirates' => $data
        ]);
    }
    
    /**
     * Get categories based on type (offers/projects)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request)
    {
        $type = $request->get('type', 'offers');
        $locale = app()->getLocale();
        
        if ($type === 'projects') {
            $categories = EngineeringCategory::whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(['id', 'title_english', 'title_arabic', 'icon']);
        } else {
            $categories = OfferCategory::whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(['id', 'title_english', 'title_arabic', 'icon']);
        }
        
        $data = $categories->map(function($cat) use ($locale) {
            return [
                'id' => $cat->id,
                'name' => $locale === 'ar' ? $cat->title_arabic : $cat->title_english,
                'icon' => $cat->icon ? url('/storage' . $cat->icon) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'categories' => $data
        ]);
    }
    
    /**
     * Get subcategories based on category
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubcategories(Request $request)
    {
        $type = $request->get('type', 'offers');
        $categoryId = $request->get('category_id');
        $locale = app()->getLocale();
        
        if (!$categoryId) {
            return response()->json([
                'success' => true,
                'subcategories' => []
            ]);
        }
        
        if ($type === 'projects') {
            $subcategories = EngineeringSubCategory::where('category_id', $categoryId)
                ->whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(['id', 'title_english', 'title_arabic', 'icon']);
        } else {
            $subcategories = OfferSubCategory::where('category_id', $categoryId)
                ->whereNull('deleted_at')
                ->orderBy('title_english')
                ->get(['id', 'title_english', 'title_arabic', 'icon']);
        }
        
        $data = $subcategories->map(function($sub) use ($locale) {
            return [
                'id' => $sub->id,
                'name' => $locale === 'ar' ? $sub->title_arabic : $sub->title_english,
                'icon' => $sub->icon ? url('/storage' . $sub->icon) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'subcategories' => $data
        ]);
    }
    
    /**
     * Get types (ProjectType)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypes()
    {
        $types = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english')
            ->get(['id', 'name_english', 'name_arabic', 'icon']);
        
        $locale = app()->getLocale();
        
        $data = $types->map(function($type) use ($locale) {
            return [
                'id' => $type->id,
                'name' => $locale === 'ar' ? $type->name_arabic : $type->name_english,
                'icon' => $type->icon ? url('/storage' . $type->icon) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'types' => $data
        ]);
    }
    
    /**
     * Get styles (ProjectStyle)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStyles()
    {
        $styles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english')
            ->get(['id', 'title_english', 'title_arabic', 'icon']);
        
        $locale = app()->getLocale();
        
        $data = $styles->map(function($style) use ($locale) {
            return [
                'id' => $style->id,
                'name' => $locale === 'ar' ? $style->title_arabic : $style->title_english,
                'icon' => $style->icon ? url('/storage' . $style->icon) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'styles' => $data
        ]);
    }
}
