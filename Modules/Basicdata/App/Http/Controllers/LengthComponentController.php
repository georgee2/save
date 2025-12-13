<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\LengthComponent;
use App\Models\ProjectType;
use App\Models\BuildingComponent;
use Illuminate\Support\Facades\Storage;

class LengthComponentController extends Controller
{
    protected $lengthComponent;

    public function __construct(LengthComponent $lengthComponent)
    {
        $this->lengthComponent = $lengthComponent;
    }

    /**
     * Display a listing of length components
     */
    public function index()
    {
        $components = $this->lengthComponent->list();
        
        return view('basicdata::lengthcomponents.index', [
            'components' => $components
        ]);
    }

    /**
     * Show the form for creating a new length component
     */
    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::lengthcomponents.create', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Store a newly created length component
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'building_component_id' => 'required|exists:building_components,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('length_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        LengthComponent::create($data);

        return redirect()->route('lengthcomponent.index')->with('success', 'Length Component created successfully!');
    }

    /**
     * Show the form for editing length component
     */
    public function edit($id)
    {
        $component = LengthComponent::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        // Get building components filtered by project type
        $buildingComponents = BuildingComponent::where('project_type_id', $component->project_type_id)
            ->where('is_length', true)
            ->whereNull('deleted_at')
            ->orderBy('name_english')
            ->get();
        
        return view('basicdata::lengthcomponents.edit', [
            'component' => $component,
            'projectTypes' => $projectTypes,
            'buildingComponents' => $buildingComponents
        ]);
    }

    /**
     * Update the specified length component
     */
    public function update(Request $request, $id)
    {
        $component = LengthComponent::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'building_component_id' => 'required|exists:building_components,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($component->icon) {
                Storage::disk('public')->delete(ltrim($component->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('length_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $component->update($data);

        return redirect()->route('lengthcomponent.index')->with('success', 'Length Component updated successfully!');
    }

    /**
     * Soft delete the length component
     */
    public function destroy($id)
    {
        $component = LengthComponent::findOrFail($id);
        $component->delete();

        return redirect()->route('lengthcomponent.index')->with('success', 'Length Component deleted successfully!');
    }

    /**
     * Display trashed length components
     */
    public function trashed()
    {
        $components = $this->lengthComponent->trashed();
        
        return view('basicdata::lengthcomponents.trashed', [
            'components' => $components
        ]);
    }

    /**
     * Restore trashed length component
     */
    public function restore($id)
    {
        $component = LengthComponent::withTrashed()->findOrFail($id);
        $component->restore();

        return redirect()->route('lengthcomponent.trashed')->with('success', 'Length Component restored successfully!');
    }

    /**
     * AJAX: Get building components filtered by project type (only length components)
     */
    public function getBuildingComponents(Request $request)
    {
        $projectTypeId = $request->get('project_type_id');
        
        $buildingComponents = BuildingComponent::where('project_type_id', $projectTypeId)
            ->where('is_length', true)
            ->whereNull('deleted_at')
            ->orderBy('name_english')
            ->get(['id', 'name_english', 'name_arabic']);
        
        return response()->json($buildingComponents);
    }
}

