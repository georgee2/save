<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\PortfolioType;
use App\Models\PageBanner;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolios
     */
    public function index(Request $request)
    {
        // The public portfolio views were never built; 404 gracefully until they exist.
        abort_unless(view()->exists('pages.portfolios.index'), 404);

        // Get all portfolio types for filter
        $portfolioTypes = PortfolioType::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('name_english')
            ->get();

        // Build query for portfolios
        $query = Portfolio::with('portfolioType')
            ->where('status', 0) // Only published
            ->whereNull('deleted_at');

        // Filter by portfolio type if provided
        if ($request->has('type') && $request->type != '') {
            $query->where('portfolio_type_id', $request->type);
        }

        // Get paginated results (20 per page)
        $portfolios = $query->orderBy('created_at', 'DESC')->paginate(20);

        // Get page banner for portfolios page
        $pageBanner = PageBanner::getByTarget('portfolios');

        return view('pages.portfolios.index', compact('portfolios', 'portfolioTypes', 'pageBanner'));
    }

    /**
     * Display the specified portfolio
     */
    public function show($slug)
    {
        // The public portfolio views were never built; 404 gracefully until they exist.
        abort_unless(view()->exists('pages.portfolios.portfolio'), 404);

        $portfolio = Portfolio::where('slug', $slug)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->with(['portfolioType', 'processes', 'images'])
            ->firstOrFail();

        return view('pages.portfolios.portfolio', compact('portfolio'));
    }
}

