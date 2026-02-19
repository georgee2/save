<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutInformation;
use App\Models\ContactInformation;
use App\Models\AboutFeature;
use App\Models\AboutCustomBlock;
use App\Models\Team;
use App\Models\Partner;
use App\Models\Certificate;

class AboutController extends Controller
{
    /**
     * Display the about page
     */
    public function index()
    {
        $aboutInfo = AboutInformation::getAboutInfo();
        $contactInfo = ContactInformation::getContactInfo();
        $features = AboutFeature::getActive();
        $customBlocks = AboutCustomBlock::getActive();
        
        // Fetch board of directors ordered by board_order
        $boardMembers = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->where('is_board_director', true)
            ->orderBy('board_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Fetch regular team members ordered by display_order
        $teamMembers = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->where('is_board_director', false)
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Combine board first, then team for the slider
        $allTeamMembers = $boardMembers->concat($teamMembers);
        
        // Fetch government partners for slider
        $governmentPartners = Partner::getGovernmentPartners();
        
        // Fetch published certificates
        $certificates = Certificate::getPublished();
        
        return view('pages.about.index', compact('aboutInfo', 'contactInfo', 'features', 'customBlocks', 'allTeamMembers', 'governmentPartners', 'certificates'));
    }
}
