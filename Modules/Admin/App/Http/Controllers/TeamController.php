<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Team;
use App\Models\JobTitle;
use App\Models\Rank;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class TeamController extends Controller
{
    protected $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Display a listing of team members
     */
    public function index()
    {
        $teams = $this->team->list();
        $regularMembers = $this->team->getRegularMembers();
        $boardMembers = $this->team->getBoardMembers();
        
        return view('admin::teams.index', [
            'teams' => $teams,
            'regularMembers' => $regularMembers,
            'boardMembers' => $boardMembers
        ]);
    }

    /**
     * Show the form for creating a new team member
     */
    public function create()
    {
        $jobTitles = JobTitle::list();
        $ranks = Rank::list();
        
        return view('admin::teams.create', [
            'jobTitles' => $jobTitles,
            'ranks' => $ranks
        ]);
    }

    /**
     * Store a newly created team member
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'rank_id' => 'required|exists:ranks,id',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:255',
            'main_image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'work_experience_english' => 'nullable|string',
            'work_experience_arabic' => 'nullable|string',
        ]);

        // Handle Main Image Upload (400x400)
        if ($request->hasFile('main_image')) {
            $mainImageFile = $request->file('main_image');
            $image = Image::make($mainImageFile)->resize(308, 375)->encode('webp', 90);
            $mainImageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/main/' . $mainImageName, (string) $image);
            $data['main_image'] = "/uploads/teams/main/{$mainImageName}";
            
            // Create Icon (100x100) from the same image
            $iconImage = Image::make($mainImageFile)->resize(100, 100)->encode('webp', 90);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/icons/' . $iconName, (string) $iconImage);
            $data['icon'] = "/uploads/teams/icons/{$iconName}";
            
            // Create Page Image (600x600) from the same image
            $pageImage = Image::make($mainImageFile)->resize(645, 700)->encode('webp', 90);
            $pageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/pages/' . $pageName, (string) $pageImage);
            $data['page_image'] = "/uploads/teams/pages/{$pageName}";
        }

        // Handle Board Director flag
        $data['is_board_director'] = $request->has('is_board_director') ? true : false;
        
        // Set initial order
        if ($data['is_board_director']) {
            $maxBoardOrder = Team::where('is_board_director', true)->max('board_order') ?? 0;
            $data['board_order'] = $maxBoardOrder + 1;
        } else {
            $maxDisplayOrder = Team::where('is_board_director', false)->max('display_order') ?? 0;
            $data['display_order'] = $maxDisplayOrder + 1;
        }

        Team::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully!');
    }

    /**
     * Display the specified team member
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        
        return view('admin::teams.show', [
            'team' => $team
        ]);
    }

    /**
     * Show the form for editing team member
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $jobTitles = JobTitle::list();
        $ranks = Rank::list();
        
        return view('admin::teams.edit', [
            'team' => $team,
            'jobTitles' => $jobTitles,
            'ranks' => $ranks
        ]);
    }

    /**
     * Update the specified team member
     */
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'job_title_id' => 'required|exists:job_titles,id',
            'rank_id' => 'required|exists:ranks,id',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:255',
            'main_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'work_experience_english' => 'nullable|string',
            'work_experience_arabic' => 'nullable|string',
        ]);

        // Handle Main Image Upload if new image is provided
        if ($request->hasFile('main_image')) {
            // Delete old images
            if ($team->main_image) {
                Storage::disk('public')->delete(ltrim($team->main_image, '/'));
            }
            if ($team->icon) {
                Storage::disk('public')->delete(ltrim($team->icon, '/'));
            }
            if ($team->page_image) {
                Storage::disk('public')->delete(ltrim($team->page_image, '/'));
            }
            
            // Upload new Main Image (400x400)
            $mainImageFile = $request->file('main_image');
            $image = Image::make($mainImageFile)->resize(400, 400)->encode('webp', 90);
            $mainImageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/main/' . $mainImageName, (string) $image);
            $data['main_image'] = "/uploads/teams/main/{$mainImageName}";
            
            // Create Icon (100x100) from the same image
            $iconImage = Image::make($mainImageFile)->resize(100, 100)->encode('webp', 90);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/icons/' . $iconName, (string) $iconImage);
            $data['icon'] = "/uploads/teams/icons/{$iconName}";
            
            // Create Page Image (600x600) from the same image
            $pageImage = Image::make($mainImageFile)->resize(600, 600)->encode('webp', 90);
            $pageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/teams/pages/' . $pageName, (string) $pageImage);
            $data['page_image'] = "/uploads/teams/pages/{$pageName}";
        }

        // Handle Board Director flag
        $wasBoardDirector = $team->is_board_director;
        $data['is_board_director'] = $request->has('is_board_director') ? true : false;
        
        // If status changed, update order accordingly
        if ($wasBoardDirector != $data['is_board_director']) {
            if ($data['is_board_director']) {
                $maxBoardOrder = Team::where('is_board_director', true)->max('board_order') ?? 0;
                $data['board_order'] = $maxBoardOrder + 1;
                $data['display_order'] = 0;
            } else {
                $maxDisplayOrder = Team::where('is_board_director', false)->max('display_order') ?? 0;
                $data['display_order'] = $maxDisplayOrder + 1;
                $data['board_order'] = 0;
            }
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully!');
    }
    
    /**
     * Update display order for regular team members
     */
    public function updateDisplayOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            Team::where('id', $order['id'])->update(['display_order' => $order['position']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Display order updated successfully!']);
    }
    
    /**
     * Update board order for board of directors
     */
    public function updateBoardOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            Team::where('id', $order['id'])->update(['board_order' => $order['position']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Board order updated successfully!']);
    }

    /**
     * Soft delete the team member
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully!');
    }

    /**
     * Display trashed team members
     */
    public function trashed()
    {
        $teams = $this->team->trashed();
        
        return view('admin::teams.trashed', [
            'teams' => $teams
        ]);
    }

    /**
     * Restore trashed team member
     */
    public function restore($id)
    {
        $team = Team::withTrashed()->findOrFail($id);
        $team->restore();

        return redirect()->route('admin.team.trashed')->with('success', 'Team member restored successfully!');
    }
}

