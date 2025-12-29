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
    
    // Gallery image dimensions (903x1146 portrait aspect ratio)
    const GALLERY_WIDTH = 903;
    const GALLERY_HEIGHT = 1146;

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
                    $imageName = $this->processAndSaveImage($image);
                    
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
                    $imageName = $this->processAndSaveImage($image);
                    
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
     * Process and save image with 903x1146 dimensions and WebP format
     * 
     * @param \Illuminate\Http\UploadedFile $image
     * @return string The saved image filename
     */
    private function processAndSaveImage($image)
    {
        // Resize to 903x1146 (portrait) and convert to WebP
        $finalImage = Image::make($image)
            ->resize(self::GALLERY_WIDTH, self::GALLERY_HEIGHT, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->resizeCanvas(self::GALLERY_WIDTH, self::GALLERY_HEIGHT, 'center', false, '#ffffff')
            ->encode('webp', 80);
        
        $imageName = Str::random() . ".webp";
        Storage::disk('public')->put('/uploads/offers/gallery/' . $imageName, (string) $finalImage);
        
        return $imageName;
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

