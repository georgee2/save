<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Offer;
use App\Models\OfferFloor;
use App\Models\OfferFloorSpecification;
use App\Models\Specification;

class OfferFloorSpecificationController extends Controller
{
    /**
     * Display a listing of specifications for a floor
     */
    public function index($offerId, $floorId)
    {
        $offer = Offer::findOrFail($offerId);
        $floor = OfferFloor::findOrFail($floorId);
        $specifications = OfferFloorSpecification::getByFloor($floorId);
        $trashedSpecifications = OfferFloorSpecification::getTrashedByFloor($floorId);
        
        return view('admin::offers.floors.specifications.index', compact('offer', 'floor', 'specifications', 'trashedSpecifications'));
    }

    /**
     * Show the form for creating a new specification
     */
    public function create($offerId, $floorId)
    {
        $offer = Offer::findOrFail($offerId);
        $floor = OfferFloor::findOrFail($floorId);
        
        // Get specifications filtered by offer type
        $availableSpecifications = Specification::where('type_id', $offer->type_id)
            ->where('status', 0) // Only active specifications
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return view('admin::offers.floors.specifications.create', compact('offer', 'floor', 'availableSpecifications'));
    }

    /**
     * Store a newly created specification
     */
    public function store(Request $request, $offerId, $floorId)
    {
        $request->validate([
            'specification_id' => 'required|exists:specifications,id',
            'value_english' => 'required|string|max:255',
            'value_arabic' => 'required|string|max:255',
        ]);

        OfferFloorSpecification::create([
            'offer_id' => $offerId,
            'floor_id' => $floorId,
            'specification_id' => $request->specification_id,
            'value_english' => $request->value_english,
            'value_arabic' => $request->value_arabic,
        ]);

        return redirect()->route('offer.floor.specification.index', ['offerId' => $offerId, 'floorId' => $floorId])
            ->with('success', 'Specification added successfully!');
    }

    /**
     * Show the form for editing the specified specification
     */
    public function edit($offerId, $floorId, $id)
    {
        $offer = Offer::findOrFail($offerId);
        $floor = OfferFloor::findOrFail($floorId);
        $floorSpecification = OfferFloorSpecification::findOrFail($id);
        
        // Get specifications filtered by offer type
        $availableSpecifications = Specification::where('type_id', $offer->type_id)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('title_english')
            ->get();
        
        return view('admin::offers.floors.specifications.edit', compact('offer', 'floor', 'floorSpecification', 'availableSpecifications'));
    }

    /**
     * Update the specified specification
     */
    public function update(Request $request, $offerId, $floorId, $id)
    {
        $floorSpecification = OfferFloorSpecification::findOrFail($id);
        
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

        return redirect()->route('offer.floor.specification.index', ['offerId' => $offerId, 'floorId' => $floorId])
            ->with('success', 'Specification updated successfully!');
    }

    /**
     * Soft delete the specification
     */
    public function destroy($offerId, $floorId, $id)
    {
        $floorSpecification = OfferFloorSpecification::findOrFail($id);
        $floorSpecification->delete();

        return redirect()->route('offer.floor.specification.index', ['offerId' => $offerId, 'floorId' => $floorId])
            ->with('success', 'Specification deleted successfully!');
    }

    /**
     * Restore trashed specification
     */
    public function restore($offerId, $floorId, $id)
    {
        $floorSpecification = OfferFloorSpecification::withTrashed()->findOrFail($id);
        $floorSpecification->restore();

        return redirect()->route('offer.floor.specification.index', ['offerId' => $offerId, 'floorId' => $floorId])
            ->with('success', 'Specification restored successfully!');
    }
}

