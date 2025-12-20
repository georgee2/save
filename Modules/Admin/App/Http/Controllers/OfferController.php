<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\OfferSubCategory;
use App\Models\Currency;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OfferController extends Controller
{
    protected $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Display a listing of offers
     */
    public function index()
    {
        $offers = $this->offer->list();
        
        return view('admin::offers.index', [
            'offers' => $offers
        ]);
    }

    /**
     * Show the form for creating a new offer
     */
    public function create()
    {
        $categories = OfferCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $currencies = Currency::where('status', 0)->whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('admin::offers.create', compact('categories', 'currencies', 'styles', 'types'));
    }

    /**
     * Store a newly created offer
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'category_id' => 'required|exists:offer_categories,id',
            'subcategory_id' => 'nullable|exists:offer_sub_categories,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'style_id' => 'nullable|exists:project_styles,id',
            'type_id' => 'required|exists:project_types,id',
            'sqft' => 'nullable|numeric|min:0',
            'sqm' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:255',
            'tour_url' => 'nullable|url|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'site_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'plan_2d_image' => 'nullable|file|mimes:pdf|max:10240',
            'plan_3d_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description_english' => 'nullable|string|max:3000',
            'description_arabic' => 'nullable|string|max:3000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'seo_tags' => 'nullable',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'home_status' => 'required|in:0,1',
            'publish_status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // Handle main_image upload (1080x1080)
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 1080, 1080, 'offers/main');
        }

        // Handle cover_image upload (1890x420)
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->handleImageUpload($request->file('cover_image'), 1890, 420, 'offers/cover');
        }

        // Handle page_image upload (868x450)
        if ($request->hasFile('page_image')) {
            $data['page_image'] = $this->handleImageUpload($request->file('page_image'), 868, 450, 'offers/page');
        }

        // Handle site_image upload (420x420)
        if ($request->hasFile('site_image')) {
            $data['site_image'] = $this->handleImageUpload($request->file('site_image'), 420, 420, 'offers/site');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'offers/files');
        }

        // Handle plan_3d_image upload (870x420)
        if ($request->hasFile('plan_3d_image')) {
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 870, 420, 'offers/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        Offer::create($data);

        return redirect()->route('offer.index')->with('success', 'Offer created successfully!');
    }

    /**
     * Show the form for editing offer
     */
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        $categories = OfferCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $subcategories = OfferSubCategory::where('category_id', $offer->category_id)->whereNull('deleted_at')->orderBy('title_english')->get();
        $currencies = Currency::where('status', 0)->whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('admin::offers.edit', compact('offer', 'categories', 'subcategories', 'currencies', 'styles', 'types'));
    }

    /**
     * Update the specified offer
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'category_id' => 'required|exists:offer_categories,id',
            'subcategory_id' => 'nullable|exists:offer_sub_categories,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'style_id' => 'nullable|exists:project_styles,id',
            'type_id' => 'required|exists:project_types,id',
            'sqft' => 'nullable|numeric|min:0',
            'sqm' => 'nullable|numeric|min:0',
            'video_url' => 'nullable|url|max:255',
            'tour_url' => 'nullable|url|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'site_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'plan_2d_image' => 'nullable|file|mimes:pdf|max:10240',
            'plan_3d_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description_english' => 'nullable|string|max:3000',
            'description_arabic' => 'nullable|string|max:3000',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'seo_tags' => 'nullable',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'home_status' => 'required|in:0,1',
            'publish_status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // Handle main_image upload (1080x1080)
        if ($request->hasFile('main_image')) {
            if ($offer->main_image) {
                Storage::disk('public')->delete(ltrim($offer->main_image, '/'));
            }
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 1080, 1080, 'offers/main');
        }

        // Handle cover_image upload (1890x420)
        if ($request->hasFile('cover_image')) {
            if ($offer->cover_image) {
                Storage::disk('public')->delete(ltrim($offer->cover_image, '/'));
            }
            $data['cover_image'] = $this->handleImageUpload($request->file('cover_image'), 1890, 420, 'offers/cover');
        }

        // Handle page_image upload (868x450)
        if ($request->hasFile('page_image')) {
            if ($offer->page_image) {
                Storage::disk('public')->delete(ltrim($offer->page_image, '/'));
            }
            $data['page_image'] = $this->handleImageUpload($request->file('page_image'), 868, 450, 'offers/page');
        }

        // Handle site_image upload (420x420)
        if ($request->hasFile('site_image')) {
            if ($offer->site_image) {
                Storage::disk('public')->delete(ltrim($offer->site_image, '/'));
            }
            $data['site_image'] = $this->handleImageUpload($request->file('site_image'), 420, 420, 'offers/site');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            if ($offer->plan_2d_image) {
                Storage::disk('public')->delete(ltrim($offer->plan_2d_image, '/'));
            }
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'offers/files');
        }

        // Handle plan_3d_image upload (870x420)
        if ($request->hasFile('plan_3d_image')) {
            if ($offer->plan_3d_image) {
                Storage::disk('public')->delete(ltrim($offer->plan_3d_image, '/'));
            }
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 870, 420, 'offers/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        $offer->update($data);

        return redirect()->route('offer.index')->with('success', 'Offer updated successfully!');
    }

    /**
     * Display the specified offer
     */
    public function show($id)
    {
        $offer = $this->offer->findWithRelations($id);
        
        if (!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offer not found!');
        }
        
        return view('admin::offers.show', compact('offer'));
    }

    /**
     * Soft delete the offer
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return redirect()->route('offer.index')->with('success', 'Offer deleted successfully!');
    }

    /**
     * Display trashed offers
     */
    public function trashed()
    {
        $offers = $this->offer->trashed();
        
        return view('admin::offers.trashed', compact('offers'));
    }

    /**
     * Restore trashed offer
     */
    public function restore($id)
    {
        $offer = Offer::withTrashed()->findOrFail($id);
        $offer->restore();

        return redirect()->route('offer.trashed')->with('success', 'Offer restored successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->publish_status = $offer->publish_status == 0 ? 1 : 0;
        $offer->save();

        $status = $offer->publish_status == 0 ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Offer {$status} successfully!");
    }

    /**
     * Toggle home feature status
     */
    public function toggleHomeFeature($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->home_status = $offer->home_status == 0 ? 1 : 0;
        $offer->save();

        $status = $offer->home_status == 0 ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "Offer {$status} successfully!");
    }

    /**
     * Get subcategories by category (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = OfferSubCategory::where('category_id', $request->category_id)
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return response()->json($subcategories);
    }
    
    /**
     * Handle image upload, convert to WebP and resize
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $width
     * @param int $height
     * @param string $folder
     * @return string
     */
    private function handleImageUpload($file, $width, $height, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize
        $image = Image::make($file->getRealPath())
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 80);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/' . $folder . '/' . $filename, (string) $image);
        
        return '/uploads/' . $folder . '/' . $filename;
    }

    /**
     * Handle PDF file upload
     */
    private function handlePdfUpload($file, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.pdf';
        
        // Store the PDF file using Storage::disk('public')
        Storage::disk('public')->put('/uploads/' . $folder . '/' . $filename, file_get_contents($file->getRealPath()));
        
        return '/uploads/' . $folder . '/' . $filename;
    }
}

