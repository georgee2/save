<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use App\Models\Project;
use App\Models\ProjectImage;

class ProjectImageController extends Controller
{
    protected $project;
    protected $projectImage;

    public function __construct(Project $project, ProjectImage $projectImage)
    {
        $this->project = $project;
        $this->projectImage = $projectImage;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param int $projectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $projectId)
    {
        $data = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Check if project exists
        $project = Project::findOrFail($projectId);

        if (count($this->projectImage->list($projectId)) == 0) {
            // First time upload - no existing images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->getClientOriginalExtension();
                    $finalimage = Image::make($image)->fit(1080, 1080)->encode('webp', 80);
                    $imageName = Str::random() . ".webp";
                    Storage::disk('public')->put('/uploads/projects/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->projectImage->NewRecord([
                        'image' => "/uploads/projects/gallery/{$imageName}",
                        'project_id' => $projectId,
                    ]);
                }
            }
        } else {
            
            $storedImages = [...$this->projectImage->getGalleryIds($projectId)];
            
            // Get preloaded images
            $preloaded = $request->preloaded ?? [];
            
            // Compare two arrays to know what has changed
            $diffArray = collect($storedImages)->diff($preloaded);
            
            // If there was difference in array then delete images not in preloaded array
            if ($diffArray->count() > 0) {
                foreach ($diffArray as $row) {
                    $rowObject = $this->projectImage->find($row);
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
                    Storage::disk('public')->put('/uploads/projects/gallery/' . $imageName, (string) $finalimage);
                    
                    $this->projectImage->NewRecord([
                        'image' => "/uploads/projects/gallery/{$imageName}",
                        'project_id' => $projectId,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Gallery Updated Successfully!');
    }

    /**
     * Get gallery images for a project (AJAX)
     * @param int $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGallery($projectId)
    {
        return response()->json($this->projectImage->list($projectId));
    }
}

