<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PartnerController extends Controller
{
    protected $partner;

    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Display a listing of partners
     */
    public function index()
    {
        $partners = $this->partner->list();
        
        return view('admin::partners.index', [
            'partners' => $partners
        ]);
    }

    /**
     * Show the form for creating a new partner
     */
    public function create()
    {
        return view('admin::partners.create');
    }

    /**
     * Store a newly created partner
     */
    public function store(Request $request)
    {
        // Conditional validation based on partner type
        $isGovernment = $request->partner_type === 'government';
        
        $rules = [
            'partner_type' => 'required|in:partner,branch,government',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'logo_english' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_arabic' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ];
        
        // For non-government partners, add additional required/optional fields
        if (!$isGovernment) {
            $rules = array_merge($rules, [
                'tax_number' => 'nullable|string|max:255',
                'website_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'facebook_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'map_url' => 'nullable|string',
                'location_text_english' => 'nullable|string',
                'location_text_arabic' => 'nullable|string',
                'office_number' => 'nullable|string|max:255',
                'mobile' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'about_english' => 'nullable|string',
                'about_arabic' => 'nullable|string',
                'mission_english' => 'nullable|string',
                'mission_arabic' => 'nullable|string',
                'vision_english' => 'nullable|string',
                'vision_arabic' => 'nullable|string',
                'seo_tags' => 'nullable|string|max:255',
                'seo_description_english' => 'nullable|string',
                'seo_description_arabic' => 'nullable|string',
                'opening_hours' => 'nullable|string|max:255',
            ]);
        }
        
        $data = $request->validate($rules);
        
        // For government partners, set email and mobile to null
        if ($isGovernment) {
            $data['email'] = null;
            $data['mobile'] = null;
        }

        // Handle logo_english upload - resize and convert to WebP
        if ($request->hasFile('logo_english')) {
            $logoEnglish = $request->file('logo_english');
            $logoEnglishName = time() . '_logo_en_' . uniqid() . '.webp';
            $logoEnglishPath = 'partners/logos/' . $logoEnglishName;
            
            // Process image: resize to max 200x80 while maintaining aspect ratio, convert to WebP
            $image = Image::make($logoEnglish);
            $image->resize(200, 80, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($logoEnglishPath, $image->encode('webp', 90)->__toString());
            $data['logo_english'] = '/' . $logoEnglishPath;
        }

        // Handle logo_arabic upload - resize and convert to WebP
        if ($request->hasFile('logo_arabic')) {
            $logoArabic = $request->file('logo_arabic');
            $logoArabicName = time() . '_logo_ar_' . uniqid() . '.webp';
            $logoArabicPath = 'partners/logos/' . $logoArabicName;
            
            // Process image: resize to max 200x80 while maintaining aspect ratio, convert to WebP
            $image = Image::make($logoArabic);
            $image->resize(200, 80, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($logoArabicPath, $image->encode('webp', 90)->__toString());
            $data['logo_arabic'] = '/' . $logoArabicPath;
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        Partner::create($data);

        return redirect()->route('partner.index')->with('success', 'Partner created successfully!');
    }

    /**
     * Show the form for editing partner
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        
        return view('admin::partners.edit', [
            'partner' => $partner
        ]);
    }

    /**
     * Update the specified partner
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        
        // Conditional validation based on partner type
        $isGovernment = $request->partner_type === 'government';
        
        $rules = [
            'partner_type' => 'required|in:partner,branch,government',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'logo_english' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_arabic' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ];
        
        // For non-government partners, add additional required/optional fields
        if (!$isGovernment) {
            $rules = array_merge($rules, [
                'tax_number' => 'nullable|string|max:255',
                'website_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'facebook_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'map_url' => 'nullable|string',
                'location_text_english' => 'nullable|string',
                'location_text_arabic' => 'nullable|string',
                'office_number' => 'nullable|string|max:255',
                'mobile' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'about_english' => 'nullable|string',
                'about_arabic' => 'nullable|string',
                'mission_english' => 'nullable|string',
                'mission_arabic' => 'nullable|string',
                'vision_english' => 'nullable|string',
                'vision_arabic' => 'nullable|string',
                'seo_tags' => 'nullable|string|max:255',
                'seo_description_english' => 'nullable|string',
                'seo_description_arabic' => 'nullable|string',
                'opening_hours' => 'nullable|string|max:255',
            ]);
        }
        
        $data = $request->validate($rules);
        
        // For government partners, set email and mobile to null and clear other fields
        if ($isGovernment) {
            $data['email'] = null;
            $data['mobile'] = null;
            $data['tax_number'] = null;
            $data['website_url'] = null;
            $data['instagram_url'] = null;
            $data['facebook_url'] = null;
            $data['linkedin_url'] = null;
            $data['twitter_url'] = null;
            $data['map_url'] = null;
            $data['location_text_english'] = null;
            $data['location_text_arabic'] = null;
            $data['office_number'] = null;
            $data['about_english'] = null;
            $data['about_arabic'] = null;
            $data['mission_english'] = null;
            $data['mission_arabic'] = null;
            $data['vision_english'] = null;
            $data['vision_arabic'] = null;
            $data['seo_tags'] = null;
            $data['seo_description_english'] = null;
            $data['seo_description_arabic'] = null;
            $data['opening_hours'] = null;
        }

        // Handle logo_english upload - resize and convert to WebP
        if ($request->hasFile('logo_english')) {
            // Delete old logo
            if ($partner->logo_english) {
                Storage::disk('public')->delete(ltrim($partner->logo_english, '/'));
            }
            $logoEnglish = $request->file('logo_english');
            $logoEnglishName = time() . '_logo_en_' . uniqid() . '.webp';
            $logoEnglishPath = 'partners/logos/' . $logoEnglishName;
            
            // Process image: resize to max 200x80 while maintaining aspect ratio, convert to WebP
            $image = Image::make($logoEnglish);
            $image->resize(200, 80, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($logoEnglishPath, $image->encode('webp', 90)->__toString());
            $data['logo_english'] = '/' . $logoEnglishPath;
        }

        // Handle logo_arabic upload - resize and convert to WebP
        if ($request->hasFile('logo_arabic')) {
            // Delete old logo
            if ($partner->logo_arabic) {
                Storage::disk('public')->delete(ltrim($partner->logo_arabic, '/'));
            }
            $logoArabic = $request->file('logo_arabic');
            $logoArabicName = time() . '_logo_ar_' . uniqid() . '.webp';
            $logoArabicPath = 'partners/logos/' . $logoArabicName;
            
            // Process image: resize to max 200x80 while maintaining aspect ratio, convert to WebP
            $image = Image::make($logoArabic);
            $image->resize(200, 80, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Save as WebP
            Storage::disk('public')->put($logoArabicPath, $image->encode('webp', 90)->__toString());
            $data['logo_arabic'] = '/' . $logoArabicPath;
        }

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        $partner->update($data);

        return redirect()->route('partner.index')->with('success', 'Partner updated successfully!');
    }

    /**
     * Soft delete the partner
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('partner.index')->with('success', 'Partner deleted successfully!');
    }

    /**
     * Display trashed partners
     */
    public function trashed()
    {
        $partners = $this->partner->trashed();
        
        return view('admin::partners.trashed', [
            'partners' => $partners
        ]);
    }

    /**
     * Restore trashed partner
     */
    public function restore($id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);
        $partner->restore();

        return redirect()->route('partner.trashed')->with('success', 'Partner restored successfully!');
    }

    /**
     * Display partner profile
     */
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        
        return view('admin::partners.show', [
            'partner' => $partner
        ]);
    }
    
    /**
     * Update display order for partners/branches
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:partners,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);
        
        foreach ($request->orders as $item) {
            Partner::where('id', $item['id'])->update(['display_order' => $item['order']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}

