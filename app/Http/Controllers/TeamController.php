<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\PageBanner;

class TeamController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index()
    {
        // Get all team members with their job titles and ranks
        $teams = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get page banner for team page
        $pageBanner = PageBanner::getByTarget('team');

        return view('pages.team.index', compact('teams', 'pageBanner'));
    }

    /**
     * Display the specified team member.
     */
    public function show($id)
    {
        // Get team member with their job title and rank
        $team = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->findOrFail($id);

        return view('pages.team.member', compact('team'));
    }
}

