<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Project;
use App\Models\ProjectFloor;
use App\Models\ProjectFloorSpecification;
use App\Models\Specification;

class ProjectFloorSpecificationController extends Controller
{
    /**
     * Display a listing of specifications for a floor
     */
    public function index($projectId, $floorId)
    {
        $project = Project::findOrFail($projectId);
        $floor = ProjectFloor::findOrFail($floorId);
        $specifications = ProjectFloorSpecification::getByFloor($floorId);
        $trashedSpecifications = ProjectFloorSpecification::getTrashedByFloor($floorId);
        
        return view('admin::projects.floors.specifications.index', compact('project', 'floor', 'specifications', 'trashedSpecifications'));
    }

    /**
     * Show the form for creating a new specification
     */
    public function create($projectId, $floorId)
    {
        $project = Project::findOrFail($projectId);
        $floor = ProjectFloor::findOrFail($floorId);
        
        // Get specifications filtered by project type
        $availableSpecifications = Specification::where('type_id', $project->type_id)
            ->where('status', 0) // Only active specifications
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return view('admin::projects.floors.specifications.create', compact('project', 'floor', 'availableSpecifications'));
    }

    /**
     * Store a newly created specification
     */
    public function store(Request $request, $projectId, $floorId)
    {
        $request->validate([
            'specification_id' => 'required|exists:specifications,id',
            'value_english' => 'required|string|max:255',
            'value_arabic' => 'required|string|max:255',
        ]);

        ProjectFloorSpecification::create([
            'project_id' => $projectId,
            'floor_id' => $floorId,
            'specification_id' => $request->specification_id,
            'value_english' => $request->value_english,
            'value_arabic' => $request->value_arabic,
        ]);

        return redirect()->route('project.floor.specification.index', ['projectId' => $projectId, 'floorId' => $floorId])
            ->with('success', 'Specification added successfully!');
    }

    /**
     * Show the form for editing the specified specification
     */
    public function edit($projectId, $floorId, $id)
    {
        $project = Project::findOrFail($projectId);
        $floor = ProjectFloor::findOrFail($floorId);
        $floorSpecification = ProjectFloorSpecification::findOrFail($id);
        
        // Get specifications filtered by project type
        $availableSpecifications = Specification::where('type_id', $project->type_id)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return view('admin::projects.floors.specifications.edit', compact('project', 'floor', 'floorSpecification', 'availableSpecifications'));
    }

    /**
     * Update the specified specification
     */
    public function update(Request $request, $projectId, $floorId, $id)
    {
        $floorSpecification = ProjectFloorSpecification::findOrFail($id);
        
        $request->validate([
            'specification_id' => 'required|exists:specifications,id',
            'value_english' => 'required|string|max:255',
            'value_arabic' => 'required|string|max:255',
        ]);

        $floorSpecification->update([
            'specification_id' => $request->specification_id,
            'value_english' => $request->value_english,
            'value_arabic' => $request->value_arabic,
        ]);

        return redirect()->route('project.floor.specification.index', ['projectId' => $projectId, 'floorId' => $floorId])
            ->with('success', 'Specification updated successfully!');
    }

    /**
     * Soft delete the specification
     */
    public function destroy($projectId, $floorId, $id)
    {
        $floorSpecification = ProjectFloorSpecification::findOrFail($id);
        $floorSpecification->delete();

        return redirect()->route('project.floor.specification.index', ['projectId' => $projectId, 'floorId' => $floorId])
            ->with('success', 'Specification deleted successfully!');
    }

    /**
     * Restore trashed specification
     */
    public function restore($projectId, $floorId, $id)
    {
        $floorSpecification = ProjectFloorSpecification::withTrashed()->findOrFail($id);
        $floorSpecification->restore();

        return redirect()->route('project.floor.specification.index', ['projectId' => $projectId, 'floorId' => $floorId])
            ->with('success', 'Specification restored successfully!');
    }
}

