<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\FeasibilityStudy;
use App\Models\FsBuildingComponent;
use App\Models\FsLengthComponent;
use App\Models\FsIncomeComponent;
use App\Models\FsConstructionCost;
use App\Models\FsProjectCost;
use App\Models\Project;
use App\Models\FeasibilityStudyComponent;
use App\Models\ProjectFloor;
use App\Models\ProjectLengthComponent;
use App\Models\ProjectIncomeComponent;
use App\Models\ProjectConstructionCost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeasibilityStudyController extends Controller
{
    protected $feasibilityStudy;

    public function __construct(FeasibilityStudy $feasibilityStudy)
    {
        $this->feasibilityStudy = $feasibilityStudy;
    }

    /**
     * Display a listing of feasibility studies
     */
    public function index()
    {
        $studies = $this->feasibilityStudy->list();
        
        return view('admin::feasibility-studies.index', [
            'studies' => $studies
        ]);
    }

    /**
     * Show the form for creating a new feasibility study
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        
        // Get project data for master study
        $projectFloors = ProjectFloor::getByProject($projectId);
        $projectLengthComponents = ProjectLengthComponent::getByProject($projectId);
        $projectIncomeComponents = ProjectIncomeComponent::getByProject($projectId);
        $projectConstructionCosts = ProjectConstructionCost::getByProject($projectId);
        
        // Get all currencies
        $currencies = \App\Models\Currency::whereNull('deleted_at')->get();
        
        return view('admin::feasibility-studies.create', compact(
            'project',
            'projectFloors',
            'projectLengthComponents',
            'projectIncomeComponents',
            'projectConstructionCosts',
            'currencies'
        ));
    }

    /**
     * Store a newly created feasibility study
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'study_name' => 'required|string|max:255',
            'study_type' => 'required|in:Master,Custom',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Active,Archived',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Create the feasibility study
            $data['created_by'] = Auth::id();
            $study = FeasibilityStudy::create($data);
            
            // If study type is Master or Custom, copy project data
            $this->copyProjectDataToStudy($study, $request);
            
            DB::commit();
            
            return redirect()->route('feasibility-study.show', ['id' => $study->id])
                ->with('success', 'Feasibility Study created successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified feasibility study with calculations
     */
    public function show($id)
    {
        $study = FeasibilityStudy::findWithRelations($id);
        
        if (!$study) {
            abort(404, 'Feasibility Study not found');
        }
        
        // Get all component data with calculations
        $calculations = $this->calculateStudy($id, $study->project_type_id);
        
        return view('admin::feasibility-studies.show', [
            'study' => $study,
            'calculations' => $calculations
        ]);
    }

    /**
     * Show the form for editing the specified feasibility study
     */
    public function edit($id)
    {
        $study = FeasibilityStudy::findOrFail($id);
        $project = Project::findOrFail($study->project_id);
        
        // Get study component data
        $studyBuildingComponents = FsBuildingComponent::getByStudy($id);
        $studyLengthComponents = FsLengthComponent::getByStudy($id);
        $studyIncomeComponents = FsIncomeComponent::getByStudy($id);
        $studyConstructionCost = FsConstructionCost::getByStudy($id);
        $studyProjectCost = FsProjectCost::getByStudy($id);
        
        // Get project floors for building components calculation
        $projectFloors = ProjectFloor::getByProject($study->project_id);
        
        // Get all currencies
        $currencies = \App\Models\Currency::whereNull('deleted_at')->get();
        
        return view('admin::feasibility-studies.edit', compact(
            'study',
            'project',
            'studyBuildingComponents',
            'studyLengthComponents',
            'studyIncomeComponents',
            'studyConstructionCost',
            'studyProjectCost',
            'projectFloors',
            'currencies'
        ));
    }

    /**
     * Update the specified feasibility study
     */
    public function update(Request $request, $id)
    {
        $study = FeasibilityStudy::findOrFail($id);
        
        $data = $request->validate([
            'study_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Draft,Active,Archived',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Update study metadata
            $study->update($data);
            
            // Update component values if custom study
            if ($study->isCustom()) {
                $this->updateStudyComponents($study, $request);
            }
            
            DB::commit();
            
            return redirect()->route('feasibility-study.show', ['id' => $study->id])
                ->with('success', 'Feasibility Study updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified feasibility study and all related data
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $study = FeasibilityStudy::findOrFail($id);
            $projectId = $study->project_id;
            
            // Prevent deletion of master study
            if ($study->isMaster()) {
                return redirect()->back()
                    ->with('error', 'Cannot delete Master Feasibility Study!');
            }
            
            // Explicitly delete all related data (cascade should handle this, but being explicit)
            // Delete building components
            FsBuildingComponent::where('feasibility_study_id', $id)->delete();
            
            // Delete length components
            FsLengthComponent::where('feasibility_study_id', $id)->delete();
            
            // Delete income components
            FsIncomeComponent::where('feasibility_study_id', $id)->delete();
            
            // Delete construction costs
            FsConstructionCost::where('feasibility_study_id', $id)->delete();
            
            // Delete project costs
            FsProjectCost::where('feasibility_study_id', $id)->delete();
            
            // Finally delete the study itself
            $study->delete();
            
            DB::commit();
            
            return redirect()->route('project.show', ['id' => $projectId])
                ->with('success', 'Feasibility Study and all related data deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to delete Feasibility Study: ' . $e->getMessage());
        }
    }
    
    /**
     * Permanently delete (force delete) a soft-deleted feasibility study
     */
    public function forceDestroy($id)
    {
        DB::beginTransaction();
        
        try {
            $study = FeasibilityStudy::withTrashed()->findOrFail($id);
            $projectId = $study->project_id;
            
            // Prevent deletion of master study
            if ($study->isMaster()) {
                return redirect()->back()
                    ->with('error', 'Cannot permanently delete Master Feasibility Study!');
            }
            
            // Force delete all related data
            FsBuildingComponent::where('feasibility_study_id', $id)->forceDelete();
            FsLengthComponent::where('feasibility_study_id', $id)->forceDelete();
            FsIncomeComponent::where('feasibility_study_id', $id)->forceDelete();
            FsConstructionCost::where('feasibility_study_id', $id)->forceDelete();
            FsProjectCost::where('feasibility_study_id', $id)->forceDelete();
            
            // Force delete the study
            $study->forceDelete();
            
            DB::commit();
            
            return redirect()->route('project.show', ['id' => $projectId])
                ->with('success', 'Feasibility Study permanently deleted!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to permanently delete Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate an existing feasibility study
     */
    public function duplicate($id)
    {
        DB::beginTransaction();
        
        try {
            $originalStudy = FeasibilityStudy::findOrFail($id);
            
            // Create new study
            $newStudy = FeasibilityStudy::create([
                'project_id' => $originalStudy->project_id,
                'study_name' => $originalStudy->study_name . ' (Copy)',
                'study_type' => 'Custom', // Always create as custom
                'description' => $originalStudy->description,
                'created_by' => Auth::id(),
                'status' => 'Draft',
            ]);
            
            // Copy all components
            $this->duplicateStudyComponents($originalStudy->id, $newStudy->id);
            
            DB::commit();
            
            return redirect()->route('feasibility-study.edit', ['id' => $newStudy->id])
                ->with('success', 'Feasibility Study duplicated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to duplicate Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Copy project data to new study
     */
    private function copyProjectDataToStudy($study, $request)
    {
        $projectId = $study->project_id;
        
        // Copy building components (from project building components)
        $projectBuildingComponents = DB::table('project_building_components')
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($projectBuildingComponents as $pbc) {
            $customCost = $request->input('building_cost_' . $pbc->building_component_id);
            FsBuildingComponent::create([
                'feasibility_study_id' => $study->id,
                'building_component_id' => $pbc->building_component_id,
                'construction_cost' => $customCost !== null && $customCost !== '' ? $customCost : $pbc->construction_cost,
            ]);
        }
        
        // Copy length components
        $projectLengthComponents = DB::table('project_length_components')
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($projectLengthComponents as $plc) {
            $customUnitCost = $request->input('length_cost_' . $plc->length_component_id);
            FsLengthComponent::create([
                'feasibility_study_id' => $study->id,
                'building_component_id' => $plc->building_component_id,
                'length_component_id' => $plc->length_component_id,
                'unit_cost' => $customUnitCost !== null && $customUnitCost !== '' ? $customUnitCost : $plc->unit_cost,
            ]);
        }
        
        // Copy income components
        $projectIncomeComponents = DB::table('project_income_components')
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($projectIncomeComponents as $pic) {
            $customUnits = $request->input('income_units_' . $pic->income_component_id);
            $customRent = $request->input('income_rent_' . $pic->income_component_id);
            FsIncomeComponent::create([
                'feasibility_study_id' => $study->id,
                'income_component_id' => $pic->income_component_id,
                'number_of_units' => $customUnits !== null && $customUnits !== '' ? $customUnits : $pic->number_of_units,
                'rent_per_year' => $customRent !== null && $customRent !== '' ? $customRent : $pic->rent_per_year,
            ]);
        }
        
        // Copy construction costs
        $projectConstructionCosts = DB::table('project_construction_costs')
            ->where('project_id', $projectId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($projectConstructionCosts) {
            $customSubstationCost = $request->input('substation_cost');
            $customPumpsCost = $request->input('pumps_cost');
            
            // Get original costs if not provided or empty
            $substationCost = 0;
            if ($customSubstationCost !== null && $customSubstationCost !== '') {
                $substationCost = $customSubstationCost;
            } elseif ($projectConstructionCosts->substation_room_id) {
                $substationRoom = DB::table('substation_rooms')->find($projectConstructionCosts->substation_room_id);
                $substationCost = $substationRoom ? $substationRoom->price : 0;
            }
            
            $pumpsCost = 0;
            if ($customPumpsCost !== null && $customPumpsCost !== '') {
                $pumpsCost = $customPumpsCost;
            } elseif ($projectConstructionCosts->pumps_room_id) {
                $pumpsRoom = DB::table('pumps_rooms')->find($projectConstructionCosts->pumps_room_id);
                $pumpsCost = $pumpsRoom ? $pumpsRoom->price : 0;
            }
            
            FsConstructionCost::create([
                'feasibility_study_id' => $study->id,
                'substation_room_id' => $projectConstructionCosts->substation_room_id,
                'substation_cost' => $substationCost,
                'pumps_room_id' => $projectConstructionCosts->pumps_room_id,
                'pumps_cost' => $pumpsCost,
            ]);
        }
        
        // Create project costs
        FsProjectCost::create([
            'feasibility_study_id' => $study->id,
            'land_cost' => $request->input('land_cost', 0),
            'consultant_cost' => $request->input('consultant_cost', 0),
            'government_fees' => $request->input('government_fees', 0),
            'additional_fees' => $request->input('additional_fees', 0),
        ]);
    }

    /**
     * Update study components
     */
    private function updateStudyComponents($study, $request)
    {
        // Update building components
        if ($request->has('building_costs')) {
            foreach ($request->input('building_costs') as $id => $cost) {
                FsBuildingComponent::where('id', $id)
                    ->where('feasibility_study_id', $study->id)
                    ->update(['construction_cost' => $cost]);
            }
        }
        
        // Update length components
        if ($request->has('length_costs')) {
            foreach ($request->input('length_costs') as $id => $cost) {
                FsLengthComponent::where('id', $id)
                    ->where('feasibility_study_id', $study->id)
                    ->update(['unit_cost' => $cost]);
            }
        }
        
        // Update income components
        if ($request->has('income_units')) {
            foreach ($request->input('income_units') as $id => $units) {
                FsIncomeComponent::where('id', $id)
                    ->where('feasibility_study_id', $study->id)
                    ->update(['number_of_units' => $units]);
            }
        }
        
        if ($request->has('income_rents')) {
            foreach ($request->input('income_rents') as $id => $rent) {
                FsIncomeComponent::where('id', $id)
                    ->where('feasibility_study_id', $study->id)
                    ->update(['rent_per_year' => $rent]);
            }
        }
        
        // Update construction costs
        if ($request->has('substation_cost') || $request->has('pumps_cost')) {
            $constructionCost = FsConstructionCost::where('feasibility_study_id', $study->id)->first();
            if ($constructionCost) {
                $constructionCost->update([
                    'substation_cost' => $request->input('substation_cost', $constructionCost->substation_cost),
                    'pumps_cost' => $request->input('pumps_cost', $constructionCost->pumps_cost),
                ]);
            }
        }
        
        // Update project costs
        $projectCost = FsProjectCost::where('feasibility_study_id', $study->id)->first();
        if ($projectCost) {
            $projectCost->update([
                'land_cost' => $request->input('land_cost', $projectCost->land_cost),
                'consultant_cost' => $request->input('consultant_cost', $projectCost->consultant_cost),
                'government_fees' => $request->input('government_fees', $projectCost->government_fees),
                'additional_fees' => $request->input('additional_fees', $projectCost->additional_fees),
            ]);
        }
    }

    /**
     * Duplicate study components
     */
    private function duplicateStudyComponents($originalStudyId, $newStudyId)
    {
        // Duplicate building components
        $buildingComponents = FsBuildingComponent::where('feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($buildingComponents as $bc) {
            FsBuildingComponent::create([
                'feasibility_study_id' => $newStudyId,
                'building_component_id' => $bc->building_component_id,
                'construction_cost' => $bc->construction_cost,
            ]);
        }
        
        // Duplicate length components
        $lengthComponents = FsLengthComponent::where('feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($lengthComponents as $lc) {
            FsLengthComponent::create([
                'feasibility_study_id' => $newStudyId,
                'building_component_id' => $lc->building_component_id,
                'length_component_id' => $lc->length_component_id,
                'unit_cost' => $lc->unit_cost,
            ]);
        }
        
        // Duplicate income components
        $incomeComponents = FsIncomeComponent::where('feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($incomeComponents as $ic) {
            FsIncomeComponent::create([
                'feasibility_study_id' => $newStudyId,
                'income_component_id' => $ic->income_component_id,
                'number_of_units' => $ic->number_of_units,
                'rent_per_year' => $ic->rent_per_year,
            ]);
        }
        
        // Duplicate construction costs
        $constructionCost = FsConstructionCost::where('feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($constructionCost) {
            FsConstructionCost::create([
                'feasibility_study_id' => $newStudyId,
                'substation_room_id' => $constructionCost->substation_room_id,
                'substation_cost' => $constructionCost->substation_cost,
                'pumps_room_id' => $constructionCost->pumps_room_id,
                'pumps_cost' => $constructionCost->pumps_cost,
            ]);
        }
        
        // Duplicate project costs
        $projectCost = FsProjectCost::where('feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($projectCost) {
            FsProjectCost::create([
                'feasibility_study_id' => $newStudyId,
                'land_cost' => $projectCost->land_cost,
                'consultant_cost' => $projectCost->consultant_cost,
                'government_fees' => $projectCost->government_fees,
                'additional_fees' => $projectCost->additional_fees,
            ]);
        }
    }

    /**
     * Calculate all study components and totals
     */
    private function calculateStudy($studyId, $projectTypeId)
    {
        $calculations = [];
        
        // Get headers from feasibility_study_components
        $headers = FeasibilityStudyComponent::where('project_type_id', $projectTypeId)
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();
        
        // Calculate Building Components
        $calculations['building_components'] = $this->calculateBuildingComponents($studyId, $headers);
        
        // Calculate Length Components
        $calculations['length_components'] = $this->calculateLengthComponents($studyId, $headers);
        
        // Calculate Construction Costs
        $calculations['construction_costs'] = $this->calculateConstructionCosts($studyId, $headers);
        
        // Calculate Project Costs
        $calculations['project_costs'] = $this->calculateProjectCosts($studyId, $headers, $calculations);
        
        // Calculate Income Components
        $calculations['income_components'] = $this->calculateIncomeComponents($studyId, $headers);
        
        return $calculations;
    }

    /**
     * Public method to calculate study for front-end display
     */
    public function calculateStudyPublic($studyId, $projectTypeId)
    {
        return $this->calculateStudy($studyId, $projectTypeId);
    }

    /**
     * Calculate building components with floors
     */
    private function calculateBuildingComponents($studyId, $headers)
    {
        $result = [
            'header' => $headers->where('target', 'Building Components')->first(),
            'items' => [],
            'total' => 0
        ];
        
        // Get study building components
        $studyBuildingComponents = FsBuildingComponent::getByStudy($studyId);
        
        // Get study info to find project ID
        $study = FeasibilityStudy::find($studyId);
        
        // Get project floors grouped by building component
        $projectFloors = DB::table('project_floors as pf')
            ->join('floor_components as fc', 'pf.floor_component_id', '=', 'fc.id')
            ->select(
                'pf.building_component_id',
                'fc.name_english as floor_name',
                'fc.name_arabic as floor_name_ar',
                'pf.sqft',
                'pf.count',
                DB::raw('(pf.sqft * pf.count) as total_area')
            )
            ->where('pf.project_id', $study->project_id)
            ->whereNull('pf.deleted_at')
            ->whereNull('fc.deleted_at')
            ->get()
            ->groupBy('building_component_id');
        
        foreach ($studyBuildingComponents as $component) {
            $floors = $projectFloors->get($component->building_component_id, collect());
            
            $totalBuildArea = $floors->sum('total_area');
            $totalCost = $totalBuildArea * $component->construction_cost;
            
            $result['items'][] = [
                'component' => $component,
                'floors' => $floors,
                'total_build_area' => $totalBuildArea,
                'total_cost' => $totalCost
            ];
            
            $result['total'] += $totalCost;
        }
        
        return $result;
    }

    /**
     * Calculate length components
     */
    private function calculateLengthComponents($studyId, $headers)
    {
        $result = [
            'header' => $headers->where('target', 'Length Components')->first(),
            'items' => [],
            'total' => 0
        ];
        
        // Get study length components
        $studyLengthComponents = FsLengthComponent::getByStudy($studyId);
        
        // For now, since project_length_components doesn't have length/count columns,
        // we'll just show the unit costs. This can be expanded later if length/count fields are added.
        foreach ($studyLengthComponents as $component) {
            // Using placeholder values - update this when length/count fields are added to the table
            $length = 1; // Default length
            $count = 1;  // Default count
            $totalLength = $length * $count;
            $totalCost = $totalLength * $component->unit_cost;
            
            $result['items'][] = [
                'component' => $component,
                'length' => $length,
                'count' => $count,
                'total_length' => $totalLength,
                'total_cost' => $totalCost
            ];
            
            $result['total'] += $totalCost;
        }
        
        return $result;
    }

    /**
     * Calculate construction costs
     */
    private function calculateConstructionCosts($studyId, $headers)
    {
        $result = [
            'header' => $headers->where('target', 'Construction Cost')->first(),
            'substation_cost' => 0,
            'pumps_cost' => 0,
            'total' => 0
        ];
        
        $constructionCost = FsConstructionCost::getByStudy($studyId);
        
        if ($constructionCost) {
            $result['substation_cost'] = $constructionCost->substation_cost ?? 0;
            $result['pumps_cost'] = $constructionCost->pumps_cost ?? 0;
            $result['substation_name'] = $constructionCost->substation_name_en;
            $result['pumps_name'] = $constructionCost->pumps_name_en;
            $result['total'] = $result['substation_cost'] + $result['pumps_cost'];
        }
        
        return $result;
    }

    /**
     * Calculate project costs
     */
    private function calculateProjectCosts($studyId, $headers, $previousCalculations)
    {
        $result = [
            'header' => $headers->where('target', 'Project Cost')->first(),
            'construction_cost' => 0,
            'land_cost' => 0,
            'consultant_cost' => 0,
            'government_fees' => 0,
            'additional_fees' => 0,
            'total' => 0
        ];
        
        // Total construction cost = building + length + construction rooms
        $result['construction_cost'] = 
            ($previousCalculations['building_components']['total'] ?? 0) +
            ($previousCalculations['length_components']['total'] ?? 0) +
            ($previousCalculations['construction_costs']['total'] ?? 0);
        
        // Get project costs
        $projectCost = FsProjectCost::getByStudy($studyId);
        
        if ($projectCost) {
            $result['land_cost'] = $projectCost->land_cost;
            $result['consultant_cost'] = $projectCost->consultant_cost;
            $result['government_fees'] = $projectCost->government_fees;
            $result['additional_fees'] = $projectCost->additional_fees;
        }
        
        $result['total'] = 
            $result['construction_cost'] +
            $result['land_cost'] +
            $result['consultant_cost'] +
            $result['government_fees'] +
            $result['additional_fees'];
        
        return $result;
    }

    /**
     * Calculate income components
     */
    private function calculateIncomeComponents($studyId, $headers)
    {
        $result = [
            'header' => $headers->where('target', 'Income Components')->first(),
            'items' => [],
            'total' => 0
        ];
        
        $incomeComponents = FsIncomeComponent::getByStudy($studyId);
        
        foreach ($incomeComponents as $component) {
            $totalIncome = $component->number_of_units * $component->rent_per_year;
            
            $result['items'][] = [
                'component' => $component,
                'total_income' => $totalIncome
            ];
            
            $result['total'] += $totalIncome;
        }
        
        return $result;
    }
}

