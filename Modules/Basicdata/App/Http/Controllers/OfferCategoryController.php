<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OfferCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OfferCategoryController extends Controller
{
    protected $offerCategory;

    public function __construct(OfferCategory $offerCategory)
    {
        $this->offerCategory = $offerCategory;
    }

    /**
     * Display a listing of offer categories
     */
    public function index()
    {
        $categories = $this->offerCategory->list();
        
        return view('basicdata::offercategories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new offer category
     */
    public function create()
    {
        return view('basicdata::offercategories.create');
    }

    /**
     * Store a newly created offer category
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
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
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
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'offer_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        OfferCategory::create($data);

        return redirect()->route('offercategory.index')->with('success', 'Offer Category created successfully!');
    }

    /**
     * Display the specified offer category
     */
    public function show($id)
    {
        $category = OfferCategory::findOrFail($id);
        
        return view('basicdata::offercategories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing offer category
     */
    public function edit($id)
    {
        $category = OfferCategory::findOrFail($id);
        
        return view('basicdata::offercategories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified offer category
     */
    public function update(Request $request, $id)
    {
        $category = OfferCategory::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
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
            $iconPath = 'offer_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        $category->update($data);

        return redirect()->route('offercategory.index')->with('success', 'Offer Category updated successfully!');
    }

    /**
     * Soft delete the offer category
     */
    public function destroy($id)
    {
        $category = OfferCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('offercategory.index')->with('success', 'Offer Category deleted successfully!');
    }

    /**
     * Display trashed offer categories
     */
    public function trashed()
    {
        $categories = $this->offerCategory->trashed();
        
        return view('basicdata::offercategories.trashed', [
            'categories' => $categories
        ]);
    }

    /**
     * Restore trashed offer category
     */
    public function restore($id)
    {
        $category = OfferCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('offercategory.trashed')->with('success', 'Offer Category restored successfully!');
    }
}

