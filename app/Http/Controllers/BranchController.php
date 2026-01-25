<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\PageBanner;
use App\Models\AboutInformation;

class BranchController extends Controller
{
    /**
     * Display a listing of branches.
     */
    public function index()
    {
        // Get branches ordered by display_order
        $branches = Partner::getBranches();

        // Get page banner for branches page
        $pageBanner = PageBanner::getByTarget('branches');
        
        // Get about information (for company profile download)
        $aboutInfo = AboutInformation::getAboutInfo();

        return view('pages.branches.index', compact('branches', 'pageBanner', 'aboutInfo'));
    }
    
    /**
     * Display the specified branch.
     */
    public function show($id)
    {
        // Get branch by ID
        $branch = Partner::where('partner_type', 'branch')
            ->whereNull('deleted_at')
            ->findOrFail($id);
        
        // Get other branches (excluding current one)
        $otherBranches = Partner::where('partner_type', 'branch')
            ->whereNull('deleted_at')
            ->where('id', '!=', $id)
            ->orderBy('display_order', 'asc')
            ->limit(5)
            ->get();

        return view('pages.branches.show', compact('branch', 'otherBranches'));
    }
}

