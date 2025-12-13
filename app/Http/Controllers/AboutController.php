<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutInformation;
use App\Models\ContactInformation;
use App\Models\AboutFeature;
use App\Models\Team;
use App\Models\AboutCustomBlock;

class AboutController extends Controller
{
    /**
     * Display the about page
     */
    public function index()
    {
        // Get about information
        $aboutInfo = AboutInformation::getAboutInfo();
        
        // Get contact information for phone numbers
        $contactInfo = ContactInformation::getContactInfo();
        
        // Get active about features
        $features = AboutFeature::getActive();
        
        // Get team members with job titles
        $teamMembers = Team::with('jobTitle')->get();
        
        // Get active custom blocks
        $customBlocks = AboutCustomBlock::getActive();
        
        return view('pages.about.about', compact('aboutInfo', 'contactInfo', 'features', 'teamMembers', 'customBlocks'));
    }
}

