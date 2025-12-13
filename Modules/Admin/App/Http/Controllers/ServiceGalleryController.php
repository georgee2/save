<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

use App\Models\Service;
use App\Models\ServiceGallery;

class ServiceGalleryController extends Controller
{
    protected $Service;
    protected $ServiceGallery;

    public function __construct(Service $Service,ServiceGallery $ServiceGallery)
    {
        $this->Service = $Service;
        $this->ServiceGallery = $ServiceGallery;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$service_code)
    {
        $data = $request->validate([
            'images.*' => 'required|image|max:2000',
        ]);

        $division = ServiceGallery::where('id',$service_code)->value('service_code');

        if (count($this->ServiceGallery->list($service_code)) == 0) {

            foreach ($request->file('images') as $image) {


                $filename = $image->getClientOriginalExtension();
                $finalimage = Image::make($image)->resize(425,450)->encode('webp', 50);
                $imageName = Str::random() . ".webp";
                Storage::disk('public')->put( '/uploads/galleryservice/' . $imageName ,(string) $finalimage);

                $this->ServiceGallery->NewRecord([
                    'image' => "/uploads/galleryservice/{$imageName}",
                    'service_code' => $service_code,
                ]);

            }

        } else {

            // get stored images id

            $storedImages = [...$this->ServiceGallery->getGalleryIds()];

            // get preloaded images

            $preloaded = $request->preloaded;

            // compare two arrays to know what has changed

            $diffArray = collect($storedImages)->diff($preloaded);

            // if there was differnece in array then delete images in preloaded array

            if ($diffArray->count() > 0) {

                foreach ($diffArray as $row) {
                    $rowObject = $this->ServiceGallery->find($row);
                    // delete this row
                    Storage::delete('/public' . $rowObject->image);
                    $rowObject->delete();
                }
            }

            // upload new images if exists
            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {

                    
                    $filename = $image->getClientOriginalExtension();
                    $finalimage = Image::make($image)->resize(425,450)->encode('webp', 50);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put( '/uploads/galleryservice/' . $imageName ,(string) $finalimage);

                    $this->ServiceGallery->NewRecord([
                        'image' => "/uploads/galleryservice/{$imageName}",
                        'service_code' => $service_code,
                    ]);
                }
            }

        }

        return redirect()->back()->with('success', 'Gallery Updated');

    }

    public function getGallery($service_code)
    {

        return response()->json($this->ServiceGallery->list($service_code));

    }
}
