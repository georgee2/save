<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PageBanner;
use Illuminate\Http\Request;

class PartnerPageController extends Controller
{
    /**
     * Display the partners listing page
     */
    public function index()
    {
        // Get page banner
        $pageBanner = PageBanner::getByTarget('partners');
        
        // Get regular partners (type = 'partner')
        $partners = Partner::getPartners();
        
        return view('pages.partners.index', compact('pageBanner', 'partners'));
    }
    
    /**
     * Display a single partner page
     */
    public function show($id)
    {
        // Get the partner
        $partner = Partner::findOrFail($id);
        
        // Get other partners (excluding the current one, limit to 4)
        $otherPartners = Partner::where('id', '!=', $id)
            ->where('partner_type', '!=', 'branch')
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        return view('pages.partners.show', compact('partner', 'otherPartners'));
    }
}
