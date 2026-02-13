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
     * Bulk store multiple prices for an offer (AJAX)
     */
    public function bulkStore(Request $request, $offerId)
    {
        try {
            $request->validate([
                'prices' => 'required|array|min:1',
                'prices.*.emirate_id' => 'required|exists:emirates,id',
                'prices.*.price' => 'required|numeric|min:0',
                'prices.*.notes_english' => 'nullable|string|max:255',
                'prices.*.notes_arabic' => 'nullable|string|max:255',
                'prices.*.status' => 'required|in:0,1',
            ]);
            
            $addedCount = 0;
            $skippedCount = 0;
            
            // Get already added emirate IDs
            $existingEmirateIds = OfferPrice::where('offer_id', $offerId)
                ->whereNull('deleted_at')
                ->pluck('emirate_id')
                ->toArray();
            
            foreach ($request->prices as $priceData) {
                // Skip if emirate price already exists for this offer
                if (in_array($priceData['emirate_id'], $existingEmirateIds)) {
                    $skippedCount++;
                    continue;
                }
                
                OfferPrice::create([
                    'offer_id' => $offerId,
                    'emirate_id' => $priceData['emirate_id'],
                    'price' => $priceData['price'],
                    'notes_english' => $priceData['notes_english'] ?? null,
                    'notes_arabic' => $priceData['notes_arabic'] ?? null,
                    'status' => $priceData['status'],
                ]);
                
                $addedCount++;
                $existingEmirateIds[] = $priceData['emirate_id']; // Prevent duplicates in same batch
            }
            
            $message = "{$addedCount} price(s) added successfully!";
            if ($skippedCount > 0) {
                $message .= " ({$skippedCount} skipped as already exists)";
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $addedCount,
                'skipped' => $skippedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
    
    /**
     * Force delete a price permanently (AJAX)
     */
    public function forceDelete($offerId, $id)
    {
        try {
            $offerPrice = OfferPrice::withTrashed()
                ->where('offer_id', $offerId)
                ->where('id', $id)
                ->firstOrFail();
            
            $offerPrice->forceDelete();
            
            return response()->json([
                'success' => true,
                'message' => 'Price permanently deleted!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}

