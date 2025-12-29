<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectFloor;
use App\Models\BuildingComponent;
use App\Models\FloorComponent;
use App\Models\ProjectBuildingComponent;
use Illuminate\Support\Facades\Storage;
use Image;

class ProjectFloorController extends Controller
{
    /**
     * Display a listing of floors for a project
     */
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $floors = ProjectFloor::getByProject($projectId);
        $trashedFloors = ProjectFloor::getTrashedByProject($projectId);
        
        return view('admin::projects.floors.index', compact('project', 'floors', 'trashedFloors'));
    }

    /**
     * Show the form for creating a new floor
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        
        // Get building components assigned to this project
        $projectBuildingComponents = ProjectBuildingComponent::getByProject($projectId);
        
        return view('admin::projects.floors.create', compact('project', 'projectBuildingComponents'));
    }

    /**
     * Store a newly created floor
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'building_component_id' => 'required|exists:building_components,id',
            'floor_component_id' => 'required|exists:floor_components,id',
            'sqft' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'image_3d' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_2d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'project_id' => $projectId,
            'building_component_id' => $request->building_component_id,
            'floor_component_id' => $request->floor_component_id,
            'sqft' => $request->sqft,
            'sqm' => $request->sqft * 0.092903, // Auto calculate SqM from SqFt
            'count' => $request->count,
        ];

        // Handle 3D image upload (required) - Convert to WebP 1080x1080
        if ($request->hasFile('image_3d')) {
            $data['image_3d'] = $this->handleImageUpload($request->file('image_3d'), 1080, 1080, '3d');
        }

        // Handle 2D image upload (optional) - Convert to WebP 1080x1080
        if ($request->hasFile('image_2d')) {
            $data['image_2d'] = $this->handleImageUpload($request->file('image_2d'), 1080, 1080, '2d');
        }

        ProjectFloor::create($data);

        return redirect()->route('project.floor.index', ['projectId' => $projectId])
            ->with('success', 'Floor added successfully!');
    }

    /**
     * Display the specified floor
     */
    public function show($projectId, $id)
    {
        $project = Project::findOrFail($projectId);
        $floor = ProjectFloor::findOrFail($id);
        
        return view('admin::projects.floors.show', compact('project', 'floor'));
    }

    /**
     * Show the form for editing the specified floor
     */
    public function edit($projectId, $id)
    {
        $project = Project::findOrFail($projectId);
        $floor = ProjectFloor::findOrFail($id);
        
        // Get building components assigned to this project
        $projectBuildingComponents = ProjectBuildingComponent::getByProject($projectId);
        
        // Get floor components for the selected building component
        $floorComponents = FloorComponent::where('component_id', $floor->building_component_id)
            ->whereNull('deleted_at')
            ->get();
        
        return view('admin::projects.floors.edit', compact('project', 'floor', 'projectBuildingComponents', 'floorComponents'));
    }

    /**
     * Update the specified floor
     */
    public function update(Request $request, $projectId, $id)
    {
        $floor = ProjectFloor::findOrFail($id);
        
        $request->validate([
            'building_component_id' => 'required|exists:building_components,id',
            'floor_component_id' => 'required|exists:floor_components,id',
            'sqft' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'image_3d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_2d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'building_component_id' => $request->building_component_id,
            'floor_component_id' => $request->floor_component_id,
            'sqft' => $request->sqft,
            'sqm' => $request->sqft * 0.092903, // Auto calculate SqM from SqFt
            'count' => $request->count,
        ];

        // Handle 3D image upload - Convert to WebP 1080x1080
        if ($request->hasFile('image_3d')) {
            if ($floor->image_3d) {
                Storage::disk('public')->delete(ltrim($floor->image_3d, '/'));
            }
            $data['image_3d'] = $this->handleImageUpload($request->file('image_3d'), 1080, 1080, '3d');
        }

        // Handle 2D image upload - Convert to WebP 1080x1080
        if ($request->hasFile('image_2d')) {
            if ($floor->image_2d) {
                Storage::disk('public')->delete(ltrim($floor->image_2d, '/'));
            }
            $data['image_2d'] = $this->handleImageUpload($request->file('image_2d'), 1080, 1080, '2d');
        }

        $floor->update($data);

        return redirect()->route('project.floor.index', ['projectId' => $projectId])
            ->with('success', 'Floor updated successfully!');
    }

    /**
     * Soft delete the floor
     */
    public function destroy($projectId, $id)
    {
        $floor = ProjectFloor::findOrFail($id);
        $floor->delete();

        return redirect()->route('project.floor.index', ['projectId' => $projectId])
            ->with('success', 'Floor deleted successfully!');
    }

    /**
     * Restore trashed floor
     */
    public function restore($projectId, $id)
    {
        $floor = ProjectFloor::withTrashed()->findOrFail($id);
        $floor->restore();

        return redirect()->route('project.floor.index', ['projectId' => $projectId])
            ->with('success', 'Floor restored successfully!');
    }

    /**
     * Get floor components by building component (AJAX)
     */
    public function getFloorComponents(Request $request)
    {
        $buildingComponentId = $request->building_component_id;
        
        $floorComponents = FloorComponent::where('component_id', $buildingComponentId)
            ->whereNull('deleted_at')
            ->orderBy('name_english')
            ->get(['id', 'name_english', 'name_arabic']);
        
        return response()->json($floorComponents);
    }

    /**
     * Handle image upload, convert to WebP and resize
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $width
     * @param int $height
     * @param string $type (3d or 2d)
     * @return string
     */
    private function handleImageUpload($file, $width, $height, $type)
    {
        // Generate unique filename
        $filename = time() . '_' . $type . '_' . uniqid() . '.webp';
        
        // Create image instance and resize
        $image = Image::make($file->getRealPath())
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 80);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/projects/floors/' . $filename, (string) $image);
        
        return '/uploads/projects/floors/' . $filename;
    }
}

