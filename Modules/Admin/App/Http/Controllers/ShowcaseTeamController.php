<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use App\Models\Team;
use App\Models\ShowcaseTeam;
use Illuminate\Support\Facades\DB;

class ShowcaseTeamController extends Controller
{
    /**
     * Get available team members for a showcase
     */
    public function getAvailableTeam($showcaseId)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Get IDs of team members already attached to this showcase
        $attachedTeamIds = $showcase->teams()->pluck('teams.id')->toArray();
        
        // Get all team members that are not yet attached
        $availableTeam = Team::whereNotIn('id', $attachedTeamIds)
            ->select('id', 'name_english', 'name_arabic')
            ->orderBy('name_english')
            ->get();
        
        return response()->json($availableTeam);
    }
    
    /**
     * Store a new team member relation
     */
    public function store(Request $request, $showcaseId)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id'
        ]);
        
        $showcase = Showcase::findOrFail($showcaseId);
        
        // Check if already exists
        $exists = ShowcaseTeam::where('showcase_id', $showcaseId)
            ->where('team_id', $request->team_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This team member is already added to the showcase.'
            ], 422);
        }
        
        // Attach the team member
        $showcase->teams()->attach($request->team_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Team member added successfully!'
        ]);
    }
    
    /**
     * Remove a team member relation
     */
    public function destroy($showcaseId, $id)
    {
        $showcase = Showcase::findOrFail($showcaseId);
        
        $showcaseTeam = ShowcaseTeam::where('showcase_id', $showcaseId)
            ->where('id', $id)
            ->firstOrFail();
        
        // Detach the team member
        $showcase->teams()->detach($showcaseTeam->team_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Team member removed successfully!'
        ]);
    }
}

