<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeBlock;

class HomeBlockController extends Controller
{
    protected $homeBlock;

    public function __construct(HomeBlock $homeBlock)
    {
        $this->homeBlock = $homeBlock;
    }

    /**
     * Display a listing of home blocks
     */
    public function index()
    {
        $homeBlocks = $this->homeBlock->list();
        
        return view('admin::homeblocks.index', [
            'homeBlocks' => $homeBlocks
        ]);
    }

    /**
     * Show the form for creating a new home block
     */
    public function create()
    {
        return view('admin::homeblocks.create');
    }

    /**
     * Store a newly created home block
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'required|string|max:100',
            'subtitle_english' => 'nullable|string|max:75',
            'subtitle_arabic' => 'nullable|string|max:75',
            'button_text_english' => 'nullable|string|max:50',
            'button_text_arabic' => 'nullable|string|max:50',
            'url_english' => 'nullable|string|max:255',
            'url_arabic' => 'nullable|string|max:255',
            'location' => 'required|in:about_section,why_choose_us',
            'status' => 'nullable|in:0,1',
        ]);

        $data['status'] = $request->input('status', 0);

        HomeBlock::create($data);

        return redirect()->route('homeblock.index')->with('success', 'Home block created successfully!');
    }

    /**
     * Show the form for editing home block
     */
    public function edit($id)
    {
        $homeBlock = HomeBlock::findOrFail($id);
        
        return view('admin::homeblocks.edit', [
            'homeBlock' => $homeBlock
        ]);
    }

    /**
     * Update the specified home block
     */
    public function update(Request $request, $id)
    {
        $homeBlock = HomeBlock::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'required|string|max:100',
            'subtitle_english' => 'nullable|string|max:75',
            'subtitle_arabic' => 'nullable|string|max:75',
            'button_text_english' => 'nullable|string|max:50',
            'button_text_arabic' => 'nullable|string|max:50',
            'url_english' => 'nullable|string|max:255',
            'url_arabic' => 'nullable|string|max:255',
            'location' => 'required|in:about_section,why_choose_us',
            'status' => 'nullable|in:0,1',
        ]);

        $data['status'] = $request->input('status', 0);

        $homeBlock->update($data);

        return redirect()->route('homeblock.index')->with('success', 'Home block updated successfully!');
    }

    /**
     * Soft delete the home block
     */
    public function destroy($id)
    {
        $homeBlock = HomeBlock::findOrFail($id);
        $homeBlock->delete();

        return redirect()->route('homeblock.index')->with('success', 'Home block deleted successfully!');
    }

    /**
     * Display trashed home blocks
     */
    public function trashed()
    {
        $homeBlocks = $this->homeBlock->trashed();
        
        return view('admin::homeblocks.trashed', [
            'homeBlocks' => $homeBlocks
        ]);
    }

    /**
     * Restore trashed home block
     */
    public function restore($id)
    {
        $homeBlock = HomeBlock::withTrashed()->findOrFail($id);
        $homeBlock->restore();

        return redirect()->route('homeblock.trashed')->with('success', 'Home block restored successfully!');
    }
}

