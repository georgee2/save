<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInformation;
use App\Models\ContactUs;
use App\Models\Service;
use App\Models\PageBanner;
use App\Models\Partner;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        // Get contact information
        $contactInfo = ContactInformation::getContactInfo();
        
        // Get main services for the dropdown
        $services = Service::where('deleted_at', null)
                          ->where('is_sub_service', 0)
                          ->where('publish_status', 0)
                          ->select('id', 'title_english', 'title_arabic')
                          ->get();

        // Get page banner for contact page
        $pageBanner = PageBanner::getByTarget('contact');
        
        // Get branches
        $branches = Partner::getBranches();

        return view('pages.contact.contact', compact('contactInfo', 'services', 'pageBanner', 'branches'));
    }

    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
            'source' => 'nullable|string|max:50',
        ]);

        ContactUs::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'service_id' => $request->service_id,
            'status' => 'Pending',
        ]);

        $successMessage = app()->getLocale() == 'en' 
            ? 'Your message has been sent successfully! We will contact you soon.' 
            : 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.';

        // Handle AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage
            ]);
        }

        return back()->with('success', $successMessage);
    }
}

