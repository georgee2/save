<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceValue;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ServiceValueController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1000',
            'description_arabic' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
            'icon' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000',
            'service_id' => 'required|exists:services,id',
        ]);

        // Icon Upload
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/values/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/values/icons/{$iconName}";
        }

        // Image Upload (optional)
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(400, 300)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/values/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/values/images/{$imageName}";
        }

        ServiceValue::create($data);

        return redirect()->route('service.show', ['id' => $request->service_id])
            ->with('success', 'Value added successfully!');
    }

    public function update(Request $request, $id)
    {
        $value = ServiceValue::findOrFail($id);

        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1000',
            'description_arabic' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
        ]);

        // Icon Upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($value->icon && Storage::disk('public')->exists($value->icon)) {
                Storage::disk('public')->delete($value->icon);
            }

            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/values/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/values/icons/{$iconName}";
        }

        // Image Upload (optional)
        if ($request->hasFile('image')) {
            // Delete old image
            if ($value->image && Storage::disk('public')->exists($value->image)) {
                Storage::disk('public')->delete($value->image);
            }

            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(400, 300)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/values/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/values/images/{$imageName}";
        }

        $value->update($data);

        return redirect()->route('service.show', ['id' => $value->service_id])
            ->with('success', 'Value updated successfully!');
    }

    public function destroy($id)
    {
        $value = ServiceValue::findOrFail($id);
        $serviceId = $value->service_id;

        // Delete associated files
        if ($value->icon && Storage::disk('public')->exists($value->icon)) {
            Storage::disk('public')->delete($value->icon);
        }
        if ($value->image && Storage::disk('public')->exists($value->image)) {
            Storage::disk('public')->delete($value->image);
        }

        $value->delete();

        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'Value deleted successfully!');
    }
}

