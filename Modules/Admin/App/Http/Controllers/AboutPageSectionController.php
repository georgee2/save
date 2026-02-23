<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AboutPageSection;

class AboutPageSectionController extends Controller
{
    /**
     * Display the about page sections management
     */
    public function index()
    {
        $sections = AboutPageSection::getAllSections();
        
        return view('admin::about-page-sections.index', compact('sections'));
    }

    /**
     * Update section ordering via AJAX
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orderings', []);
        
        foreach ($orders as $order) {
            AboutPageSection::where('id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Section order updated successfully!',
        ]);
    }

    /**
     * Toggle section status
     */
    public function toggleStatus($id)
    {
        $section = AboutPageSection::findOrFail($id);
        $section->status = $section->status == 0 ? 1 : 0;
        $section->save();
        
        $statusText = $section->status == 0 ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'status' => $section->status,
            'message' => "Section {$statusText} successfully!",
        ]);
    }

    /**
     * Move section up
     */
    public function moveUp($id)
    {
        $section = AboutPageSection::findOrFail($id);
        $currentOrder = $section->ordering;
        
        // Find the section above
        $aboveSection = AboutPageSection::where('ordering', '<', $currentOrder)
            ->orderBy('ordering', 'desc')
            ->first();
        
        if ($aboveSection) {
            // Swap ordering
            $section->ordering = $aboveSection->ordering;
            $aboveSection->ordering = $currentOrder;
            $section->save();
            $aboveSection->save();
        }
        
        return redirect()->route('about-page-sections.index')
            ->with('success', 'Section moved up successfully!');
    }

    /**
     * Move section down
     */
    public function moveDown($id)
    {
        $section = AboutPageSection::findOrFail($id);
        $currentOrder = $section->ordering;
        
        // Find the section below
        $belowSection = AboutPageSection::where('ordering', '>', $currentOrder)
            ->orderBy('ordering', 'asc')
            ->first();
        
        if ($belowSection) {
            // Swap ordering
            $section->ordering = $belowSection->ordering;
            $belowSection->ordering = $currentOrder;
            $section->save();
            $belowSection->save();
        }
        
        return redirect()->route('about-page-sections.index')
            ->with('success', 'Section moved down successfully!');
    }

    /**
     * Edit section details
     */
    public function edit($id)
    {
        $section = AboutPageSection::findOrFail($id);
        
        return view('admin::about-page-sections.edit', compact('section'));
    }

    /**
     * Update section details
     */
    public function update(Request $request, $id)
    {
        $section = AboutPageSection::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
        ]);
        
        $section->update($data);
        
        return redirect()->route('about-page-sections.index')
            ->with('success', 'Section updated successfully!');
    }
}
