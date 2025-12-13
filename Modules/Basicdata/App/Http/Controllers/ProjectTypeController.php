<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProjectType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectTypeController extends Controller
{
    protected $projectType;

    public function __construct(ProjectType $projectType)
    {
        $this->projectType = $projectType;
    }

    /**
     * Display a listing of project types
     */
    public function index()
    {
        $projectTypes = $this->projectType->list();
        
        return view('basicdata::projecttypes.index', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Show the form for creating a new project type
     */
    public function create()
    {
        return view('basicdata::projecttypes.create');
    }

    /**
     * Store a newly created project type
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English name
        $data['slug'] = Str::slug($data['name_english']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('project_types/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('project_types/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        ProjectType::create($data);

        return redirect()->route('projecttype.index')->with('success', 'Project Type created successfully!');
    }

    /**
     * Show the form for editing project type
     */
    public function edit($id)
    {
        $projectType = ProjectType::findOrFail($id);
        
        return view('basicdata::projecttypes.edit', [
            'projectType' => $projectType
        ]);
    }

    /**
     * Update the specified project type
     */
    public function update(Request $request, $id)
    {
        $projectType = ProjectType::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'status' => 'required|in:0,1',
        ]);

        // Auto-generate slug from English name
        $data['slug'] = Str::slug($data['name_english']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($projectType->image) {
                Storage::disk('public')->delete(ltrim($projectType->image, '/'));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('project_types/images', $imageName, 'public');
            $data['image'] = '/' . $imagePath;
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($projectType->icon) {
                Storage::disk('public')->delete(ltrim($projectType->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('project_types/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $projectType->update($data);

        return redirect()->route('projecttype.index')->with('success', 'Project Type updated successfully!');
    }

    /**
     * Soft delete the project type
     */
    public function destroy($id)
    {
        $projectType = ProjectType::findOrFail($id);
        $projectType->delete();

        return redirect()->route('projecttype.index')->with('success', 'Project Type deleted successfully!');
    }

    /**
     * Display trashed project types
     */
    public function trashed()
    {
        $projectTypes = $this->projectType->trashed();
        
        return view('basicdata::projecttypes.trashed', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Restore trashed project type
     */
    public function restore($id)
    {
        $projectType = ProjectType::withTrashed()->findOrFail($id);
        $projectType->restore();

        return redirect()->route('projecttype.trashed')->with('success', 'Project Type restored successfully!');
    }
}

