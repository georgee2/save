<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\InteriorDesignGallery;
use App\Models\InteriorCategory;
use App\Models\Project;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Emirate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class InteriorDesignGalleryController extends Controller
{
    protected $interiorDesignGallery;

    public function __construct(InteriorDesignGallery $interiorDesignGallery)
    {
        $this->interiorDesignGallery = $interiorDesignGallery;
    }

    /**
     * Display a listing of interior design galleries
     */
    public function index(Request $request)
    {
        $query = InteriorDesignGallery::query()
            ->leftJoin('interior_categories as ic', 'interior_design_galleries.category_id', '=', 'ic.id')
            ->leftJoin('project_types as pt', 'interior_design_galleries.project_type_id', '=', 'pt.id')
            ->leftJoin('project_styles as ps', 'interior_design_galleries.project_style_id', '=', 'ps.id')
            ->leftJoin('emirates as e', 'interior_design_galleries.emirate_id', '=', 'e.id')
            ->select(
                'interior_design_galleries.id',
                'interior_design_galleries.title_english',
                'interior_design_galleries.title_arabic',
                'interior_design_galleries.image',
                'interior_design_galleries.publish_status',
                'interior_design_galleries.home_status',
                'interior_design_galleries.ordering',
                'interior_design_galleries.created_at',
                'ic.title_english as category_name',
                'pt.name_english as type_name',
                'ps.title_english as style_name',
                'e.title_english as emirate_name'
            )
            ->whereNull('interior_design_galleries.deleted_at');

        // Apply filters
        if ($request->filled('title')) {
            $query->where(function ($q) use ($request) {
                $q->where('interior_design_galleries.title_english', 'like', '%' . $request->title . '%')
                  ->orWhere('interior_design_galleries.title_arabic', 'like', '%' . $request->title . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('interior_design_galleries.category_id', $request->category_id);
        }
        if ($request->filled('type_id')) {
            $query->where('interior_design_galleries.project_type_id', $request->type_id);
        }
        if ($request->filled('style_id')) {
            $query->where('interior_design_galleries.project_style_id', $request->style_id);
        }
        if ($request->filled('emirate_id')) {
            $query->where('interior_design_galleries.emirate_id', $request->emirate_id);
        }
        if ($request->filled('publish_status')) {
            $query->where('interior_design_galleries.publish_status', $request->publish_status);
        }
        if ($request->filled('home_status')) {
            $query->where('interior_design_galleries.home_status', $request->home_status);
        }

        // Order and paginate
        $galleries = $query->orderBy('interior_design_galleries.ordering', 'asc')
            ->orderBy('interior_design_galleries.created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        // Get filter options
        $categories = InteriorCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $emirates = Emirate::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('admin::interior-design-galleries.index', compact(
            'galleries',
            'categories',
            'types',
            'styles',
            'emirates'
        ));
    }

    /**
     * Show the form for creating a new interior design gallery
     */
    public function create()
    {
        $categories = InteriorCategory::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projects = Project::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectStyles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectTypes = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
            
        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.create', compact(
            'categories',
            'projects', 
            'projectStyles', 
            'projectTypes', 
            'emirates'
        ));
    }

    /**
     * Store a newly created interior design gallery
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'publish_status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
            'ordering' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:interior_categories,id',
            'project_id' => 'nullable|exists:projects,id',
            'project_style_id' => 'nullable|exists:project_styles,id',
            'project_type_id' => 'required|exists:project_types,id',
            'emirate_id' => 'nullable|exists:emirates,id',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate unique slug from English title
        $baseSlug = Str::slug($data['title_english']);
        $slug = $baseSlug;
        $slugCounter = 1;
        
        // Check for existing slugs (including soft-deleted)
        while (InteriorDesignGallery::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }
        $data['slug'] = $slug;

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null)
        {
            $data['seo_tags'] = tags($request->seo_tags);
        }
        
        // SEO Description Insertion
        if($request->seo_description_english != null)
        {
            $data['seo_description_english'] = $request->seo_description_english;
        }

        if($request->seo_description_arabic != null)
        {
            $data['seo_description_arabic'] = $request->seo_description_arabic;
        }

        // Handle image upload - resize to 765x432, convert to WebP
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        InteriorDesignGallery::create($data);

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery created successfully!');
    }

    /**
     * Display the specified interior design gallery
     */
    public function show($id)
    {
        $gallery = InteriorDesignGallery::with(['category', 'project', 'projectStyle', 'projectType', 'emirate'])->findOrFail($id);
        
        return view('admin::interior-design-galleries.show', [
            'gallery' => $gallery
        ]);
    }

    /**
     * Show the form for editing interior design gallery
     */
    public function edit($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        
        $categories = InteriorCategory::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
        
        $projects = Project::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectStyles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectTypes = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
            
        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.edit', compact(
            'gallery',
            'categories',
            'projects', 
            'projectStyles', 
            'projectTypes', 
            'emirates'
        ));
    }

    /**
     * Update the specified interior design gallery
     */
    public function update(Request $request, $id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'publish_status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
            'ordering' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:interior_categories,id',
            'project_id' => 'nullable|exists:projects,id',
            'project_style_id' => 'nullable|exists:project_styles,id',
            'project_type_id' => 'required|exists:project_types,id',
            'emirate_id' => 'nullable|exists:emirates,id',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate unique slug from English title
        $baseSlug = Str::slug($data['title_english']);
        $slug = $baseSlug;
        $slugCounter = 1;
        
        // Check for existing slugs (excluding current record, including soft-deleted)
        while (InteriorDesignGallery::withTrashed()
            ->where('slug', $slug)
            ->where('id', '!=', $id)
            ->exists()) {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }
        $data['slug'] = $slug;

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null)
        {
            $data['seo_tags'] = tags($request->seo_tags);
        }
        
        // SEO Description Insertion
        if($request->seo_description_english != null)
        {
            $data['seo_description_english'] = $request->seo_description_english;
        }

        if($request->seo_description_arabic != null)
        {
            $data['seo_description_arabic'] = $request->seo_description_arabic;
        }

        // Handle image upload - resize to 765x432, convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image) {
                Storage::disk('public')->delete(ltrim($gallery->image, '/'));
            }
            
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $gallery->update($data);

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery updated successfully!');
    }

    /**
     * Soft delete the interior design gallery
     */
    public function destroy($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery deleted successfully!');
    }

    /**
     * Display trashed interior design galleries
     */
    public function trashed()
    {
        $galleries = $this->interiorDesignGallery->trashed();
        
        return view('admin::interior-design-galleries.trashed', [
            'galleries' => $galleries
        ]);
    }

    /**
     * Restore trashed interior design gallery
     */
    public function restore($id)
    {
        $gallery = InteriorDesignGallery::withTrashed()->findOrFail($id);
        $gallery->restore();

        return redirect()->route('interior-design-gallery.trashed')->with('success', 'Interior Design Gallery restored successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->publish_status = $gallery->publish_status == 0 ? 1 : 0;
        $gallery->save();
        
        $status = $gallery->publish_status == 0 ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Gallery {$status} successfully!");
    }

    /**
     * Toggle home status
     */
    public function toggleHomeStatus($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->home_status = $gallery->home_status == 0 ? 1 : 0;
        $gallery->save();
        
        $status = $gallery->home_status == 0 ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "Gallery {$status} successfully!");
    }

    /**
     * Handle image upload, convert to WebP and resize
     * Dimensions: 765x432
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and fit to exact 765x432 dimensions
        $image = Image::make($file->getRealPath())
            ->fit(765, 432, function ($constraint) {
                $constraint->upsize(); // Prevent upsizing small images
            })
            ->encode('webp', 85);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/interior_design_galleries/' . $filename, (string) $image);
        
        return '/interior_design_galleries/' . $filename;
    }
    
    /**
     * Bulk update publish status
     */
    public function bulkPublish(Request $request)
    {
        $action = $request->input('action'); // 'publish' or 'unpublish'
        $scope = $request->input('scope'); // 'all' or 'selected'
        $ids = $request->input('ids', '[]');
        
        // Decode JSON string to array
        $idsArray = json_decode($ids, true) ?? [];
        
        $query = InteriorDesignGallery::whereNull('deleted_at');
        
        if ($scope === 'selected' && !empty($idsArray)) {
            $query->whereIn('id', $idsArray);
        }
        
        $newStatus = $action === 'publish' ? 0 : 1;
        $count = $query->count();
        $query->update(['publish_status' => $newStatus]);
        
        $statusText = $action === 'publish' ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "{$count} gallery item(s) {$statusText} successfully!");
    }
    
    /**
     * Bulk update home status
     */
    public function bulkHomeStatus(Request $request)
    {
        $action = $request->input('action'); // 'show' or 'hide'
        $scope = $request->input('scope'); // 'all' or 'selected'
        $ids = $request->input('ids', '[]');
        
        // Decode JSON string to array
        $idsArray = json_decode($ids, true) ?? [];
        
        $query = InteriorDesignGallery::whereNull('deleted_at');
        
        if ($scope === 'selected' && !empty($idsArray)) {
            $query->whereIn('id', $idsArray);
        }
        
        $newStatus = $action === 'show' ? 0 : 1;
        $count = $query->count();
        $query->update(['home_status' => $newStatus]);
        
        $statusText = $action === 'show' ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "{$count} gallery item(s) {$statusText} successfully!");
    }
    
    /**
     * Show bulk add form
     */
    public function bulkAdd()
    {
        $categories = InteriorCategory::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectTypes = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.bulk-add', compact('categories', 'projectTypes'));
    }
    
    /**
     * Get next available number for a category
     */
    public function getNextNumber($categoryId)
    {
        $category = InteriorCategory::find($categoryId);
        
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        
        // Get the category name in English
        $categoryName = $category->title_english;
        
        // Find all existing titles that match the pattern "CategoryName X" where X is a number
        // Include soft-deleted records to avoid slug conflicts
        $existingNumbers = InteriorDesignGallery::withTrashed()
            ->where('category_id', $categoryId)
            ->where('title_english', 'LIKE', $categoryName . ' %')
            ->pluck('title_english')
            ->map(function($title) use ($categoryName) {
                // Extract the number from the title
                $pattern = '/^' . preg_quote($categoryName, '/') . ' (\d+)$/';
                if (preg_match($pattern, $title, $matches)) {
                    return (int) $matches[1];
                }
                return null;
            })
            ->filter()
            ->toArray();
        
        // Find the next available number
        $nextNumber = 1;
        if (!empty($existingNumbers)) {
            sort($existingNumbers);
            // Find the first gap or use max + 1
            for ($i = 1; $i <= max($existingNumbers) + 1; $i++) {
                if (!in_array($i, $existingNumbers)) {
                    $nextNumber = $i;
                    break;
                }
            }
        }
        
        return response()->json([
            'category_name_english' => $categoryName,
            'category_name_arabic' => $category->title_arabic,
            'next_number' => $nextNumber,
            'existing_numbers' => $existingNumbers
        ]);
    }
    
    /**
     * Store bulk uploaded images
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:interior_categories,id',
            'project_type_id' => 'required|exists:project_types,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        
        $categoryId = $request->category_id;
        $projectTypeId = $request->project_type_id;
        
        // Get category info
        $category = InteriorCategory::find($categoryId);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }
        
        $categoryNameEnglish = $category->title_english;
        $categoryNameArabic = $category->title_arabic;
        
        // Get existing numbers for this category (including soft-deleted to avoid slug conflicts)
        $existingNumbers = InteriorDesignGallery::withTrashed()
            ->where('category_id', $categoryId)
            ->where('title_english', 'LIKE', $categoryNameEnglish . ' %')
            ->pluck('title_english')
            ->map(function($title) use ($categoryNameEnglish) {
                $pattern = '/^' . preg_quote($categoryNameEnglish, '/') . ' (\d+)$/';
                if (preg_match($pattern, $title, $matches)) {
                    return (int) $matches[1];
                }
                return null;
            })
            ->filter()
            ->toArray();
        
        // Also check existing slugs to avoid unique constraint violations
        $existingSlugs = InteriorDesignGallery::withTrashed()
            ->pluck('slug')
            ->toArray();
        
        // Get max ordering
        $maxOrdering = InteriorDesignGallery::whereNull('deleted_at')->max('ordering') ?? 0;
        
        $uploadedCount = 0;
        $errors = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                try {
                    // Find next available number
                    $nextNumber = 1;
                    if (!empty($existingNumbers)) {
                        sort($existingNumbers);
                        for ($i = 1; $i <= max($existingNumbers) + 1; $i++) {
                            if (!in_array($i, $existingNumbers)) {
                                $nextNumber = $i;
                                break;
                            }
                        }
                    }
                    
                    // Add this number to existing numbers for next iteration
                    $existingNumbers[] = $nextNumber;
                    
                    // Generate titles
                    $titleEnglish = $categoryNameEnglish . ' ' . $nextNumber;
                    $titleArabic = $categoryNameArabic . ' ' . $nextNumber;
                    
                    // Generate unique slug
                    $baseSlug = Str::slug($titleEnglish);
                    $slug = $baseSlug;
                    $slugCounter = 1;
                    while (in_array($slug, $existingSlugs)) {
                        $slug = $baseSlug . '-' . $slugCounter;
                        $slugCounter++;
                    }
                    // Add this slug to existing slugs for next iteration
                    $existingSlugs[] = $slug;
                    
                    // Handle image upload
                    $imagePath = $this->handleImageUpload($image);
                    
                    // Increment ordering
                    $maxOrdering++;
                    
                    // Create gallery entry
                    InteriorDesignGallery::create([
                        'title_english' => $titleEnglish,
                        'title_arabic' => $titleArabic,
                        'slug' => $slug,
                        'image' => $imagePath,
                        'category_id' => $categoryId,
                        'project_type_id' => $projectTypeId,
                        'publish_status' => 1, // Not published by default
                        'home_status' => 1, // Not shown on home by default
                        'ordering' => $maxOrdering,
                    ]);
                    
                    $uploadedCount++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Image " . ($index + 1) . ": " . $e->getMessage();
                }
            }
        }
        
        if ($uploadedCount > 0) {
            $message = "{$uploadedCount} image(s) uploaded successfully!";
            if (!empty($errors)) {
                $message .= " However, some images failed: " . implode(', ', $errors);
                return redirect()->route('interior-design-gallery.index')->with('warning', $message);
            }
            return redirect()->route('interior-design-gallery.index')->with('success', $message);
        }
        
        return redirect()->back()->with('error', 'No images were uploaded. ' . implode(', ', $errors));
    }

    /**
     * Display the index page ordering screen (first 6 images)
     */
    public function orderIndex()
    {
        $galleries = InteriorDesignGallery::with('category')
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.order-index', compact('galleries'));
    }

    /**
     * Display the all images ordering screen
     */
    public function orderAll(Request $request)
    {
        $query = InteriorDesignGallery::with('category')
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc');
        
        // Filter by category if specified
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        $galleries = $query->get();
        $categories = InteriorCategory::whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.order-all', compact('galleries', 'categories'));
    }

    /**
     * Update ordering for index page (first 6)
     */
    public function updateIndexOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            InteriorDesignGallery::where('id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Index page order updated successfully!',
        ]);
    }

    /**
     * Update ordering for all images
     */
    public function updateAllOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            InteriorDesignGallery::where('id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }
}
