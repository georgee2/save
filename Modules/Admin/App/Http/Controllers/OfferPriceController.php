<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\OffersPrices\OfferPrice;
use App\Models\Offer;

class OfferPriceController extends Controller
{
    /**
     * Get available emirates for an offer (AJAX)
     */
    public function getAvailableEmirates($offerId)
    {
        $emirates = OfferPrice::getAvailableEmirates($offerId);
        
        return response()->json([
            'success' => true,
            'emirates' => $emirates
        ]);
    }
    
    /**
     * Store a new price for an offer (AJAX)
     */
    public function store(Request $request, $offerId)
    {
        $request->validate([
            'emirate_id' => 'required|exists:emirates,id',
            'price' => 'required|numeric|min:0',
            'notes_english' => 'nullable|string|max:255',
            'notes_arabic' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);
        
        // Check if this emirate price already exists for this offer
        $exists = OfferPrice::where('offer_id', $offerId)
            ->where('emirate_id', $request->emirate_id)
            ->whereNull('deleted_at')
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Price for this emirate already exists!'
            ], 422);
        }
        
        OfferPrice::create([
            'offer_id' => $offerId,
            'emirate_id' => $request->emirate_id,
            'price' => $request->price,
            'notes_english' => $request->notes_english,
            'notes_arabic' => $request->notes_arabic,
            'status' => $request->status,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Price added successfully!'
        ]);
    }
    
    /**
     * Update a price (AJAX)
     */
    public function update(Request $request, $offerId, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'notes_english' => 'nullable|string|max:255',
            'notes_arabic' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
        ]);
        
        $offerPrice = OfferPrice::where('offer_id', $offerId)
            ->where('id', $id)
            ->firstOrFail();
        
        $offerPrice->update([
            'price' => $request->price,
            'notes_english' => $request->notes_english,
            'notes_arabic' => $request->notes_arabic,
            'status' => $request->status,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Price updated successfully!'
        ]);
    }
    
    /**
     * Delete a price (AJAX - Soft Delete)
     */
    public function destroy($offerId, $id)
    {
        $offerPrice = OfferPrice::where('offer_id', $offerId)
            ->where('id', $id)
            ->firstOrFail();
        
        $offerPrice->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Price deleted successfully!'
        ]);
    }
    
    /**
     * Restore a trashed price (AJAX)
     */
    public function restore($offerId, $id)
    {
        $offerPrice = OfferPrice::withTrashed()
            ->where('offer_id', $offerId)
            ->where('id', $id)
            ->firstOrFail();
        
        $offerPrice->restore();
        
        return response()->json([
            'success' => true,
            'message' => 'Price restored successfully!'
        ]);
    }
}

