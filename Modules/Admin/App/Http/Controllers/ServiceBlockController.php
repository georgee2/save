<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceBlock;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ServiceBlockController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'block_type' => 'required|in:banner,image_with_text',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
            'service_id' => 'required|exists:services,id',
        ]);

        // Validate based on block type
        if ($data['block_type'] === 'banner') {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000',
            ]);
        } elseif ($data['block_type'] === 'image_with_text') {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2000',
                'description_english' => 'required|string|max:1500',
                'description_arabic' => 'required|string|max:1500',
            ]);
        }

        // Image Upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            
            // Different sizes based on block type
            if ($data['block_type'] === 'banner') {
                $image = Image::make($imageFile)->resize(1890, 492)->encode('webp', 80);
            } else {
                $image = Image::make($imageFile)->resize(533, 593)->encode('webp', 80);
            }
            
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/blocks/' . $imageName, (string) $image);
            $data['image'] = "/uploads/blocks/{$imageName}";
        }

        ServiceBlock::create($data);

        return redirect()->route('service.show', ['id' => $request->service_id])
            ->with('success', 'Block added successfully!');
    }

    public function update(Request $request, $id)
    {
        $block = ServiceBlock::findOrFail($id);

        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'nullable|string|max:1500',
            'description_arabic' => 'nullable|string|max:1500',
            'block_type' => 'required|in:banner,image_with_text',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2000',
        ]);

        // Validate based on block type
        if ($data['block_type'] === 'image_with_text') {
            $request->validate([
                'description_english' => 'required|string|max:1500',
                'description_arabic' => 'required|string|max:1500',
            ]);
        }

        // Image Upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($block->image && Storage::disk('public')->exists($block->image)) {
                Storage::disk('public')->delete($block->image);
            }

            $imageFile = $request->file('image');
            
            // Different sizes based on block type
            if ($data['block_type'] === 'banner') {
                $image = Image::make($imageFile)->resize(1890, 492)->encode('webp', 80);
            } else {
                $image = Image::make($imageFile)->resize(533, 593)->encode('webp', 80);
            }
            
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/blocks/' . $imageName, (string) $image);
            $data['image'] = "/uploads/blocks/{$imageName}";
        }

        $block->update($data);

        return redirect()->route('service.show', ['id' => $block->service_id])
            ->with('success', 'Block updated successfully!');
    }

    public function destroy($id)
    {
        $block = ServiceBlock::findOrFail($id);
        $serviceId = $block->service_id;

        // Delete associated image
        if ($block->image && Storage::disk('public')->exists($block->image)) {
            Storage::disk('public')->delete($block->image);
        }

        $block->delete();

        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'Block deleted successfully!');
    }
}

