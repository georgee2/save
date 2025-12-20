<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OfferSubCategory;
use App\Models\OfferCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OfferSubCategoryController extends Controller
{
    protected $offerSubCategory;

    public function __construct(OfferSubCategory $offerSubCategory)
    {
        $this->offerSubCategory = $offerSubCategory;
    }

    /**
     * Display a listing of offer sub categories
     */
    public function index()
    {
        $subCategories = $this->offerSubCategory->list();
        
        return view('basicdata::offersubcategories.index', [
            'subCategories' => $subCategories
        ]);
    }

    /**
     * Show the form for creating a new offer sub category
     */
    public function create()
    {
        $categories = OfferCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('basicdata::offersubcategories.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created offer sub category
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:offer_categories,id',
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
            $iconPath = 'offer_sub_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        OfferSubCategory::create($data);

        return redirect()->route('offersubcategory.index')->with('success', 'Offer Sub Category created successfully!');
    }

    /**
     * Display the specified offer sub category
     */
    public function show($id)
    {
        $subCategory = OfferSubCategory::with('category')->findOrFail($id);
        
        return view('basicdata::offersubcategories.show', [
            'subCategory' => $subCategory
        ]);
    }

    /**
     * Show the form for editing offer sub category
     */
    public function edit($id)
    {
        $subCategory = OfferSubCategory::findOrFail($id);
        $categories = OfferCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        
        return view('basicdata::offersubcategories.edit', [
            'subCategory' => $subCategory,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified offer sub category
     */
    public function update(Request $request, $id)
    {
        $subCategory = OfferSubCategory::findOrFail($id);
        
        $data = $request->validate([
            'category_id' => 'required|exists:offer_categories,id',
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
            if ($subCategory->icon) {
                Storage::disk('public')->delete(ltrim($subCategory->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'offer_sub_categories/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        $subCategory->update($data);

        return redirect()->route('offersubcategory.index')->with('success', 'Offer Sub Category updated successfully!');
    }

    /**
     * Soft delete the offer sub category
     */
    public function destroy($id)
    {
        $subCategory = OfferSubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('offersubcategory.index')->with('success', 'Offer Sub Category deleted successfully!');
    }

    /**
     * Display trashed offer sub categories
     */
    public function trashed()
    {
        $subCategories = $this->offerSubCategory->trashed();
        
        return view('basicdata::offersubcategories.trashed', [
            'subCategories' => $subCategories
        ]);
    }

    /**
     * Restore trashed offer sub category
     */
    public function restore($id)
    {
        $subCategory = OfferSubCategory::withTrashed()->findOrFail($id);
        $subCategory->restore();

        return redirect()->route('offersubcategory.trashed')->with('success', 'Offer Sub Category restored successfully!');
    }
}

