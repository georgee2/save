<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PageBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = PageBanner::list();
        $targetPages = PageBanner::getTargetPages();
        return view('admin::page-banners.index', compact('banners', 'targetPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $targetPages = PageBanner::getTargetPages();
        return view('admin::page-banners.create', compact('targetPages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'target' => 'required|string|in:services,portfolios,projects,offers,showcases,blogs,careers,team,contact',
            'cover' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        // Check if banner already exists for this target
        $existingBanner = PageBanner::where('target', $request->target)->whereNull('deleted_at')->first();
        if ($existingBanner) {
            return redirect()->back()->with('error', 'A banner already exists for this page. Please edit the existing one or delete it first.');
        }

        $data = $request->only(['target']);

        // Handle cover image upload and conversion to webp
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '_' . uniqid() . '.webp';
            $imagePath = public_path('storage/page_banners');

            // Create directory if it doesn't exist
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            // Resize and convert to webp (1980x420)
            $img = Image::make($image->getRealPath());
            $img->resize(1980, 420, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('webp', 90);
            $img->save($imagePath . '/' . $imageName);

            $data['cover'] = 'storage/page_banners/' . $imageName;
        }

        PageBanner::create($data);

        return redirect()->route('page-banner.index')->with('success', 'Page Banner created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = PageBanner::findOrFail($id);
        $targetPages = PageBanner::getTargetPages();
        return view('admin::page-banners.edit', compact('banner', 'targetPages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = PageBanner::findOrFail($id);

        $request->validate([
            'target' => 'required|string|in:services,portfolios,projects,offers,showcases,blogs,careers,team,contact',
            'cover' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        // Check if banner already exists for this target (excluding current banner)
        $existingBanner = PageBanner::where('target', $request->target)
            ->where('id', '!=', $id)
            ->whereNull('deleted_at')
            ->first();
        if ($existingBanner) {
            return redirect()->back()->with('error', 'A banner already exists for this page.');
        }

        $data = $request->only(['target']);

        // Handle cover image upload and conversion to webp
        if ($request->hasFile('cover')) {
            // Delete old image
            if ($banner->cover && File::exists(public_path($banner->cover))) {
                File::delete(public_path($banner->cover));
            }

            $image = $request->file('cover');
            $imageName = time() . '_' . uniqid() . '.webp';
            $imagePath = public_path('storage/page_banners');

            // Create directory if it doesn't exist
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            // Resize and convert to webp (1980x420)
            $img = Image::make($image->getRealPath());
            $img->resize(1980, 420, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->encode('webp', 90);
            $img->save($imagePath . '/' . $imageName);

            $data['cover'] = 'storage/page_banners/' . $imageName;
        }

        $banner->update($data);

        return redirect()->route('page-banner.index')->with('success', 'Page Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id)
    {
        $banner = PageBanner::findOrFail($id);
        $banner->delete();

        return redirect()->route('page-banner.index')->with('success', 'Page Banner deleted successfully.');
    }

    /**
     * Display trashed page banners.
     */
    public function trashed()
    {
        $banners = PageBanner::trashed();
        $targetPages = PageBanner::getTargetPages();
        return view('admin::page-banners.trashed', compact('banners', 'targetPages'));
    }

    /**
     * Restore a trashed page banner.
     */
    public function restore($id)
    {
        $banner = PageBanner::withTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('page-banner.trashed')->with('success', 'Page Banner restored successfully.');
    }
}

