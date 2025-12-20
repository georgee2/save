<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use App\Models\Offer;
use App\Models\OfferImage;

class OfferImageController extends Controller
{
    protected $offer;
    protected $offerImage;

    public function __construct(Offer $offer, OfferImage $offerImage)
    {
        $this->offer = $offer;
        $this->offerImage = $offerImage;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param int $offerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $offerId)
    {
        $data = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Check if offer exists
        $offer = Offer::findOrFail($offerId);

        if (count($this->offerImage->list($offerId)) == 0) {
            // First time upload - no existing images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->getClientOriginalExtension();
                    $finalimage = Image::make($image)->fit(1080, 1080)->encode('webp', 80);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put('/uploads/offers/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->offerImage->NewRecord([
                        'image' => "/uploads/offers/gallery/{$imageName}",
                        'offer_id' => $offerId,
                    ]);
                }
            }
        } else {
            
            $storedImages = [...$this->offerImage->getGalleryIds($offerId)];
            
            // Get preloaded images
            $preloaded = $request->preloaded ?? [];
            
            // Compare two arrays to know what has changed
            $diffArray = collect($storedImages)->diff($preloaded);
            
            // If there was difference in array then delete images not in preloaded array
            if ($diffArray->count() > 0) {
                foreach ($diffArray as $row) {
                    $rowObject = $this->offerImage->find($row);
                    // Delete this row
                    if ($rowObject->image && Storage::exists('public' . $rowObject->image)) {
                        Storage::delete('public' . $rowObject->image);
                    }
                    $rowObject->delete();
                }
            }
            
            // Upload new images if exists
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->getClientOriginalExtension();
                    $finalimage = Image::make($image)->fit(1080, 1080)->encode('webp', 80);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put('/uploads/offers/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->offerImage->NewRecord([
                        'image' => "/uploads/offers/gallery/{$imageName}",
                        'offer_id' => $offerId,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Gallery Updated Successfully!');
    }

    /**
     * Get gallery images for an offer (AJAX)
     * @param int $offerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGallery($offerId)
    {
        return response()->json($this->offerImage->list($offerId));
    }
}

