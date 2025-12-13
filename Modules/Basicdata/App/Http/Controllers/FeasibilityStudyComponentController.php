<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\FeasibilityStudyComponent;
use App\Models\ProjectType;

class FeasibilityStudyComponentController extends Controller
{
    protected $feasibilityStudyComponent;

    public function __construct(FeasibilityStudyComponent $feasibilityStudyComponent)
    {
        $this->feasibilityStudyComponent = $feasibilityStudyComponent;
    }

    /**
     * Display a listing of feasibility study components
     */
    public function index()
    {
        $components = $this->feasibilityStudyComponent->list();
        
        return view('basicdata::feasibilitystudycomponents.index', [
            'components' => $components
        ]);
    }

    /**
     * Show the form for creating a new feasibility study component
     */
    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::feasibilitystudycomponents.create', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Store a newly created feasibility study component
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'target' => 'required|in:Building Components,Income Components,Length Components,Construction Cost,Project Cost',
            'header_english' => 'required|string|max:255',
            'header_arabic' => 'required|string|max:255',
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'status' => 'required|in:Active,Not Active',
        ]);

        FeasibilityStudyComponent::create($data);

        return redirect()->route('feasibilitystudycomponent.index')->with('success', 'Feasibility Study Component created successfully!');
    }

    /**
     * Show the form for editing feasibility study component
     */
    public function edit($id)
    {
        $component = FeasibilityStudyComponent::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->orderBy('name_english')->get();
        
        return view('basicdata::feasibilitystudycomponents.edit', [
            'component' => $component,
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Update the specified feasibility study component
     */
    public function update(Request $request, $id)
    {
        $component = FeasibilityStudyComponent::findOrFail($id);
        
        $data = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
            'target' => 'required|in:Building Components,Income Components,Length Components,Construction Cost,Project Cost',
            'header_english' => 'required|string|max:255',
            'header_arabic' => 'required|string|max:255',
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'status' => 'required|in:Active,Not Active',
        ]);

        $component->update($data);

        return redirect()->route('feasibilitystudycomponent.index')->with('success', 'Feasibility Study Component updated successfully!');
    }

    /**
     * Soft delete the feasibility study component
     */
    public function destroy($id)
    {
        $component = FeasibilityStudyComponent::findOrFail($id);
        $component->delete();

        return redirect()->route('feasibilitystudycomponent.index')->with('success', 'Feasibility Study Component deleted successfully!');
    }

    /**
     * Display trashed feasibility study components
     */
    public function trashed()
    {
        $components = $this->feasibilityStudyComponent->trashed();
        
        return view('basicdata::feasibilitystudycomponents.trashed', [
            'components' => $components
        ]);
    }

    /**
     * Restore trashed feasibility study component
     */
    public function restore($id)
    {
        $component = FeasibilityStudyComponent::withTrashed()->findOrFail($id);
        $component->restore();

        return redirect()->route('feasibilitystudycomponent.trashed')->with('success', 'Feasibility Study Component restored successfully!');
    }
}

