<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use App\Models\Portfolio;
use App\Models\ShowcasePortfolio;
use Illuminate\Support\Facades\DB;

class ShowcasePortfolioController extends Controller
{
    /**
     * Get available portfolios for a showcase
     */
    public function getAvailablePortfolios($showcaseId)
    {
        try {
            $showcase = Showcase::findOrFail($showcaseId);
            
            // Get IDs of portfolios already attached to this showcase
            $attachedPortfolioIds = DB::table('showcase_portfolio')
                ->where('showcase_id', $showcaseId)
                ->pluck('portfolio_id')
                ->toArray();
            
            // Get all portfolios that are not yet attached
            // Using DB query for better performance and explicit deleted_at check
            $query = DB::table('portfolios')
                ->whereNull('deleted_at')
                ->select('id', 'title_english', 'title_arabic')
                ->orderBy('title_english');
            
            // Only add whereNotIn if there are attached portfolios
            if (!empty($attachedPortfolioIds)) {
                $query->whereNotIn('id', $attachedPortfolioIds);
            }
            
            $availablePortfolios = $query->get();
            
            return response()->json($availablePortfolios);
        } catch (\Exception $e) {
            \Log::error('Error loading available portfolios: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load portfolios',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Store a new portfolio relation
     */
    public function store(Request $request, $showcaseId)
    {
        $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id'
        ]);
        
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Check if already exists
        $exists = ShowcasePortfolio::where('showcase_id', $showcaseId)
            ->where('portfolio_id', $request->portfolio_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This portfolio is already added to the showcase.'
            ], 422);
        }
        
        // Attach the portfolio
        $showcase->portfolios()->attach($request->portfolio_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Portfolio added successfully!'
        ]);
    }
    
    /**
     * Remove a portfolio relation
     */
    public function destroy($showcaseId, $id)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        $showcasePortfolio = ShowcasePortfolio::where('showcase_id', $showcaseId)
            ->where('id', $id)
            ->firstOrFail();
        
        // Detach the portfolio
        $showcase->portfolios()->detach($showcasePortfolio->portfolio_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Portfolio removed successfully!'
        ]);
    }
}

