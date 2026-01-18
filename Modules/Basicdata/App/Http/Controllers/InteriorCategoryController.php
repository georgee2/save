<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\InteriorCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class InteriorCategoryController extends Controller
{
    protected $interiorCategory;

    public function __construct(InteriorCategory $interiorCategory)
    {
        $this->interiorCategory = $interiorCategory;
    }

    /**
     * Display a listing of interior categories
     */
    public function index()
    {
        $categories = $this->interiorCategory->list();
        
        return view('basicdata::interiorcategories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new interior category
     */
    public function create()
    {
        return view('basicdata::interiorcategories.create');
    }

    /**
     * Store a newly created interior category
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

        // Handle icon upload (required) - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'interior_categories/icons/' . $iconName;
            
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
            $imagePath = $image->storeAs('interior_categories/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('interior_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        InteriorCategory::create($data);

        return redirect()->route('interiorcategory.index')->with('success', 'Interior Category created successfully!');
    }

    /**
     * Display the specified interior category
     */
    public function show($id)
    {
        $category = InteriorCategory::findOrFail($id);
        
        return view('basicdata::interiorcategories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing interior category
     */
    public function edit($id)
    {
        $category = InteriorCategory::findOrFail($id);
        
        return view('basicdata::interiorcategories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified interior category
     */
    public function update(Request $request, $id)
    {
        $category = InteriorCategory::findOrFail($id);
        
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

        // Handle icon upload - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($category->icon) {
                Storage::disk('public')->delete(ltrim($category->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'interior_categories/icons/' . $iconName;
            
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
            if ($category->image) {
                Storage::disk('public')->delete(ltrim($category->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('interior_categories/images', $imageName, 'public');
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
            $coverPath = $cover->storeAs('interior_categories/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        $category->update($data);

        return redirect()->route('interiorcategory.index')->with('success', 'Interior Category updated successfully!');
    }

    /**
     * Soft delete the interior category
     */
    public function destroy($id)
    {
        $category = InteriorCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('interiorcategory.index')->with('success', 'Interior Category deleted successfully!');
    }

    /**
     * Display trashed interior categories
     */
    public function trashed()
    {
        $categories = $this->interiorCategory->trashed();
        
        return view('basicdata::interiorcategories.trashed', [
            'categories' => $categories
        ]);
    }

    /**
     * Restore trashed interior category
     */
    public function restore($id)
    {
        $category = InteriorCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('interiorcategory.trashed')->with('success', 'Interior Category restored successfully!');
    }
}
