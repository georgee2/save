<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutInformation;
use App\Models\ContactInformation;
use App\Models\AboutFeature;
use App\Models\AboutCustomBlock;

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
        
        return view('pages.about.index', compact('aboutInfo', 'contactInfo', 'features', 'customBlocks'));
    }
}
