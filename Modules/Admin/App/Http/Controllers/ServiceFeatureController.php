<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceFeature;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ServiceFeatureController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:500',
            'description_arabic' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
            'icon' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000',
            'service_id' => 'required|exists:services,id',
        ]);

        // Icon Upload
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/features/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/features/icons/{$iconName}";
        }

        // Image Upload (optional) - Fit to card dimensions (600x220 for slider cards)
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            // Use fit() to crop and resize to exact dimensions for consistent card display
            $image = Image::make($imageFile)->fit(600, 220, function ($constraint) {
                $constraint->upsize(); // Prevent upsizing small images
            })->encode('webp', 85);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/features/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/features/images/{$imageName}";
        }

        ServiceFeature::create($data);

        return redirect()->route('service.show', ['id' => $request->service_id])
            ->with('success', 'Feature added successfully!');
    }

    public function update(Request $request, $id)
    {
        $feature = ServiceFeature::findOrFail($id);

        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:500',
            'description_arabic' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
        ]);

        // Icon Upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($feature->icon && Storage::disk('public')->exists($feature->icon)) {
                Storage::disk('public')->delete($feature->icon);
            }

            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/features/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/features/icons/{$iconName}";
        }

        // Image Upload (optional) - Fit to card dimensions (600x220 for slider cards)
        if ($request->hasFile('image')) {
            // Delete old image
            if ($feature->image && Storage::disk('public')->exists($feature->image)) {
                Storage::disk('public')->delete($feature->image);
            }

            $imageFile = $request->file('image');
            // Use fit() to crop and resize to exact dimensions for consistent card display
            $image = Image::make($imageFile)->fit(600, 220, function ($constraint) {
                $constraint->upsize(); // Prevent upsizing small images
            })->encode('webp', 85);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/features/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/features/images/{$imageName}";
        }

        $feature->update($data);

        return redirect()->route('service.show', ['id' => $feature->service_id])
            ->with('success', 'Feature updated successfully!');
    }

    public function destroy($id)
    {
        $feature = ServiceFeature::findOrFail($id);
        $serviceId = $feature->service_id;

        // Delete associated files
        if ($feature->icon && Storage::disk('public')->exists($feature->icon)) {
            Storage::disk('public')->delete($feature->icon);
        }
        if ($feature->image && Storage::disk('public')->exists($feature->image)) {
            Storage::disk('public')->delete($feature->image);
        }

        $feature->delete();

        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'Feature deleted successfully!');
    }
}

