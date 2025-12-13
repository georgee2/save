<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Fact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class FactController extends Controller
{
    protected $fact;

    public function __construct(Fact $fact)
    {
        $this->fact = $fact;
    }

    /**
     * Display a listing of facts
     */
    public function index()
    {
        $facts = $this->fact->list();
        
        return view('admin::facts.index', [
            'facts' => $facts
        ]);
    }

    /**
     * Show the form for creating a new fact
     */
    public function create()
    {
        return view('admin::facts.create');
    }

    /**
     * Store a newly created fact
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'required|string|max:100',
            'fact_number' => 'required|string|max:50',
            'icon' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ], [
            'title_english.max' => 'English title must not exceed 100 characters (approximately 3 words)',
            'title_arabic.max' => 'Arabic title must not exceed 100 characters (approximately 3 words)',
        ]);

        // Validate word count for titles
        $englishWordCount = str_word_count($data['title_english']);
        $arabicWordCount = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($englishWordCount > 3) {
            return back()->withErrors(['title_english' => 'English title must not exceed 3 words'])->withInput();
        }
        
        if ($arabicWordCount > 3) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 3 words'])->withInput();
        }

        // Handle Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(100, 100)->encode('webp', 90);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/facts/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/facts/icons/{$iconName}";
        }

        Fact::create($data);

        return redirect()->route('admin.facts.index')->with('success', 'Fact created successfully!');
    }

    /**
     * Display the specified fact
     */
    public function show($id)
    {
        $fact = Fact::findOrFail($id);
        
        return view('admin::facts.show', [
            'fact' => $fact
        ]);
    }

    /**
     * Show the form for editing the specified fact
     */
    public function edit($id)
    {
        $fact = Fact::findOrFail($id);
        
        return view('admin::facts.edit', [
            'fact' => $fact
        ]);
    }

    /**
     * Update the specified fact
     */
    public function update(Request $request, $id)
    {
        $fact = Fact::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:100',
            'title_arabic' => 'required|string|max:100',
            'fact_number' => 'required|string|max:50',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ], [
            'title_english.max' => 'English title must not exceed 100 characters (approximately 3 words)',
            'title_arabic.max' => 'Arabic title must not exceed 100 characters (approximately 3 words)',
        ]);

        // Validate word count for titles
        $englishWordCount = str_word_count($data['title_english']);
        $arabicWordCount = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($englishWordCount > 3) {
            return back()->withErrors(['title_english' => 'English title must not exceed 3 words'])->withInput();
        }
        
        if ($arabicWordCount > 3) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 3 words'])->withInput();
        }

        // Handle Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($fact->icon && Storage::disk('public')->exists($fact->icon)) {
                Storage::disk('public')->delete($fact->icon);
            }
            
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(100, 100)->encode('webp', 90);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/facts/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/facts/icons/{$iconName}";
        }

        $fact->update($data);

        return redirect()->route('admin.facts.index')->with('success', 'Fact updated successfully!');
    }

    /**
     * Remove the specified fact (soft delete)
     */
    public function destroy($id)
    {
        $fact = Fact::findOrFail($id);
        $fact->delete();

        return redirect()->route('admin.facts.index')->with('success', 'Fact moved to trash successfully!');
    }

    /**
     * Display trashed facts
     */
    public function trashed()
    {
        $facts = Fact::trashed();
        
        return view('admin::facts.trashed', [
            'facts' => $facts
        ]);
    }

    /**
     * Restore a trashed fact
     */
    public function restore($id)
    {
        $fact = Fact::withTrashed()->findOrFail($id);
        $fact->restore();

        return redirect()->route('admin.facts.trashed')->with('success', 'Fact restored successfully!');
    }

    /**
     * Permanently delete a fact
     */
    public function forceDelete($id)
    {
        $fact = Fact::withTrashed()->findOrFail($id);
        
        // Delete icon file
        if ($fact->icon && Storage::disk('public')->exists($fact->icon)) {
            Storage::disk('public')->delete($fact->icon);
        }
        
        $fact->forceDelete();

        return redirect()->route('admin.facts.trashed')->with('success', 'Fact permanently deleted!');
    }

    /**
     * Toggle fact status (Active/Not Active)
     */
    public function toggleStatus($id)
    {
        $fact = Fact::findOrFail($id);
        $fact->status = $fact->status == 0 ? 1 : 0;
        $fact->save();

        $statusText = $fact->status == 0 ? 'activated' : 'deactivated';
        return redirect()->route('admin.facts.index')->with('success', "Fact {$statusText} successfully!");
    }

    /**
     * Update facts ordering via AJAX
     */
    public function updateOrders(Request $request)
    {
        try {
            $orders = json_decode($request->input('orders'), true);
            
            if (!is_array($orders)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid orders data'
                ], 400);
            }

            foreach ($orders as $order) {
                Fact::where('id', $order['id'])->update(['ordering' => $order['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Facts order updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }
}

