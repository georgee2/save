<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use App\Models\Portfolio;
use App\Models\PortfolioImage;

class PortfolioImageController extends Controller
{
    protected $portfolio;
    protected $portfolioImage;

    public function __construct(Portfolio $portfolio, PortfolioImage $portfolioImage)
    {
        $this->portfolio = $portfolio;
        $this->portfolioImage = $portfolioImage;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param int $portfolioId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $portfolioId)
    {
        $data = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2000',
        ]);

        // Check if portfolio exists
        $portfolio = Portfolio::findOrFail($portfolioId);

        if (count($this->portfolioImage->list($portfolioId)) == 0) {
            // First time upload - no existing images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->getClientOriginalExtension();
                    $finalimage = Image::make($image)->resize(1200, 800)->encode('webp', 70);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put('/uploads/portfolio/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->portfolioImage->NewRecord([
                        'image' => "/uploads/portfolio/gallery/{$imageName}",
                        'portfolio_id' => $portfolioId,
                    ]);
                }
            }
        } else {
            // Get stored images id
            $storedImages = [...$this->portfolioImage->getGalleryIds($portfolioId)];
            
            // Get preloaded images
            $preloaded = $request->preloaded ?? [];
            
            // Compare two arrays to know what has changed
            $diffArray = collect($storedImages)->diff($preloaded);
            
            // If there was difference in array then delete images not in preloaded array
            if ($diffArray->count() > 0) {
                foreach ($diffArray as $row) {
                    $rowObject = $this->portfolioImage->find($row);
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
                    $finalimage = Image::make($image)->resize(1200, 800)->encode('webp', 70);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put('/uploads/portfolio/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->portfolioImage->NewRecord([
                        'image' => "/uploads/portfolio/gallery/{$imageName}",
                        'portfolio_id' => $portfolioId,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Gallery Updated Successfully!');
    }

    /**
     * Get gallery images for a portfolio (AJAX)
     * @param int $portfolioId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGallery($portfolioId)
    {
        return response()->json($this->portfolioImage->list($portfolioId));
    }
}

