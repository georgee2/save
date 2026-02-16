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
    public function index(Request $request)
    {
        $query = Offer::query()
            ->leftJoin('offer_categories as oc', 'offers.category_id', '=', 'oc.id')
            ->leftJoin('offer_sub_categories as osc', 'offers.subcategory_id', '=', 'osc.id')
            ->leftJoin('project_types as pt', 'offers.type_id', '=', 'pt.id')
            ->leftJoin('project_styles as ps', 'offers.style_id', '=', 'ps.id')
            ->select(
                'offers.id',
                'offers.offer_code',
                'offers.offer_number',
                'offers.title_english',
                'offers.title_arabic',
                'offers.main_image',
                'oc.title_english as category_name',
                'osc.title_english as subcategory_name',
                'pt.name_english as type_name',
                'ps.title_english as style_name',
                'offers.publish_status',
                'offers.home_status',
                'offers.created_at'
            )
            ->whereNull('offers.deleted_at');

        // Apply filters
        if ($request->filled('offer_id')) {
            $query->where('offers.id', $request->offer_id);
        }
        if ($request->filled('offer_number')) {
            $query->where('offers.offer_number', 'like', '%' . $request->offer_number . '%');
        }
        if ($request->filled('offer_code')) {
            $query->where('offers.offer_code', 'like', '%' . $request->offer_code . '%');
        }
        if ($request->filled('title')) {
            $query->where(function ($q) use ($request) {
                $q->where('offers.title_english', 'like', '%' . $request->title . '%')
                  ->orWhere('offers.title_arabic', 'like', '%' . $request->title . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('offers.category_id', $request->category_id);
        }
        if ($request->filled('subcategory_id')) {
            $query->where('offers.subcategory_id', $request->subcategory_id);
        }
        if ($request->filled('type_id')) {
            $query->where('offers.type_id', $request->type_id);
        }
        if ($request->filled('style_id')) {
            $query->where('offers.style_id', $request->style_id);
        }
        if ($request->filled('publish_status')) {
            $query->where('offers.publish_status', $request->publish_status);
        }
        if ($request->filled('home_status')) {
            $query->where('offers.home_status', $request->home_status);
        }

        // Order by newest first and paginate
        $offers = $query->orderBy('offers.created_at', 'desc')->paginate(15)->withQueryString();
        
        // Get filter options
        $categories = OfferCategory::whereNull('deleted_at')->orderBy('title_english')->get();
        $subcategories = collect();
        if ($request->filled('category_id')) {
            $subcategories = OfferSubCategory::where('category_id', $request->category_id)
                ->whereNull('deleted_at')
                ->orderBy('title_english')
                ->get();
        }
        $types = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $styles = ProjectStyle::whereNull('deleted_at')->orderBy('title_english')->get();

        return view('admin::offers.index', [
            'offers' => $offers,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'types' => $types,
            'styles' => $styles,
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
            'offer_number' => 'nullable|string|max:50',
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

        // Handle main_image upload (903x1146)
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 903, 1146, 'offers/main');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'offers/files');
        }

        // Handle plan_3d_image upload (903x1146)
        if ($request->hasFile('plan_3d_image')) {
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 903, 1146, 'offers/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        // Generate offer code using category, subcategory, and offer number
        $data['offer_code'] = Offer::generateOfferCode($data['category_id'], $data['subcategory_id'] ?? null, $data['offer_number'] ?? null);

        $offer = Offer::create($data);

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
        
        // Generate offer code if it's null (for existing offers without codes)
        if (is_null($offer->offer_code)) {
            $offer->offer_code = Offer::generateOfferCode($offer->category_id, $offer->subcategory_id, $offer->offer_number);
            $offer->save();
        }
        
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
            'offer_number' => 'nullable|string|max:50',
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

        // Handle main_image upload (903x1146)
        if ($request->hasFile('main_image')) {
            if ($offer->main_image) {
                Storage::disk('public')->delete(ltrim($offer->main_image, '/'));
            }
            $data['main_image'] = $this->handleImageUpload($request->file('main_image'), 903, 1146, 'offers/main');
        }

        // Handle plan_2d_image upload (PDF file)
        if ($request->hasFile('plan_2d_image')) {
            if ($offer->plan_2d_image) {
                Storage::disk('public')->delete(ltrim($offer->plan_2d_image, '/'));
            }
            $data['plan_2d_image'] = $this->handlePdfUpload($request->file('plan_2d_image'), 'offers/files');
        }

        // Handle plan_3d_image upload (903x1146)
        if ($request->hasFile('plan_3d_image')) {
            if ($offer->plan_3d_image) {
                Storage::disk('public')->delete(ltrim($offer->plan_3d_image, '/'));
            }
            $data['plan_3d_image'] = $this->handleImageUpload($request->file('plan_3d_image'), 903, 1146, 'offers/plans_3d');
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }
        
        // Check if category, subcategory, or offer_number changed - need to regenerate offer code
        $regenerateCode = (
            $offer->category_id != $data['category_id'] || 
            $offer->subcategory_id != ($data['subcategory_id'] ?? null) ||
            $offer->offer_number != ($data['offer_number'] ?? null) ||
            is_null($offer->offer_code) // Also regenerate if code is null
        );
        
        // Regenerate offer code if category/subcategory/offer_number changed or if it's null
        if ($regenerateCode) {
            $data['offer_code'] = Offer::generateOfferCode($data['category_id'], $data['subcategory_id'] ?? null, $data['offer_number'] ?? null);
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
     * Toggle feasibility studies visibility on website
     */
    public function toggleFeasibilityStudies($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->show_feasibility_studies = $offer->show_feasibility_studies == 0 ? 1 : 0;
        $offer->save();

        $status = $offer->show_feasibility_studies == 0 ? 'visible on website' : 'hidden from website';
        return redirect()->back()->with('success', "Feasibility studies {$status} successfully!");
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
     * Live search for offers by offer number or offer code (AJAX)
     */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 1) {
            return response()->json([]);
        }
        
        $offers = Offer::query()
            ->leftJoin('offer_categories as oc', 'offers.category_id', '=', 'oc.id')
            ->select(
                'offers.id',
                'offers.offer_code',
                'offers.offer_number',
                'offers.title_english',
                'offers.publish_status',
                'oc.title_english as category_name'
            )
            ->whereNull('offers.deleted_at')
            ->where(function($q) use ($query) {
                $q->where('offers.offer_number', 'LIKE', '%' . $query . '%')
                  ->orWhere('offers.offer_code', 'LIKE', '%' . $query . '%')
                  ->orWhere('offers.title_english', 'LIKE', '%' . $query . '%');
            })
            ->orderByRaw("
                CASE 
                    WHEN offers.offer_number LIKE ? THEN 1
                    WHEN offers.offer_code LIKE ? THEN 2
                    ELSE 3
                END
            ", [$query . '%', $query . '%'])
            ->limit(10)
            ->get();
        
        return response()->json($offers);
    }
    
    /**
     * Handle image upload, convert to WebP and resize to exact dimensions
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
        
        // Create image instance, resize maintaining aspect ratio, then add canvas for exact dimensions
        $image = Image::make($file->getRealPath())
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->resizeCanvas($width, $height, 'center', false, '#ffffff')
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
        
        $query = Offer::whereNull('deleted_at');
        
        if ($scope === 'selected' && !empty($idsArray)) {
            $query->whereIn('id', $idsArray);
        }
        
        $newStatus = $action === 'publish' ? 0 : 1;
        $count = $query->count();
        $query->update(['publish_status' => $newStatus]);
        
        $statusText = $action === 'publish' ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "{$count} offer(s) {$statusText} successfully!");
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
        
        $query = Offer::whereNull('deleted_at');
        
        if ($scope === 'selected' && !empty($idsArray)) {
            $query->whereIn('id', $idsArray);
        }
        
        $newStatus = $action === 'show' ? 0 : 1;
        $count = $query->count();
        $query->update(['home_status' => $newStatus]);
        
        $statusText = $action === 'show' ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "{$count} offer(s) {$statusText} successfully!");
    }
}

