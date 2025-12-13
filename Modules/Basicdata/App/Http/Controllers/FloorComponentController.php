<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\FloorComponent;
use App\Models\ProjectType;
use App\Models\BuildingComponent;
use Illuminate\Support\Facades\Storage;

class FloorComponentController extends Controller
{
    protected $floorComponent;

    public function __construct(FloorComponent $floorComponent)
    {
        $this->floorComponent = $floorComponent;
    }

    /**
     * Display a listing of floor components
     */
    public function index()
    {
        $floorComponents = $this->floorComponent->list();
        
        return view('basicdata::floorcomponents.index', [
            'floorComponents' => $floorComponents
        ]);
    }

    /**
     * Show the form for creating a new floor component
     */
    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $buildingComponents = BuildingComponent::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::floorcomponents.create', [
            'projectTypes' => $projectTypes,
            'buildingComponents' => $buildingComponents
        ]);
    }

    /**
     * Store a newly created floor component
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'component_id' => 'required|exists:building_components,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('floor_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        FloorComponent::create($data);

        return redirect()->route('floorcomponent.index')->with('success', 'Floor Component created successfully!');
    }

    /**
     * Show the form for editing floor component
     */
    public function edit($id)
    {
        $floorComponent = FloorComponent::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        $buildingComponents = BuildingComponent::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::floorcomponents.edit', [
            'floorComponent' => $floorComponent,
            'projectTypes' => $projectTypes,
            'buildingComponents' => $buildingComponents
        ]);
    }

    /**
     * Update the specified floor component
     */
    public function update(Request $request, $id)
    {
        $floorComponent = FloorComponent::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'component_id' => 'required|exists:building_components,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($floorComponent->icon) {
                Storage::disk('public')->delete(ltrim($floorComponent->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('floor_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $floorComponent->update($data);

        return redirect()->route('floorcomponent.index')->with('success', 'Floor Component updated successfully!');
    }

    /**
     * Soft delete the floor component
     */
    public function destroy($id)
    {
        $floorComponent = FloorComponent::findOrFail($id);
        $floorComponent->delete();

        return redirect()->route('floorcomponent.index')->with('success', 'Floor Component deleted successfully!');
    }

    /**
     * Display trashed floor components
     */
    public function trashed()
    {
        $floorComponents = $this->floorComponent->trashed();
        
        return view('basicdata::floorcomponents.trashed', [
            'floorComponents' => $floorComponents
        ]);
    }

    /**
     * Restore trashed floor component
     */
    public function restore($id)
    {
        $floorComponent = FloorComponent::withTrashed()->findOrFail($id);
        $floorComponent->restore();

        return redirect()->route('floorcomponent.trashed')->with('success', 'Floor Component restored successfully!');
    }
    
    /**
     * Get building components by project type (AJAX)
     */
    public function getComponentsByProjectType($projectTypeId)
    {
        $components = BuildingComponent::where('project_type_id', $projectTypeId)
            ->whereNull('deleted_at')
            ->orderBy('name_english')
            ->get(['id', 'name_english', 'name_arabic']);
        
        return response()->json($components);
    }
}

