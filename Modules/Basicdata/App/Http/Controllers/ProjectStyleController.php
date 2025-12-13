<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProjectStyle;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectStyleController extends Controller
{
    protected $projectStyle;

    public function __construct(ProjectStyle $projectStyle)
    {
        $this->projectStyle = $projectStyle;
    }

    /**
     * Display a listing of project styles
     */
    public function index()
    {
        $projectStyles = $this->projectStyle->list();
        
        return view('basicdata::projectstyles.index', [
            'projectStyles' => $projectStyles
        ]);
    }

    /**
     * Show the form for creating a new project style
     */
    public function create()
    {
        return view('basicdata::projectstyles.create');
    }

    /**
     * Store a newly created project style
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
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
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

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('project_styles/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('project_styles/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('project_styles/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        ProjectStyle::create($data);

        return redirect()->route('projectstyle.index')->with('success', 'Project Style created successfully!');
    }

    /**
     * Show the form for editing project style
     */
    public function edit($id)
    {
        $projectStyle = ProjectStyle::findOrFail($id);
        
        return view('basicdata::projectstyles.edit', [
            'projectStyle' => $projectStyle
        ]);
    }

    /**
     * Update the specified project style
     */
    public function update(Request $request, $id)
    {
        $projectStyle = ProjectStyle::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'bio_english' => 'nullable|string|max:500',
            'bio_arabic' => 'nullable|string|max:500',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
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

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($projectStyle->icon) {
                Storage::disk('public')->delete(ltrim($projectStyle->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('project_styles/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($projectStyle->image) {
                Storage::disk('public')->delete(ltrim($projectStyle->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_image_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('project_styles/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($projectStyle->cover) {
                Storage::disk('public')->delete(ltrim($projectStyle->cover, '/'));
            }
            
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $coverPath = $cover->storeAs('project_styles/covers', $coverName, 'public');
            $data['cover'] = '/' . $coverPath;
        }

        $projectStyle->update($data);

        return redirect()->route('projectstyle.index')->with('success', 'Project Style updated successfully!');
    }

    /**
     * Soft delete the project style
     */
    public function destroy($id)
    {
        $projectStyle = ProjectStyle::findOrFail($id);
        $projectStyle->delete();

        return redirect()->route('projectstyle.index')->with('success', 'Project Style deleted successfully!');
    }

    /**
     * Display trashed project styles
     */
    public function trashed()
    {
        $projectStyles = $this->projectStyle->trashed();
        
        return view('basicdata::projectstyles.trashed', [
            'projectStyles' => $projectStyles
        ]);
    }

    /**
     * Restore trashed project style
     */
    public function restore($id)
    {
        $projectStyle = ProjectStyle::withTrashed()->findOrFail($id);
        $projectStyle->restore();

        return redirect()->route('projectstyle.trashed')->with('success', 'Project Style restored successfully!');
    }
}

