<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Rank;

class RankController extends Controller
{
    protected $rank;

    public function __construct(Rank $rank)
    {
        $this->rank = $rank;
    }

    /**
     * Display a listing of ranks
     */
    public function index()
    {
        $ranks = $this->rank->list();
        
        return view('basicdata::ranks.index', [
            'ranks' => $ranks
        ]);
    }

    /**
     * Show the form for creating a new rank
     */
    public function create()
    {
        return view('basicdata::ranks.create');
    }

    /**
     * Store a newly created rank
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
        ]);
        
        $data['is_board_director'] = $request->has('is_board_director') ? true : false;

        Rank::create($data);

        return redirect()->route('rank.index')->with('success', 'Rank created successfully!');
    }

    /**
     * Show the form for editing rank
     */
    public function edit($id)
    {
        $rank = Rank::findOrFail($id);
        
        return view('basicdata::ranks.edit', [
            'rank' => $rank
        ]);
    }

    /**
     * Update the specified rank
     */
    public function update(Request $request, $id)
    {
        $rank = Rank::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
        ]);
        
        $data['is_board_director'] = $request->has('is_board_director') ? true : false;

        $rank->update($data);

        return redirect()->route('rank.index')->with('success', 'Rank updated successfully!');
    }

    /**
     * Soft delete the rank
     */
    public function destroy($id)
    {
        $rank = Rank::findOrFail($id);
        $rank->delete();

        return redirect()->route('rank.index')->with('success', 'Rank deleted successfully!');
    }

    /**
     * Display trashed ranks
     */
    public function trashed()
    {
        $ranks = $this->rank->trashed();
        
        return view('basicdata::ranks.trashed', [
            'ranks' => $ranks
        ]);
    }

    /**
     * Restore trashed rank
     */
    public function restore($id)
    {
        $rank = Rank::withTrashed()->findOrFail($id);
        $rank->restore();

        return redirect()->route('rank.trashed')->with('success', 'Rank restored successfully!');
    }
}

