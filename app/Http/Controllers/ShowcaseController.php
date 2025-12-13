<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showcase;
use App\Models\PageBanner;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of showcases
     */
    public function index()
    {
        $showcases = Showcase::where('status', 'active') // Only active showcases
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->paginate(9);

        // Get page banner for showcases page
        $pageBanner = PageBanner::getByTarget('showcases');

        return view('pages.showcases.index', compact('showcases', 'pageBanner'));
    }

    /**
     * Display the specified showcase
     */
    public function show($id)
    {
        $showcase = Showcase::where('id', $id)
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->with([
                'services',
                'projects',
                'portfolios.portfolioType',
                'teams.jobTitle',
                'news'
            ])
            ->firstOrFail();

        return view('pages.showcases.showcase', compact('showcase'));
    }
}

