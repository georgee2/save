<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
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
            'logo_english' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_arabic' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
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

        // Handle logo_english upload
        if ($request->hasFile('logo_english')) {
            $logoEnglish = $request->file('logo_english');
            $logoEnglishName = time() . '_logo_en_' . uniqid() . '.' . $logoEnglish->getClientOriginalExtension();
            $logoEnglishPath = $logoEnglish->storeAs('partners/logos', $logoEnglishName, 'public');
            $data['logo_english'] = '/' . $logoEnglishPath;
        }

        // Handle logo_arabic upload
        if ($request->hasFile('logo_arabic')) {
            $logoArabic = $request->file('logo_arabic');
            $logoArabicName = time() . '_logo_ar_' . uniqid() . '.' . $logoArabic->getClientOriginalExtension();
            $logoArabicPath = $logoArabic->storeAs('partners/logos', $logoArabicName, 'public');
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
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
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
            'logo_english' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_arabic' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
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

        // Handle logo_english upload
        if ($request->hasFile('logo_english')) {
            // Delete old logo
            if ($partner->logo_english) {
                Storage::disk('public')->delete(ltrim($partner->logo_english, '/'));
            }
            $logoEnglish = $request->file('logo_english');
            $logoEnglishName = time() . '_logo_en_' . uniqid() . '.' . $logoEnglish->getClientOriginalExtension();
            $logoEnglishPath = $logoEnglish->storeAs('partners/logos', $logoEnglishName, 'public');
            $data['logo_english'] = '/' . $logoEnglishPath;
        }

        // Handle logo_arabic upload
        if ($request->hasFile('logo_arabic')) {
            // Delete old logo
            if ($partner->logo_arabic) {
                Storage::disk('public')->delete(ltrim($partner->logo_arabic, '/'));
            }
            $logoArabic = $request->file('logo_arabic');
            $logoArabicName = time() . '_logo_ar_' . uniqid() . '.' . $logoArabic->getClientOriginalExtension();
            $logoArabicPath = $logoArabic->storeAs('partners/logos', $logoArabicName, 'public');
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
}

