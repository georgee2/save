<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeSection;

class HomeSectionController extends Controller
{
    protected $homeSection;

    public function __construct(HomeSection $homeSection)
    {
        $this->homeSection = $homeSection;
    }

    /**
     * Display a listing of home sections
     */
    public function index()
    {
        $sections = HomeSection::list();
        return view('admin::home-sections.index', compact('sections'));
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit($id)
    {
        $section = HomeSection::findOrFail($id);
        return view('admin::home-sections.edit', compact('section'));
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, $id)
    {
        $section = HomeSection::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'show_divider' => 'required|in:0,1',
            'description' => 'nullable|string|max:500',
        ]);

        $section->update($data);

        return redirect()->route('home-sections.index')->with('success', 'Home section updated successfully!');
    }

    /**
     * Toggle section status (active/inactive)
     */
    public function toggleStatus($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->toggleStatus();
        
        $statusText = $section->status == 0 ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Section {$statusText} successfully!");
    }

    /**
     * Toggle show divider
     */
    public function toggleDivider($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->toggleDivider();
        
        $dividerText = $section->show_divider == 0 ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Divider {$dividerText} successfully!");
    }

    /**
     * Update ordering via AJAX (drag and drop)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orderings' => 'required|array',
            'orderings.*.id' => 'required|integer|exists:home_sections,id',
            'orderings.*.ordering' => 'required|integer|min:0',
        ]);

        foreach ($request->orderings as $item) {
            HomeSection::where('id', $item['id'])->update(['ordering' => $item['ordering']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }

    /**
     * Move section up
     */
    public function moveUp($id)
    {
        $section = HomeSection::findOrFail($id);
        $previousSection = HomeSection::where('ordering', '<', $section->ordering)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'desc')
            ->first();

        if ($previousSection) {
            $tempOrder = $section->ordering;
            $section->ordering = $previousSection->ordering;
            $previousSection->ordering = $tempOrder;
            $section->save();
            $previousSection->save();
        }

        return redirect()->back()->with('success', 'Section moved up successfully!');
    }

    /**
     * Move section down
     */
    public function moveDown($id)
    {
        $section = HomeSection::findOrFail($id);
        $nextSection = HomeSection::where('ordering', '>', $section->ordering)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->first();

        if ($nextSection) {
            $tempOrder = $section->ordering;
            $section->ordering = $nextSection->ordering;
            $nextSection->ordering = $tempOrder;
            $section->save();
            $nextSection->save();
        }

        return redirect()->back()->with('success', 'Section moved down successfully!');
    }

    /**
     * Soft delete a section
     */
    public function destroy($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->delete();

        return redirect()->route('home-sections.index')->with('success', 'Home section deleted successfully!');
    }

    /**
     * Display trashed sections
     */
    public function trashed()
    {
        $sections = HomeSection::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin::home-sections.trashed', compact('sections'));
    }

    /**
     * Restore a trashed section
     */
    public function restore($id)
    {
        $section = HomeSection::withTrashed()->findOrFail($id);
        $section->restore();

        return redirect()->route('home-sections.trashed')->with('success', 'Home section restored successfully!');
    }
}
