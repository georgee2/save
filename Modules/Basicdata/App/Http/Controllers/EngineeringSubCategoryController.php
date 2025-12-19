<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\EngineeringSubCategory;
use App\Models\EngineeringCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EngineeringSubCategoryController extends Controller
{
    protected $engineeringSubCategory;

    public function __construct(EngineeringSubCategory $engineeringSubCategory)
    {
        $this->engineeringSubCategory = $engineeringSubCategory;
    }

    /**
     * Display a listing of engineering sub categories
     */
    public function index()
    {
        $subCategories = $this->engineeringSubCategory->list();
        
        return view('basicdata::engineeringsubcategories.index', [
            'subCategories' => $subCategories
        ]);
    }

    /**
     * Show the form for creating a new engineering sub category
     */
    public function create()
    {
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('basicdata::engineeringsubcategories.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created engineering sub category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:engineering_categories,id',
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

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

        // Handle icon upload (required) - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'engineering_sub_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('engineering_sub_categories/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('engineering_sub_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        EngineeringSubCategory::create($data);

        return redirect()->route('engineeringsubcategory.index')->with('success', 'Engineering Sub Category created successfully!');
    }

    /**
     * Display the specified engineering sub category
     */
    public function show($id)
    {
        $subCategory = EngineeringSubCategory::with('category')->findOrFail($id);
        
        return view('basicdata::engineeringsubcategories.show', [
            'subCategory' => $subCategory
        ]);
    }

    /**
     * Show the form for editing engineering sub category
     */
    public function edit($id)
    {
        $subCategory = EngineeringSubCategory::findOrFail($id);
        $categories = EngineeringCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('basicdata::engineeringsubcategories.edit', [
            'subCategory' => $subCategory,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified engineering sub category
     */
    public function update(Request $request, $id)
    {
        $subCategory = EngineeringSubCategory::findOrFail($id);
        
        $data = $request->validate([
            'category_id' => 'required|exists:engineering_categories,id',
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

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

        // Handle icon upload - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($subCategory->icon) {
                Storage::disk('public')->delete(ltrim($subCategory->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'engineering_sub_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subCategory->image) {
                Storage::disk('public')->delete(ltrim($subCategory->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('engineering_sub_categories/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($subCategory->cover) {
                Storage::disk('public')->delete(ltrim($subCategory->cover, '/'));
            }
            
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('engineering_sub_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        $subCategory->update($data);

        return redirect()->route('engineeringsubcategory.index')->with('success', 'Engineering Sub Category updated successfully!');
    }

    /**
     * Soft delete the engineering sub category
     */
    public function destroy($id)
    {
        $subCategory = EngineeringSubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('engineeringsubcategory.index')->with('success', 'Engineering Sub Category deleted successfully!');
    }

    /**
     * Display trashed engineering sub categories
     */
    public function trashed()
    {
        $subCategories = $this->engineeringSubCategory->trashed();
        
        return view('basicdata::engineeringsubcategories.trashed', [
            'subCategories' => $subCategories
        ]);
    }

    /**
     * Restore trashed engineering sub category
     */
    public function restore($id)
    {
        $subCategory = EngineeringSubCategory::withTrashed()->findOrFail($id);
        $subCategory->restore();

        return redirect()->route('engineeringsubcategory.trashed')->with('success', 'Engineering Sub Category restored successfully!');
    }
}

