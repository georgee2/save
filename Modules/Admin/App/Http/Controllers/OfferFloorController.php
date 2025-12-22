<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Offer;
use App\Models\OfferFloor;
use App\Models\BuildingComponent;
use App\Models\FloorComponent;
use App\Models\OfferBuildingComponent;
use Illuminate\Support\Facades\Storage;
use Image;

class OfferFloorController extends Controller
{
    /**
     * Display a listing of floors for an offer
     */
    public function index($offerId)
    {
        $offer = Offer::findOrFail($offerId);
        $floors = OfferFloor::getByOffer($offerId);
        $trashedFloors = OfferFloor::getTrashedByOffer($offerId);
        
        return view('admin::offers.floors.index', compact('offer', 'floors', 'trashedFloors'));
    }

    /**
     * Show the form for creating a new floor
     */
    public function create($offerId)
    {
        $offer = Offer::findOrFail($offerId);
        
        // Get building components assigned to this offer
        $offerBuildingComponents = OfferBuildingComponent::getByOffer($offerId);
        
        return view('admin::offers.floors.create', compact('offer', 'offerBuildingComponents'));
    }

    /**
     * Store a newly created floor
     */
    public function store(Request $request, $offerId)
    {
        $request->validate([
            'building_component_id' => 'required|exists:building_components,id',
            'floor_component_id' => 'required|exists:floor_components,id',
            'sqft' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'image_3d' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_2d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'offer_id' => $offerId,
            'building_component_id' => $request->building_component_id,
            'floor_component_id' => $request->floor_component_id,
            'sqft' => $request->sqft,
            'sqm' => $request->sqft * 0.092903, // Auto calculate SqM from SqFt
            'count' => $request->count,
        ];

        // Handle 3D image upload (required) - Convert to WebP 870x420
        if ($request->hasFile('image_3d')) {
            $data['image_3d'] = $this->handleImageUpload($request->file('image_3d'), 870, 420, '3d');
        }

        // Handle 2D image upload (optional) - Convert to WebP 870x420
        if ($request->hasFile('image_2d')) {
            $data['image_2d'] = $this->handleImageUpload($request->file('image_2d'), 870, 420, '2d');
        }

        OfferFloor::create($data);

        return redirect()->route('offer.floor.index', ['offerId' => $offerId])
            ->with('success', 'Floor added successfully!');
    }

    /**
     * Display the specified floor
     */
    public function show($offerId, $id)
    {
        $offer = Offer::findOrFail($offerId);
        $floor = OfferFloor::findOrFail($id);
        
        return view('admin::offers.floors.show', compact('offer', 'floor'));
    }

    /**
     * Show the form for editing the specified floor
     */
    public function edit($offerId, $id)
    {
        $offer = Offer::findOrFail($offerId);
        $floor = OfferFloor::findOrFail($id);
        
        // Get building components assigned to this offer
        $offerBuildingComponents = OfferBuildingComponent::getByOffer($offerId);
        
        // Get floor components for the selected building component
        $floorComponents = FloorComponent::where('component_id', $floor->building_component_id)
            ->whereNull('deleted_at')
            ->get();
        
        return view('admin::offers.floors.edit', compact('offer', 'floor', 'offerBuildingComponents', 'floorComponents'));
    }

    /**
     * Update the specified floor
     */
    public function update(Request $request, $offerId, $id)
    {
        $floor = OfferFloor::findOrFail($id);
        
        $request->validate([
            'building_component_id' => 'required|exists:building_components,id',
            'floor_component_id' => 'required|exists:floor_components,id',
            'sqft' => 'required|numeric|min:0',
            'count' => 'required|integer|min:1',
            'image_3d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_2d' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'building_component_id' => $request->building_component_id,
            'floor_component_id' => $request->floor_component_id,
            'sqft' => $request->sqft,
            'sqm' => $request->sqft * 0.092903, // Auto calculate SqM from SqFt
            'count' => $request->count,
        ];

        // Handle 3D image upload - Convert to WebP 870x420
        if ($request->hasFile('image_3d')) {
            if ($floor->image_3d) {
                Storage::disk('public')->delete(ltrim($floor->image_3d, '/'));
            }
            $data['image_3d'] = $this->handleImageUpload($request->file('image_3d'), 870, 420, '3d');
        }

        // Handle 2D image upload - Convert to WebP 870x420
        if ($request->hasFile('image_2d')) {
            if ($floor->image_2d) {
                Storage::disk('public')->delete(ltrim($floor->image_2d, '/'));
            }
            $data['image_2d'] = $this->handleImageUpload($request->file('image_2d'), 870, 420, '2d');
        }

        $floor->update($data);

        return redirect()->route('offer.floor.index', ['offerId' => $offerId])
            ->with('success', 'Floor updated successfully!');
    }

    /**
     * Soft delete the floor
     */
    public function destroy($offerId, $id)
    {
        $floor = OfferFloor::findOrFail($id);
        $floor->delete();

        return redirect()->route('offer.floor.index', ['offerId' => $offerId])
            ->with('success', 'Floor deleted successfully!');
    }

    /**
     * Restore trashed floor
     */
    public function restore($offerId, $id)
    {
        $floor = OfferFloor::withTrashed()->findOrFail($id);
        $floor->restore();

        return redirect()->route('offer.floor.index', ['offerId' => $offerId])
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
        Storage::disk('public')->put('/uploads/offers/floors/' . $filename, (string) $image);
        
        return '/uploads/offers/floors/' . $filename;
    }
}

