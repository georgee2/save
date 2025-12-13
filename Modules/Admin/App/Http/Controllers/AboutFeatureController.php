<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AboutFeature;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AboutFeatureController extends Controller
{
    /**
     * Display a listing of about features
     */
    public function index()
    {
        $features = AboutFeature::list();
        return view('admin::about-features.index', compact('features'));
    }
    
    /**
     * Show the form for creating a new feature
     */
    public function create()
    {
        return view('admin::about-features.create');
    }
    
    /**
     * Store a newly created feature
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1500',
            'description_arabic' => 'required|string|max:1500',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('icon');
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            $data['icon'] = $this->handleIconUpload($request->file('icon'));
        }
        
        AboutFeature::create($data);
        
        return redirect()->route('about-feature.index')->with('success', 'About Feature created successfully!');
    }
    
    /**
     * Show the form for editing the specified feature
     */
    public function edit($id)
    {
        $feature = AboutFeature::findOrFail($id);
        return view('admin::about-features.edit', compact('feature'));
    }
    
    /**
     * Update the specified feature
     */
    public function update(Request $request, $id)
    {
        $feature = AboutFeature::findOrFail($id);
        
        $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1500',
            'description_arabic' => 'required|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('icon');
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($feature->icon && Storage::exists('public' . $feature->icon)) {
                Storage::delete('public' . $feature->icon);
            }
            
            $data['icon'] = $this->handleIconUpload($request->file('icon'));
        }
        
        $feature->update($data);
        
        return redirect()->route('about-feature.index')->with('success', 'About Feature updated successfully!');
    }
    
    /**
     * Soft delete the feature
     */
    public function destroy($id)
    {
        $feature = AboutFeature::findOrFail($id);
        $feature->delete();
        
        return redirect()->route('about-feature.index')->with('success', 'About Feature deleted successfully!');
    }
    
    /**
     * Display trashed features
     */
    public function trashed()
    {
        $features = AboutFeature::trashed();
        return view('admin::about-features.trashed', compact('features'));
    }
    
    /**
     * Restore trashed feature
     */
    public function restore($id)
    {
        $feature = AboutFeature::withTrashed()->findOrFail($id);
        $feature->restore();
        
        return redirect()->route('about-feature.trashed')->with('success', 'About Feature restored successfully!');
    }
    
    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        $feature = AboutFeature::findOrFail($id);
        $feature->status = $feature->status == 0 ? 1 : 0;
        $feature->save();
        
        $status = $feature->status == 0 ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "About Feature {$status} successfully!");
    }
    
    /**
     * Handle icon upload, convert to WebP and resize to 100x90
     */
    private function handleIconUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize to 100x90
        $image = Image::make($file->getRealPath())
            ->resize(100, 90, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 90);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/about-features/icons/' . $filename, (string) $image);
        
        return '/uploads/about-features/icons/' . $filename;
    }
}

