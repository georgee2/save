<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OfferFeasibilityStudy;
use App\Models\OfferFsBuildingComponent;
use App\Models\OfferFsLengthComponent;
use App\Models\OfferFsIncomeComponent;
use App\Models\OfferFsConstructionCost;
use App\Models\OfferFsProjectCost;
use App\Models\Offer;
use App\Models\FeasibilityStudyComponent;
use App\Models\OfferFloor;
use App\Models\OfferLengthComponent;
use App\Models\OfferIncomeComponent;
use App\Models\OfferConstructionCost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferFeasibilityStudyController extends Controller
{
    /**
     * Display a listing of feasibility studies
     */
    public function index()
    {
        $studies = OfferFeasibilityStudy::list();
        
        return view('admin::offer-feasibility-studies.index', [
            'studies' => $studies
        ]);
    }

    /**
     * Show the form for creating a new feasibility study
     */
    public function create($offerId)
    {
        $offer = Offer::findOrFail($offerId);
        
        // Get offer data for master study
        $offerFloors = OfferFloor::getByOffer($offerId);
        $offerLengthComponents = OfferLengthComponent::getByOffer($offerId);
        $offerIncomeComponents = OfferIncomeComponent::getByOffer($offerId);
        $offerConstructionCosts = OfferConstructionCost::getByOffer($offerId);
        
        // Get offer prices by emirate
        $offerPrices = \App\Models\OffersPrices\OfferPrice::getByOffer($offerId);
        
        // Get all currencies
        $currencies = \App\Models\Currency::whereNull('deleted_at')->get();
        
        return view('admin::offer-feasibility-studies.create', compact(
            'offer',
            'offerFloors',
            'offerLengthComponents',
            'offerIncomeComponents',
            'offerConstructionCosts',
            'offerPrices',
            'currencies'
        ));
    }

    /**
     * Store a newly created feasibility study
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'emirate_id' => 'required|exists:emirates,id',
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
            $study = OfferFeasibilityStudy::create($data);
            
            // If study type is Master or Custom, copy offer data
            $this->copyOfferDataToStudy($study, $request);
            
            DB::commit();
            
            return redirect()->route('offer-feasibility-study.show', ['id' => $study->id])
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
        $study = OfferFeasibilityStudy::findWithRelations($id);
        
        if (!$study) {
            abort(404, 'Feasibility Study not found');
        }
        
        // Get all component data with calculations
        $calculations = $this->calculateStudy($id, $study->offer_type_id);
        
        return view('admin::offer-feasibility-studies.show', [
            'study' => $study,
            'calculations' => $calculations
        ]);
    }

    /**
     * Show the form for editing the specified feasibility study
     */
    public function edit($id)
    {
        $study = OfferFeasibilityStudy::findOrFail($id);
        $offer = Offer::findOrFail($study->offer_id);
        
        // Get study component data
        $studyBuildingComponents = OfferFsBuildingComponent::getByStudy($id);
        $studyLengthComponents = OfferFsLengthComponent::getByStudy($id);
        $studyIncomeComponents = OfferFsIncomeComponent::getByStudy($id);
        $studyConstructionCost = OfferFsConstructionCost::getByStudy($id);
        $studyProjectCost = OfferFsProjectCost::getByStudy($id);
        
        // Get offer floors for building components calculation
        $offerFloors = OfferFloor::getByOffer($study->offer_id);
        
        // Get all currencies
        $currencies = \App\Models\Currency::whereNull('deleted_at')->get();
        
        return view('admin::offer-feasibility-studies.edit', compact(
            'study',
            'offer',
            'studyBuildingComponents',
            'studyLengthComponents',
            'studyIncomeComponents',
            'studyConstructionCost',
            'studyProjectCost',
            'offerFloors',
            'currencies'
        ));
    }

    /**
     * Update the specified feasibility study
     */
    public function update(Request $request, $id)
    {
        $study = OfferFeasibilityStudy::findOrFail($id);
        
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
            
            return redirect()->route('offer-feasibility-study.show', ['id' => $study->id])
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
            $study = OfferFeasibilityStudy::findOrFail($id);
            $offerId = $study->offer_id;
            
            // Prevent deletion of master study
            if ($study->isMaster()) {
                return redirect()->back()
                    ->with('error', 'Cannot delete Master Feasibility Study!');
            }
            
            // Delete all related data
            OfferFsBuildingComponent::where('offer_feasibility_study_id', $id)->delete();
            OfferFsLengthComponent::where('offer_feasibility_study_id', $id)->delete();
            OfferFsIncomeComponent::where('offer_feasibility_study_id', $id)->delete();
            OfferFsConstructionCost::where('offer_feasibility_study_id', $id)->delete();
            OfferFsProjectCost::where('offer_feasibility_study_id', $id)->delete();
            
            // Finally delete the study itself
            $study->delete();
            
            DB::commit();
            
            return redirect()->route('offer.show', ['id' => $offerId])
                ->with('success', 'Feasibility Study and all related data deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to delete Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate an existing feasibility study
     */
    public function duplicate($id)
    {
        DB::beginTransaction();
        
        try {
            $originalStudy = OfferFeasibilityStudy::findOrFail($id);
            
            // Create new study
            $newStudy = OfferFeasibilityStudy::create([
                'offer_id' => $originalStudy->offer_id,
                'study_name' => $originalStudy->study_name . ' (Copy)',
                'study_type' => 'Custom',
                'description' => $originalStudy->description,
                'created_by' => Auth::id(),
                'status' => 'Draft',
            ]);
            
            // Copy all components
            $this->duplicateStudyComponents($originalStudy->id, $newStudy->id);
            
            DB::commit();
            
            return redirect()->route('offer-feasibility-study.edit', ['id' => $newStudy->id])
                ->with('success', 'Feasibility Study duplicated successfully!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to duplicate Feasibility Study: ' . $e->getMessage());
        }
    }

    /**
     * Copy offer data to new study
     */
    private function copyOfferDataToStudy($study, $request)
    {
        $offerId = $study->offer_id;
        
        // Copy building components (from offer building components)
        $offerBuildingComponents = DB::table('offer_building_components')
            ->where('offer_id', $offerId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($offerBuildingComponents as $obc) {
            $customCost = $request->input('building_cost_' . $obc->building_component_id);
            OfferFsBuildingComponent::create([
                'offer_feasibility_study_id' => $study->id,
                'building_component_id' => $obc->building_component_id,
                'construction_cost' => $customCost !== null && $customCost !== '' ? $customCost : $obc->construction_cost,
            ]);
        }
        
        // Copy length components
        $offerLengthComponents = DB::table('offer_length_components')
            ->where('offer_id', $offerId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($offerLengthComponents as $olc) {
            $customUnitCost = $request->input('length_cost_' . $olc->length_component_id);
            OfferFsLengthComponent::create([
                'offer_feasibility_study_id' => $study->id,
                'building_component_id' => $olc->building_component_id,
                'length_component_id' => $olc->length_component_id,
                'unit_cost' => $customUnitCost !== null && $customUnitCost !== '' ? $customUnitCost : $olc->unit_cost,
            ]);
        }
        
        // Copy income components
        $offerIncomeComponents = DB::table('offer_income_components')
            ->where('offer_id', $offerId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($offerIncomeComponents as $oic) {
            $customUnits = $request->input('income_units_' . $oic->income_component_id);
            $customRent = $request->input('income_rent_' . $oic->income_component_id);
            OfferFsIncomeComponent::create([
                'offer_feasibility_study_id' => $study->id,
                'income_component_id' => $oic->income_component_id,
                'number_of_units' => $customUnits !== null && $customUnits !== '' ? $customUnits : $oic->number_of_units,
                'rent_per_year' => $customRent !== null && $customRent !== '' ? $customRent : $oic->rent_per_year,
            ]);
        }
        
        // Copy construction costs
        $offerConstructionCosts = DB::table('offer_construction_costs')
            ->where('offer_id', $offerId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($offerConstructionCosts) {
            $customSubstationCost = $request->input('substation_cost');
            $customPumpsCost = $request->input('pumps_cost');
            
            $substationCost = 0;
            if ($customSubstationCost !== null && $customSubstationCost !== '') {
                $substationCost = $customSubstationCost;
            } elseif ($offerConstructionCosts->substation_room_id) {
                $substationRoom = DB::table('substation_rooms')->find($offerConstructionCosts->substation_room_id);
                $substationCost = $substationRoom ? $substationRoom->price : 0;
            }
            
            $pumpsCost = 0;
            if ($customPumpsCost !== null && $customPumpsCost !== '') {
                $pumpsCost = $customPumpsCost;
            } elseif ($offerConstructionCosts->pumps_room_id) {
                $pumpsRoom = DB::table('pumps_rooms')->find($offerConstructionCosts->pumps_room_id);
                $pumpsCost = $pumpsRoom ? $pumpsRoom->price : 0;
            }
            
            OfferFsConstructionCost::create([
                'offer_feasibility_study_id' => $study->id,
                'substation_room_id' => $offerConstructionCosts->substation_room_id,
                'substation_cost' => $substationCost,
                'pumps_room_id' => $offerConstructionCosts->pumps_room_id,
                'pumps_cost' => $pumpsCost,
            ]);
        }
        
        // Create project costs
        OfferFsProjectCost::create([
            'offer_feasibility_study_id' => $study->id,
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
                OfferFsBuildingComponent::where('id', $id)
                    ->where('offer_feasibility_study_id', $study->id)
                    ->update(['construction_cost' => $cost]);
            }
        }
        
        // Update length components
        if ($request->has('length_costs')) {
            foreach ($request->input('length_costs') as $id => $cost) {
                OfferFsLengthComponent::where('id', $id)
                    ->where('offer_feasibility_study_id', $study->id)
                    ->update(['unit_cost' => $cost]);
            }
        }
        
        // Update income components
        if ($request->has('income_units')) {
            foreach ($request->input('income_units') as $id => $units) {
                OfferFsIncomeComponent::where('id', $id)
                    ->where('offer_feasibility_study_id', $study->id)
                    ->update(['number_of_units' => $units]);
            }
        }
        
        if ($request->has('income_rents')) {
            foreach ($request->input('income_rents') as $id => $rent) {
                OfferFsIncomeComponent::where('id', $id)
                    ->where('offer_feasibility_study_id', $study->id)
                    ->update(['rent_per_year' => $rent]);
            }
        }
        
        // Update construction costs
        if ($request->has('substation_cost') || $request->has('pumps_cost')) {
            $constructionCost = OfferFsConstructionCost::where('offer_feasibility_study_id', $study->id)->first();
            if ($constructionCost) {
                $constructionCost->update([
                    'substation_cost' => $request->input('substation_cost', $constructionCost->substation_cost),
                    'pumps_cost' => $request->input('pumps_cost', $constructionCost->pumps_cost),
                ]);
            }
        }
        
        // Update project costs
        $projectCost = OfferFsProjectCost::where('offer_feasibility_study_id', $study->id)->first();
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
        $buildingComponents = OfferFsBuildingComponent::where('offer_feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($buildingComponents as $bc) {
            OfferFsBuildingComponent::create([
                'offer_feasibility_study_id' => $newStudyId,
                'building_component_id' => $bc->building_component_id,
                'construction_cost' => $bc->construction_cost,
            ]);
        }
        
        // Duplicate length components
        $lengthComponents = OfferFsLengthComponent::where('offer_feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($lengthComponents as $lc) {
            OfferFsLengthComponent::create([
                'offer_feasibility_study_id' => $newStudyId,
                'building_component_id' => $lc->building_component_id,
                'length_component_id' => $lc->length_component_id,
                'unit_cost' => $lc->unit_cost,
            ]);
        }
        
        // Duplicate income components
        $incomeComponents = OfferFsIncomeComponent::where('offer_feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->get();
            
        foreach ($incomeComponents as $ic) {
            OfferFsIncomeComponent::create([
                'offer_feasibility_study_id' => $newStudyId,
                'income_component_id' => $ic->income_component_id,
                'number_of_units' => $ic->number_of_units,
                'rent_per_year' => $ic->rent_per_year,
            ]);
        }
        
        // Duplicate construction costs
        $constructionCost = OfferFsConstructionCost::where('offer_feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($constructionCost) {
            OfferFsConstructionCost::create([
                'offer_feasibility_study_id' => $newStudyId,
                'substation_room_id' => $constructionCost->substation_room_id,
                'substation_cost' => $constructionCost->substation_cost,
                'pumps_room_id' => $constructionCost->pumps_room_id,
                'pumps_cost' => $constructionCost->pumps_cost,
            ]);
        }
        
        // Duplicate project costs
        $projectCost = OfferFsProjectCost::where('offer_feasibility_study_id', $originalStudyId)
            ->whereNull('deleted_at')
            ->first();
            
        if ($projectCost) {
            OfferFsProjectCost::create([
                'offer_feasibility_study_id' => $newStudyId,
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
    private function calculateStudy($studyId, $offerTypeId)
    {
        $calculations = [];
        
        // Get headers from feasibility_study_components
        $headers = FeasibilityStudyComponent::where('project_type_id', $offerTypeId)
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
     * Calculate building components with floors
     */
    private function calculateBuildingComponents($studyId, $headers)
    {
        $result = [
            'header' => $headers->where('target', 'Building Components')->first(),
            'items' => [],
            'total' => 0
        ];
        
        $studyBuildingComponents = OfferFsBuildingComponent::getByStudy($studyId);
        $study = OfferFeasibilityStudy::find($studyId);
        
        // Get offer floors grouped by building component
        $offerFloors = DB::table('offer_floors as of')
            ->join('floor_components as fc', 'of.floor_component_id', '=', 'fc.id')
            ->select(
                'of.building_component_id',
                'fc.name_english as floor_name',
                'fc.name_arabic as floor_name_ar',
                'of.sqft',
                'of.count',
                DB::raw('(of.sqft * of.count) as total_area')
            )
            ->where('of.offer_id', $study->offer_id)
            ->whereNull('of.deleted_at')
            ->whereNull('fc.deleted_at')
            ->get()
            ->groupBy('building_component_id');
        
        foreach ($studyBuildingComponents as $component) {
            $floors = $offerFloors->get($component->building_component_id, collect());
            
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
        
        $studyLengthComponents = OfferFsLengthComponent::getByStudy($studyId);
        
        foreach ($studyLengthComponents as $component) {
            $length = 1;
            $count = 1;
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
        
        $constructionCost = OfferFsConstructionCost::getByStudy($studyId);
        
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
        
        $result['construction_cost'] = 
            ($previousCalculations['building_components']['total'] ?? 0) +
            ($previousCalculations['length_components']['total'] ?? 0) +
            ($previousCalculations['construction_costs']['total'] ?? 0);
        
        $projectCost = OfferFsProjectCost::getByStudy($studyId);
        
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
        
        $incomeComponents = OfferFsIncomeComponent::getByStudy($studyId);
        
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

