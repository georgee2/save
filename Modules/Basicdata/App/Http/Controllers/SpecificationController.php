<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Specification;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SpecificationController extends Controller
{
    protected $specification;

    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Display a listing of specifications
     */
    public function index()
    {
        $specifications = $this->specification->list();
        
        return view('basicdata::specifications.index', [
            'specifications' => $specifications
        ]);
    }

    /**
     * Show the form for creating a new specification
     */
    public function create()
    {
        $projectTypes = ProjectType::whereNull('deleted_at')->get();
        
        return view('basicdata::specifications.create', [
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Store a newly created specification
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'type_id' => 'required|exists:project_types,id',
            'status' => 'required|in:0,1',
        ]);

        // Handle icon upload - resize to 100x100 and convert to WebP
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_' . uniqid() . '.webp';
            
            // Create directory if it doesn't exist
            $directory = storage_path('app/public/specifications/icons');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Resize to 100x100 and convert to WebP
            $image = Image::make($icon->getRealPath());
            $image->fit(100, 100);
            $image->encode('webp', 90);
            
            // Save the image
            $iconPath = 'specifications/icons/' . $iconName;
            Storage::disk('public')->put($iconPath, (string) $image);
            
            $data['icon'] = '/' . $iconPath;
        }

        Specification::create($data);

        return redirect()->route('specification.index')->with('success', 'Specification created successfully!');
    }

    /**
     * Show the form for editing specification
     */
    public function edit($id)
    {
        $specification = Specification::findOrFail($id);
        $projectTypes = ProjectType::whereNull('deleted_at')->get();
        
        return view('basicdata::specifications.edit', [
            'specification' => $specification,
            'projectTypes' => $projectTypes
        ]);
    }

    /**
     * Update the specified specification
     */
    public function update(Request $request, $id)
    {
        $specification = Specification::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
            'type_id' => 'required|exists:project_types,id',
            'status' => 'required|in:0,1',
        ]);

        // Handle icon upload - resize to 100x100 and convert to WebP
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($specification->icon) {
                Storage::disk('public')->delete(ltrim($specification->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_' . uniqid() . '.webp';
            
            // Create directory if it doesn't exist
            $directory = storage_path('app/public/specifications/icons');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Resize to 100x100 and convert to WebP
            $image = Image::make($icon->getRealPath());
            $image->fit(100, 100);
            $image->encode('webp', 90);
            
            // Save the image
            $iconPath = 'specifications/icons/' . $iconName;
            Storage::disk('public')->put($iconPath, (string) $image);
            
            $data['icon'] = '/' . $iconPath;
        }

        $specification->update($data);

        return redirect()->route('specification.index')->with('success', 'Specification updated successfully!');
    }

    /**
     * Soft delete the specification
     */
    public function destroy($id)
    {
        $specification = Specification::findOrFail($id);
        $specification->delete();

        return redirect()->route('specification.index')->with('success', 'Specification deleted successfully!');
    }

    /**
     * Display trashed specifications
     */
    public function trashed()
    {
        $specifications = $this->specification->trashed();
        
        return view('basicdata::specifications.trashed', [
            'specifications' => $specifications
        ]);
    }

    /**
     * Restore trashed specification
     */
    public function restore($id)
    {
        $specification = Specification::withTrashed()->findOrFail($id);
        $specification->restore();

        return redirect()->route('specification.trashed')->with('success', 'Specification restored successfully!');
    }
}

