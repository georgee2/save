<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InteriorDesignGallery;
use App\Models\InteriorCategory;
use App\Models\ProjectStyle;
use App\Models\Emirate;

class InteriorGalleryController extends Controller
{
    /**
     * Display the interior gallery listing page with filters
     */
    public function index(Request $request)
    {
        // Build base query
        $query = InteriorDesignGallery::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with(['category', 'projectStyle', 'projectType', 'emirate', 'project']);

        // Apply filters
        
        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Style filter
        if ($request->filled('style_id')) {
            $query->where('project_style_id', $request->style_id);
        }

        // Emirate filter
        if ($request->filled('emirate_id')) {
            $query->where('emirate_id', $request->emirate_id);
        }

        // Keyword search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title_english', 'like', "%{$keyword}%")
                  ->orWhere('title_arabic', 'like', "%{$keyword}%")
                  ->orWhere('bio_english', 'like', "%{$keyword}%")
                  ->orWhere('bio_arabic', 'like', "%{$keyword}%");
            });
        }

        // Apply sorting
        $sortby = $request->get('sortby', 'newest');
        switch ($sortby) {
            case 'oldest':
                $query->orderBy('created_at', 'ASC');
                break;
            case 'title_asc':
                $query->orderBy('title_english', 'ASC');
                break;
            case 'title_desc':
                $query->orderBy('title_english', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('ordering', 'ASC')->orderBy('created_at', 'DESC');
                break;
        }

        // Get paginated results
        $galleries = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = InteriorCategory::whereNull('deleted_at')
            ->withCount(['galleries' => function($q) {
                $q->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->orderBy('title_english')
            ->get();

        $styles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();

        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();

        // Get categories with count for slider - exclude categories with zero galleries
        $categoriesWithCount = $categories->filter(function($category) {
            return $category->galleries_count > 0;
        });

        return view('pages.interior.index', compact(
            'galleries',
            'categories',
            'categoriesWithCount',
            'styles',
            'emirates'
        ));
    }

    /**
     * Display galleries by category
     */
    public function category(Request $request, $slug)
    {
        // Find category by slug
        $currentCategory = InteriorCategory::where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Build base query
        $query = InteriorDesignGallery::where('publish_status', 0)
            ->where('category_id', $currentCategory->id)
            ->whereNull('deleted_at')
            ->with(['category', 'projectStyle', 'projectType', 'emirate', 'project']);

        // Apply filters (same as index)
        if ($request->filled('style_id')) {
            $query->where('project_style_id', $request->style_id);
        }

        if ($request->filled('emirate_id')) {
            $query->where('emirate_id', $request->emirate_id);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title_english', 'like', "%{$keyword}%")
                  ->orWhere('title_arabic', 'like', "%{$keyword}%")
                  ->orWhere('bio_english', 'like', "%{$keyword}%")
                  ->orWhere('bio_arabic', 'like', "%{$keyword}%");
            });
        }

        // Apply sorting
        $sortby = $request->get('sortby', 'newest');
        switch ($sortby) {
            case 'oldest':
                $query->orderBy('created_at', 'ASC');
                break;
            case 'title_asc':
                $query->orderBy('title_english', 'ASC');
                break;
            case 'title_desc':
                $query->orderBy('title_english', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('ordering', 'ASC')->orderBy('created_at', 'DESC');
                break;
        }

        // Get paginated results
        $galleries = $query->paginate(12)->withQueryString();

        // Get filter data
        $categories = InteriorCategory::whereNull('deleted_at')
            ->withCount(['galleries' => function($q) {
                $q->where('publish_status', 0)->whereNull('deleted_at');
            }])
            ->orderBy('title_english')
            ->get();

        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();

        // Get categories with count for slider - exclude categories with zero galleries
        $categoriesWithCount = $categories->filter(function($category) {
            return $category->galleries_count > 0;
        });

        return view('pages.interior.category', compact(
            'galleries',
            'currentCategory',
            'categories',
            'categoriesWithCount',
            'styles',
            'emirates'
        ));
    }

    /**
     * Display single gallery item (modal data via AJAX or dedicated page)
     */
    public function show($slug)
    {
        $gallery = InteriorDesignGallery::where('slug', $slug)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with(['category', 'projectStyle', 'projectType', 'emirate', 'project'])
            ->firstOrFail();

        // Get related galleries (same category or style)
        $relatedGalleries = InteriorDesignGallery::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->where('id', '!=', $gallery->id)
            ->where(function($q) use ($gallery) {
                $q->where('category_id', $gallery->category_id)
                  ->orWhere('project_style_id', $gallery->project_style_id);
            })
            ->with(['category', 'projectStyle'])
            ->limit(6)
            ->get();

        return view('pages.interior.show', compact('gallery', 'relatedGalleries'));
    }
}
