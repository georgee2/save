<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\DefaultBanner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class DefaultBannerController extends Controller
{
    protected $defaultBanner;

    public function __construct(DefaultBanner $defaultBanner)
    {
        $this->defaultBanner = $defaultBanner;
    }

    /**
     * Display a listing of default banners
     */
    public function index()
    {
        $banners = $this->defaultBanner->list();
        
        return view('admin::default-banners.index', [
            'banners' => $banners
        ]);
    }

    /**
     * Show the form for creating a new default banner
     */
    public function create()
    {
        return view('admin::default-banners.create');
    }

    /**
     * Store a newly created default banner
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'background' => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }

        // Handle Background Upload (1890x492)
        if ($request->hasFile('background')) {
            $backgroundFile = $request->file('background');
            $image = Image::make($backgroundFile)->resize(1890, 492)->encode('webp', 80);
            $backgroundName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/default-banners/' . $backgroundName, (string) $image);
            $data['background'] = "/uploads/default-banners/{$backgroundName}";
        }

        DefaultBanner::create($data);

        return redirect()->route('admin.default-banners.index')->with('success', 'Default Banner created successfully!');
    }

    /**
     * Display the specified default banner
     */
    public function show($id)
    {
        $banner = DefaultBanner::findOrFail($id);
        
        return view('admin::default-banners.show', [
            'banner' => $banner
        ]);
    }

    /**
     * Show the form for editing the specified default banner
     */
    public function edit($id)
    {
        $banner = DefaultBanner::findOrFail($id);
        
        return view('admin::default-banners.edit', [
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified default banner
     */
    public function update(Request $request, $id)
    {
        $banner = DefaultBanner::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'background' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }

        // Handle Background Upload (1890x492)
        if ($request->hasFile('background')) {
            // Delete old background
            if ($banner->background && Storage::disk('public')->exists($banner->background)) {
                Storage::disk('public')->delete($banner->background);
            }
            
            $backgroundFile = $request->file('background');
            $image = Image::make($backgroundFile)->resize(1890, 492)->encode('webp', 80);
            $backgroundName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/default-banners/' . $backgroundName, (string) $image);
            $data['background'] = "/uploads/default-banners/{$backgroundName}";
        }

        $banner->update($data);

        return redirect()->route('admin.default-banners.index')->with('success', 'Default Banner updated successfully!');
    }

    /**
     * Remove the specified default banner (soft delete)
     */
    public function destroy($id)
    {
        $banner = DefaultBanner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.default-banners.index')->with('success', 'Default Banner moved to trash successfully!');
    }

    /**
     * Display trashed default banners
     */
    public function trashed()
    {
        $banners = DefaultBanner::trashed();
        
        return view('admin::default-banners.trashed', [
            'banners' => $banners
        ]);
    }

    /**
     * Restore a trashed default banner
     */
    public function restore($id)
    {
        $banner = DefaultBanner::withTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('admin.default-banners.trashed')->with('success', 'Default Banner restored successfully!');
    }

    /**
     * Permanently delete a default banner
     */
    public function forceDelete($id)
    {
        $banner = DefaultBanner::withTrashed()->findOrFail($id);
        
        // Delete background file
        if ($banner->background && Storage::disk('public')->exists($banner->background)) {
            Storage::disk('public')->delete($banner->background);
        }
        
        $banner->forceDelete();

        return redirect()->route('admin.default-banners.trashed')->with('success', 'Default Banner permanently deleted!');
    }

    /**
     * Toggle default banner status (Active/Not Active)
     */
    public function toggleStatus($id)
    {
        $banner = DefaultBanner::findOrFail($id);
        $banner->status = $banner->status == 0 ? 1 : 0;
        $banner->save();

        $statusText = $banner->status == 0 ? 'activated' : 'deactivated';
        return redirect()->route('admin.default-banners.index')->with('success', "Default Banner {$statusText} successfully!");
    }
}

