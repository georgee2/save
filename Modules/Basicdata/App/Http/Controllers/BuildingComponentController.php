<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\BuildingComponent;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Storage;

class BuildingComponentController extends Controller
{
    protected $buildingComponent;

    public function __construct(BuildingComponent $buildingComponent)
    {
        $this->buildingComponent = $buildingComponent;
    }

    /**
     * Display a listing of building components
     */
    public function index()
    {
        $components = $this->buildingComponent->list();
        
        return view('basicdata::buildingcomponents.index', [
            'components' => $components
        ]);
    }

    /**
     * Show the form for creating a new building component
     */
    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::buildingcomponents.create', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Store a newly created building component
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'is_length' => 'nullable|boolean',
        ]);
        
        // Convert checkbox value to boolean
        $data['is_length'] = $request->has('is_length') ? true : false;

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('building_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        BuildingComponent::create($data);

        return redirect()->route('buildingcomponent.index')->with('success', 'Building Component created successfully!');
    }

    /**
     * Show the form for editing building component
     */
    public function edit($id)
    {
        $component = BuildingComponent::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::buildingcomponents.edit', [
            'component' => $component,
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Update the specified building component
     */
    public function update(Request $request, $id)
    {
        $component = BuildingComponent::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'is_length' => 'nullable|boolean',
        ]);
        
        // Convert checkbox value to boolean
        $data['is_length'] = $request->has('is_length') ? true : false;

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($component->icon) {
                Storage::disk('public')->delete(ltrim($component->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('building_components/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $component->update($data);

        return redirect()->route('buildingcomponent.index')->with('success', 'Building Component updated successfully!');
    }

    /**
     * Soft delete the building component
     */
    public function destroy($id)
    {
        $component = BuildingComponent::findOrFail($id);
        $component->delete();

        return redirect()->route('buildingcomponent.index')->with('success', 'Building Component deleted successfully!');
    }

    /**
     * Display trashed building components
     */
    public function trashed()
    {
        $components = $this->buildingComponent->trashed();
        
        return view('basicdata::buildingcomponents.trashed', [
            'components' => $components
        ]);
    }

    /**
     * Restore trashed building component
     */
    public function restore($id)
    {
        $component = BuildingComponent::withTrashed()->findOrFail($id);
        $component->restore();

        return redirect()->route('buildingcomponent.trashed')->with('success', 'Building Component restored successfully!');
    }
}

