<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\EngineeringCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EngineeringCategoryController extends Controller
{
    protected $engineeringCategory;

    public function __construct(EngineeringCategory $engineeringCategory)
    {
        $this->engineeringCategory = $engineeringCategory;
    }

    /**
     * Display a listing of engineering categories
     */
    public function index()
    {
        $categories = $this->engineeringCategory->list();
        
        return view('basicdata::engineeringcategories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new engineering category
     */
    public function create()
    {
        return view('basicdata::engineeringcategories.create');
    }

    /**
     * Store a newly created engineering category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
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

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('engineering_categories/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('engineering_categories/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('engineering_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        EngineeringCategory::create($data);

        return redirect()->route('engineeringcategory.index')->with('success', 'Engineering Category created successfully!');
    }

    /**
     * Display the specified engineering category
     */
    public function show($id)
    {
        $category = EngineeringCategory::findOrFail($id);
        
        return view('basicdata::engineeringcategories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing engineering category
     */
    public function edit($id)
    {
        $category = EngineeringCategory::findOrFail($id);
        
        return view('basicdata::engineeringcategories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified engineering category
     */
    public function update(Request $request, $id)
    {
        $category = EngineeringCategory::findOrFail($id);
        
        $data = $request->validate([
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

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($category->icon) {
                Storage::disk('public')->delete(ltrim($category->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('engineering_categories/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete(ltrim($category->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('engineering_categories/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($category->cover) {
                Storage::disk('public')->delete(ltrim($category->cover, '/'));
            }
            
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('engineering_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        $category->update($data);

        return redirect()->route('engineeringcategory.index')->with('success', 'Engineering Category updated successfully!');
    }

    /**
     * Soft delete the engineering category
     */
    public function destroy($id)
    {
        $category = EngineeringCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('engineeringcategory.index')->with('success', 'Engineering Category deleted successfully!');
    }

    /**
     * Display trashed engineering categories
     */
    public function trashed()
    {
        $categories = $this->engineeringCategory->trashed();
        
        return view('basicdata::engineeringcategories.trashed', [
            'categories' => $categories
        ]);
    }

    /**
     * Restore trashed engineering category
     */
    public function restore($id)
    {
        $category = EngineeringCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('engineeringcategory.trashed')->with('success', 'Engineering Category restored successfully!');
    }
}

