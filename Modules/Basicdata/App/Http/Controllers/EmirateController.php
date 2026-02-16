<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Emirate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EmirateController extends Controller
{
    protected $emirate;

    public function __construct(Emirate $emirate)
    {
        $this->emirate = $emirate;
    }

    /**
     * Display a listing of emirates
     */
    public function index()
    {
        $emirates = $this->emirate->list();
        
        return view('basicdata::emirates.index', [
            'emirates' => $emirates
        ]);
    }

    /**
     * Show the form for creating a new emirate
     */
    public function create()
    {
        return view('basicdata::emirates.create');
    }

    /**
     * Store a newly created emirate
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null)
        {
            $data['seo_tags'] = tags($request->seo_tags);
        }
        
        // SEO Description Insertion
        if($request->seo_description_english != null)
        {
            $data['seo_description_english'] = $request->seo_description_english;
        }

        if($request->seo_description_arabic != null)
        {
            $data['seo_description_arabic'] = $request->seo_description_arabic;
        }

        // Handle icon upload - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'emirates/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload - resize to 540x675, quality 80, convert to WebP
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.webp';
            $imagePath = 'emirates/images/' . $imageName;
            
            // Resize to 540x675 and convert to WebP with quality 80
            $img = Image::make($image)
                ->fit(540, 675)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($imagePath, $img->stream());
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('emirates/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        Emirate::create($data);

        return redirect()->route('emirate.index')->with('success', 'Emirate created successfully!');
    }

    /**
     * Display the specified emirate
     */
    public function show($id)
    {
        $emirate = Emirate::findOrFail($id);
        
        return view('basicdata::emirates.show', [
            'emirate' => $emirate
        ]);
    }

    /**
     * Show the form for editing emirate
     */
    public function edit($id)
    {
        $emirate = Emirate::findOrFail($id);
        
        return view('basicdata::emirates.edit', [
            'emirate' => $emirate
        ]);
    }

    /**
     * Update the specified emirate
     */
    public function update(Request $request, $id)
    {
        $emirate = Emirate::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string',
            'seo_description_arabic' => 'nullable|string',
        ]);

        // Auto-generate slug from English title
        $data['slug'] = Str::slug($data['title_english']);

        // SEO Tags Insertion (Helper Function)
        if($request->seo_tags != null)
        {
            $data['seo_tags'] = tags($request->seo_tags);
        }
        
        // SEO Description Insertion
        if($request->seo_description_english != null)
        {
            $data['seo_description_english'] = $request->seo_description_english;
        }

        if($request->seo_description_arabic != null)
        {
            $data['seo_description_arabic'] = $request->seo_description_arabic;
        }

        // Handle icon upload - resize to 150x150, quality 80, convert to WebP
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($emirate->icon) {
                Storage::disk('public')->delete(ltrim($emirate->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.webp';
            $iconPath = 'emirates/icons/' . $iconName;
            
            // Resize to 150x150 and convert to WebP with quality 80
            $img = Image::make($icon)
                ->fit(150, 150)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($iconPath, $img->stream());
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload - resize to 540x675, quality 80, convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($emirate->image) {
                Storage::disk('public')->delete(ltrim($emirate->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.webp';
            $imagePath = 'emirates/images/' . $imageName;
            
            // Resize to 540x675 and convert to WebP with quality 80
            $img = Image::make($image)
                ->fit(540, 675)
                ->encode('webp', 80);
            
            Storage::disk('public')->put($imagePath, $img->stream());
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($emirate->cover) {
                Storage::disk('public')->delete(ltrim($emirate->cover, '/'));
            }
            
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('emirates/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        $emirate->update($data);

        return redirect()->route('emirate.index')->with('success', 'Emirate updated successfully!');
    }

    /**
     * Soft delete the emirate
     */
    public function destroy($id)
    {
        $emirate = Emirate::findOrFail($id);
        $emirate->delete();

        return redirect()->route('emirate.index')->with('success', 'Emirate deleted successfully!');
    }

    /**
     * Display trashed emirates
     */
    public function trashed()
    {
        $emirates = $this->emirate->trashed();
        
        return view('basicdata::emirates.trashed', [
            'emirates' => $emirates
        ]);
    }

    /**
     * Restore trashed emirate
     */
    public function restore($id)
    {
        $emirate = Emirate::withTrashed()->findOrFail($id);
        $emirate->restore();

        return redirect()->route('emirate.trashed')->with('success', 'Emirate restored successfully!');
    }
    
    /**
     * Toggle primary status for an emirate
     * Only one emirate can be primary at a time
     */
    public function togglePrimary($id)
    {
        $emirate = Emirate::findOrFail($id);
        
        if ($emirate->is_primary) {
            // If already primary, remove primary status
            $emirate->unmarkAsPrimary();
            $message = 'Emirate "' . $emirate->title_english . '" is no longer the primary emirate.';
        } else {
            // Set as primary (this will unset any other primary emirate)
            $emirate->markAsPrimary();
            $message = 'Emirate "' . $emirate->title_english . '" is now set as the primary emirate.';
        }
        
        return redirect()->route('emirate.index')->with('success', $message);
    }
}

