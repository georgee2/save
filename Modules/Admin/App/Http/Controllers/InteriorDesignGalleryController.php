<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\InteriorDesignGallery;
use App\Models\Project;
use App\Models\ProjectStyle;
use App\Models\ProjectType;
use App\Models\Emirate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class InteriorDesignGalleryController extends Controller
{
    protected $interiorDesignGallery;

    public function __construct(InteriorDesignGallery $interiorDesignGallery)
    {
        $this->interiorDesignGallery = $interiorDesignGallery;
    }

    /**
     * Display a listing of interior design galleries
     */
    public function index()
    {
        $galleries = $this->interiorDesignGallery->list();
        
        return view('admin::interior-design-galleries.index', [
            'galleries' => $galleries
        ]);
    }

    /**
     * Show the form for creating a new interior design gallery
     */
    public function create()
    {
        $projects = Project::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectStyles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectTypes = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
            
        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.create', compact(
            'projects', 
            'projectStyles', 
            'projectTypes', 
            'emirates'
        ));
    }

    /**
     * Store a newly created interior design gallery
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'publish_status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
            'ordering' => 'required|integer|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'project_style_id' => 'nullable|exists:project_styles,id',
            'project_type_id' => 'required|exists:project_types,id',
            'emirate_id' => 'nullable|exists:emirates,id',
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

        // Handle image upload - resize to 765x432, convert to WebP
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        InteriorDesignGallery::create($data);

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery created successfully!');
    }

    /**
     * Display the specified interior design gallery
     */
    public function show($id)
    {
        $gallery = InteriorDesignGallery::with(['project', 'projectStyle', 'projectType', 'emirate'])->findOrFail($id);
        
        return view('admin::interior-design-galleries.show', [
            'gallery' => $gallery
        ]);
    }

    /**
     * Show the form for editing interior design gallery
     */
    public function edit($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        
        $projects = Project::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectStyles = ProjectStyle::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
            
        $projectTypes = ProjectType::whereNull('deleted_at')
            ->orderBy('name_english', 'asc')
            ->get();
            
        $emirates = Emirate::whereNull('deleted_at')
            ->orderBy('title_english', 'asc')
            ->get();
        
        return view('admin::interior-design-galleries.edit', compact(
            'gallery',
            'projects', 
            'projectStyles', 
            'projectTypes', 
            'emirates'
        ));
    }

    /**
     * Update the specified interior design gallery
     */
    public function update(Request $request, $id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'publish_status' => 'required|in:0,1',
            'home_status' => 'required|in:0,1',
            'ordering' => 'required|integer|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'project_style_id' => 'nullable|exists:project_styles,id',
            'project_type_id' => 'required|exists:project_types,id',
            'emirate_id' => 'nullable|exists:emirates,id',
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

        // Handle image upload - resize to 765x432, convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image) {
                Storage::disk('public')->delete(ltrim($gallery->image, '/'));
            }
            
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $gallery->update($data);

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery updated successfully!');
    }

    /**
     * Soft delete the interior design gallery
     */
    public function destroy($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('interior-design-gallery.index')->with('success', 'Interior Design Gallery deleted successfully!');
    }

    /**
     * Display trashed interior design galleries
     */
    public function trashed()
    {
        $galleries = $this->interiorDesignGallery->trashed();
        
        return view('admin::interior-design-galleries.trashed', [
            'galleries' => $galleries
        ]);
    }

    /**
     * Restore trashed interior design gallery
     */
    public function restore($id)
    {
        $gallery = InteriorDesignGallery::withTrashed()->findOrFail($id);
        $gallery->restore();

        return redirect()->route('interior-design-gallery.trashed')->with('success', 'Interior Design Gallery restored successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->publish_status = $gallery->publish_status == 0 ? 1 : 0;
        $gallery->save();
        
        $status = $gallery->publish_status == 0 ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Gallery {$status} successfully!");
    }

    /**
     * Toggle home status
     */
    public function toggleHomeStatus($id)
    {
        $gallery = InteriorDesignGallery::findOrFail($id);
        $gallery->home_status = $gallery->home_status == 0 ? 1 : 0;
        $gallery->save();
        
        $status = $gallery->home_status == 0 ? 'shown on home' : 'hidden from home';
        return redirect()->back()->with('success', "Gallery {$status} successfully!");
    }

    /**
     * Handle image upload, convert to WebP and resize
     * Dimensions: 765x432
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and fit to exact 765x432 dimensions
        $image = Image::make($file->getRealPath())
            ->fit(765, 432, function ($constraint) {
                $constraint->upsize(); // Prevent upsizing small images
            })
            ->encode('webp', 85);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/interior_design_galleries/' . $filename, (string) $image);
        
        return '/interior_design_galleries/' . $filename;
    }
}
