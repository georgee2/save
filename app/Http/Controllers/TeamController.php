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
        // Get board of directors ordered by board_order
        $boardMembers = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->where('is_board_director', true)
            ->orderBy('board_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Get regular team members ordered by display_order
        $teamMembers = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->where('is_board_director', false)
            ->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Get page banner for team page
        $pageBanner = PageBanner::getByTarget('team');

        return view('pages.team.index', compact('boardMembers', 'teamMembers', 'pageBanner'));
    }

    /**
     * Display board of directors page.
     */
    public function board()
    {
        // Get board of directors ordered by board_order
        $boardMembers = Team::with(['jobTitle', 'rank'])
            ->whereNull('deleted_at')
            ->where('is_board_director', true)
            ->orderBy('board_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Get page banner for team page
        $pageBanner = PageBanner::getByTarget('team');

        return view('pages.team.board', compact('boardMembers', 'pageBanner'));
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

