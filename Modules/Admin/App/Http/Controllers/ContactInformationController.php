<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ContactInformation;

class ContactInformationController extends Controller
{
    /**
     * Display and edit contact information (single view)
     */
    public function index()
    {
        $contactInfo = ContactInformation::getContactInfo();
        return view('admin::contact-information.index', compact('contactInfo'));
    }
    
    /**
     * Update contact information
     */
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:50',
            'secondary_mobile' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
            'location_text_english' => 'nullable|string|max:255',
            'location_text_arabic' => 'nullable|string|max:255',
            'location_map' => 'nullable|string',
            'footer_bio_english' => 'nullable|string|max:250',
            'footer_bio_arabic' => 'nullable|string|max:250',
            'tags' => 'nullable', // Tagify JSON format
            'seo_description_english' => 'nullable|string|max:500',
            'seo_description_arabic' => 'nullable|string|max:500',
        ]);
        
        $data = $request->except('tags');
        
        // Process tags using the helper function (same as ServiceController)
        if ($request->tags != null) {
            $data['tags'] = tags($request->tags);
        } else {
            $data['tags'] = null;
        }
        
        ContactInformation::updateContactInfo($data);
        
        return redirect()->route('contact-information.index')->with('success', 'Contact Information updated successfully!');
    }
}

