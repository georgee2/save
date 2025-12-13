<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Showcase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ShowcaseController extends Controller
{
    protected $showcase;

    public function __construct(Showcase $showcase)
    {
        $this->showcase = $showcase;
    }

    /**
     * Display a listing of showcases
     */
    public function index()
    {
        $showcases = $this->showcase->list();
        
        return view('admin::showcases.index', [
            'showcases' => $showcases
        ]);
    }

    /**
     * Show the form for creating a new showcase
     */
    public function create()
    {
        return view('admin::showcases.create');
    }

    /**
     * Store a newly created showcase
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'main_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'page_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
            'home_status' => 'required|in:shown,not_shown',
        ]);

        // Generate slug from English title
        $data['slug'] = Str::slug($request->title_english);

        // Handle cover_image upload - resize to 1890x420 and convert to webp
        if ($request->hasFile('cover_image')) {
            $coverImg = $request->file('cover_image');
            $image = Image::make($coverImg)->resize(1890, 420)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/covers/' . $imageName, (string) $image);
            $data['cover_image'] = "/uploads/showcases/covers/{$imageName}";
        }

        // Handle main_image upload - resize to 292x330 and convert to webp
        if ($request->hasFile('main_image')) {
            $mainImg = $request->file('main_image');
            $image = Image::make($mainImg)->resize(292, 330)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/main/' . $imageName, (string) $image);
            $data['main_image'] = "/uploads/showcases/main/{$imageName}";
        }

        // Handle page_image upload - resize to 870x450 and convert to webp
        if ($request->hasFile('page_image')) {
            $pageImg = $request->file('page_image');
            $image = Image::make($pageImg)->resize(870, 450)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/pages/' . $imageName, (string) $image);
            $data['page_image'] = "/uploads/showcases/pages/{$imageName}";
        }

        // SEO Tags Insertion (Helper Function)
        if ($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        Showcase::create($data);

        return redirect()->route('showcase.index')->with('success', 'Showcase created successfully!');
    }

    /**
     * Display the specified showcase
     */
    public function show($id)
    {
        $showcase = Showcase::with(['services', 'projects', 'portfolios', 'teams', 'news'])->findOrFail($id);
        
        return view('admin::showcases.show', [
            'showcase' => $showcase
        ]);
    }

    /**
     * Show the form for editing showcase
     */
    public function edit($id)
    {
        $showcase = Showcase::findOrFail($id);
        
        return view('admin::showcases.edit', [
            'showcase' => $showcase
        ]);
    }

    /**
     * Update the specified showcase
     */
    public function update(Request $request, $id)
    {
        $showcase = Showcase::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'main_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'page_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'description_english' => 'required|string',
            'description_arabic' => 'required|string',
            'seo_tags' => 'nullable|string',
            'seo_description_english' => 'nullable|string|max:1000',
            'seo_description_arabic' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
            'home_status' => 'required|in:shown,not_shown',
        ]);

        // Generate slug from English title
        $data['slug'] = Str::slug($request->title_english);

        // Handle cover_image upload - resize to 1890x420 and convert to webp
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($showcase->cover_image) {
                Storage::disk('public')->delete(ltrim($showcase->cover_image, '/'));
            }
            $coverImg = $request->file('cover_image');
            $image = Image::make($coverImg)->resize(1890, 420)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/covers/' . $imageName, (string) $image);
            $data['cover_image'] = "/uploads/showcases/covers/{$imageName}";
        }

        // Handle main_image upload - resize to 292x330 and convert to webp
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($showcase->main_image) {
                Storage::disk('public')->delete(ltrim($showcase->main_image, '/'));
            }
            $mainImg = $request->file('main_image');
            $image = Image::make($mainImg)->resize(292, 330)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/main/' . $imageName, (string) $image);
            $data['main_image'] = "/uploads/showcases/main/{$imageName}";
        }

        // Handle page_image upload - resize to 870x450 and convert to webp
        if ($request->hasFile('page_image')) {
            // Delete old image
            if ($showcase->page_image) {
                Storage::disk('public')->delete(ltrim($showcase->page_image, '/'));
            }
            $pageImg = $request->file('page_image');
            $image = Image::make($pageImg)->resize(870, 450)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/showcases/pages/' . $imageName, (string) $image);
            $data['page_image'] = "/uploads/showcases/pages/{$imageName}";
        }

        // SEO Tags Insertion (Helper Function)
        if ($request->seo_tags != null) {
            $data['seo_tags'] = tags($request->seo_tags);
        }

        $showcase->update($data);

        return redirect()->route('showcase.index')->with('success', 'Showcase updated successfully!');
    }

    /**
     * Soft delete the showcase
     */
    public function destroy($id)
    {
        $showcase = Showcase::findOrFail($id);
        $showcase->delete();

        return redirect()->route('showcase.index')->with('success', 'Showcase deleted successfully!');
    }

    /**
     * Display trashed showcases
     */
    public function trashed()
    {
        $showcases = $this->showcase->trashed();
        
        return view('admin::showcases.trashed', [
            'showcases' => $showcases
        ]);
    }

    /**
     * Restore trashed showcase
     */
    public function restore($id)
    {
        $showcase = Showcase::withTrashed()->findOrFail($id);
        $showcase->restore();

        return redirect()->route('showcase.trashed')->with('success', 'Showcase restored successfully!');
    }
    
    /**
     * Toggle showcase status (active/inactive)
     */
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        
        $showcase = Showcase::findOrFail($id);
        $showcase->status = $request->status;
        $showcase->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Showcase status updated successfully!',
            'status' => $showcase->status
        ]);
    }
    
    /**
     * Toggle showcase home status (shown/not_shown)
     */
    public function toggleHomeStatus(Request $request, $id)
    {
        $request->validate([
            'home_status' => 'required|in:shown,not_shown'
        ]);
        
        $showcase = Showcase::findOrFail($id);
        $showcase->home_status = $request->home_status;
        $showcase->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Showcase home status updated successfully!',
            'home_status' => $showcase->home_status
        ]);
    }
}

