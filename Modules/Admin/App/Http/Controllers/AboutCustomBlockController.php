<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AboutCustomBlock;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AboutCustomBlockController extends Controller
{
    /**
     * Display a listing of about custom blocks
     */
    public function index()
    {
        $blocks = AboutCustomBlock::list();
        return view('admin::about-custom-blocks.index', compact('blocks'));
    }
    
    /**
     * Show the form for creating a new block
     */
    public function create()
    {
        return view('admin::about-custom-blocks.create');
    }
    
    /**
     * Store a newly created block
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:2000',
            'description_arabic' => 'required|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
        
        AboutCustomBlock::create($data);
        
        return redirect()->route('about-custom-block.index')->with('success', 'About Custom Block created successfully!');
    }
    
    /**
     * Show the form for editing the specified block
     */
    public function edit($id)
    {
        $block = AboutCustomBlock::findOrFail($id);
        return view('admin::about-custom-blocks.edit', compact('block'));
    }
    
    /**
     * Update the specified block
     */
    public function update(Request $request, $id)
    {
        $block = AboutCustomBlock::findOrFail($id);
        
        $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:2000',
            'description_arabic' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($block->image && Storage::exists('public' . $block->image)) {
                Storage::delete('public' . $block->image);
            }
            
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
        
        $block->update($data);
        
        return redirect()->route('about-custom-block.index')->with('success', 'About Custom Block updated successfully!');
    }
    
    /**
     * Soft delete the block
     */
    public function destroy($id)
    {
        $block = AboutCustomBlock::findOrFail($id);
        $block->delete();
        
        return redirect()->route('about-custom-block.index')->with('success', 'About Custom Block deleted successfully!');
    }
    
    /**
     * Display trashed blocks
     */
    public function trashed()
    {
        $blocks = AboutCustomBlock::trashed();
        return view('admin::about-custom-blocks.trashed', compact('blocks'));
    }
    
    /**
     * Restore trashed block
     */
    public function restore($id)
    {
        $block = AboutCustomBlock::withTrashed()->findOrFail($id);
        $block->restore();
        
        return redirect()->route('about-custom-block.trashed')->with('success', 'About Custom Block restored successfully!');
    }
    
    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        $block = AboutCustomBlock::findOrFail($id);
        $block->status = $block->status == 0 ? 1 : 0;
        $block->save();
        
        $status = $block->status == 0 ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "About Custom Block {$status} successfully!");
    }
    
    /**
     * Handle image upload, convert to WebP and resize to 960x733
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize to 960x733
        $image = Image::make($file->getRealPath())
            ->resize(960, 733, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 90);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/about-custom-blocks/images/' . $filename, (string) $image);
        
        return '/uploads/about-custom-blocks/images/' . $filename;
    }
}

