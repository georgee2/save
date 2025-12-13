<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Amenity;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    protected $amenity;

    public function __construct(Amenity $amenity)
    {
        $this->amenity = $amenity;
    }

    /**
     * Display a listing of amenities
     */
    public function index()
    {
        $amenities = $this->amenity->list();
        
        return view('basicdata::amenities.index', [
            'amenities' => $amenities
        ]);
    }

    /**
     * Show the form for creating a new amenity
     */
    public function create()
    {
        return view('basicdata::amenities.create');
    }

    /**
     * Store a newly created amenity
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload (required)
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('amenities/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        Amenity::create($data);

        return redirect()->route('amenity.index')->with('success', 'Amenity created successfully!');
    }

    /**
     * Show the form for editing amenity
     */
    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        
        return view('basicdata::amenities.edit', [
            'amenity' => $amenity
        ]);
    }

    /**
     * Update the specified amenity
     */
    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);
        
        $data = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($amenity->icon) {
                Storage::disk('public')->delete(ltrim($amenity->icon, '/'));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('amenities/icons', $iconName, 'public');
            $data['icon'] = '/' . $iconPath;
        }

        $amenity->update($data);

        return redirect()->route('amenity.index')->with('success', 'Amenity updated successfully!');
    }

    /**
     * Soft delete the amenity
     */
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return redirect()->route('amenity.index')->with('success', 'Amenity deleted successfully!');
    }

    /**
     * Display trashed amenities
     */
    public function trashed()
    {
        $amenities = $this->amenity->trashed();
        
        return view('basicdata::amenities.trashed', [
            'amenities' => $amenities
        ]);
    }

    /**
     * Restore trashed amenity
     */
    public function restore($id)
    {
        $amenity = Amenity::withTrashed()->findOrFail($id);
        $amenity->restore();

        return redirect()->route('amenity.trashed')->with('success', 'Amenity restored successfully!');
    }
}

