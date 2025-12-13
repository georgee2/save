<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use App\Models\News;
use App\Models\ShowcaseNew;
use Illuminate\Support\Facades\DB;

class ShowcaseNewController extends Controller
{
    /**
     * Get available news for a showcase
     */
    public function getAvailableNews($showcaseId)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Get IDs of news already attached to this showcase
        $attachedNewsIds = $showcase->news()->pluck('news.id')->toArray();
        
        // Get all news that are not yet attached
        $availableNews = News::whereNotIn('id', $attachedNewsIds)
            ->select('id', 'title_english', 'title_arabic')
            ->orderBy('title_english')
            ->get();
        
        return response()->json($availableNews);
    }
    
    /**
     * Store a new news relation
     */
    public function store(Request $request, $showcaseId)
    {
        $request->validate([
            'new_id' => 'required|exists:news,id'
        ]);
        
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Check if already exists
        $exists = ShowcaseNew::where('showcase_id', $showcaseId)
            ->where('new_id', $request->new_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This news item is already added to the showcase.'
            ], 422);
        }
        
        // Attach the news
        $showcase->news()->attach($request->new_id);
        
        return response()->json([
            'success' => true,
            'message' => 'News added successfully!'
        ]);
    }
    
    /**
     * Remove a news relation
     */
    public function destroy($showcaseId, $id)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        $showcaseNew = ShowcaseNew::where('showcase_id', $showcaseId)
            ->where('id', $id)
            ->firstOrFail();
        
        // Detach the news
        $showcase->news()->detach($showcaseNew->new_id);
        
        return response()->json([
            'success' => true,
            'message' => 'News removed successfully!'
        ]);
    }
}

