<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceProcess;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ServiceProcessController extends Controller
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

        // Get the maximum order value and add 1
        $maxOrder = ServiceProcess::where('service_id', $request->service_id)->max('order');
        $data['order'] = $maxOrder !== null ? $maxOrder + 1 : 0;

        // Icon Upload
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/processes/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/processes/icons/{$iconName}";
        }

        // Image Upload (optional)
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(400, 300)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/processes/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/processes/images/{$imageName}";
        }

        ServiceProcess::create($data);

        return redirect()->route('service.show', ['id' => $request->service_id])
            ->with('success', 'Process added successfully!');
    }

    public function update(Request $request, $id)
    {
        $process = ServiceProcess::findOrFail($id);

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
            if ($process->icon && Storage::disk('public')->exists($process->icon)) {
                Storage::disk('public')->delete($process->icon);
            }

            $iconFile = $request->file('icon');
            $image = Image::make($iconFile)->resize(64, 64)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/processes/icons/' . $iconName, (string) $image);
            $data['icon'] = "/uploads/processes/icons/{$iconName}";
        }

        // Image Upload (optional)
        if ($request->hasFile('image')) {
            // Delete old image
            if ($process->image && Storage::disk('public')->exists($process->image)) {
                Storage::disk('public')->delete($process->image);
            }

            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(400, 300)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/processes/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/processes/images/{$imageName}";
        }

        $process->update($data);

        return redirect()->route('service.show', ['id' => $process->service_id])
            ->with('success', 'Process updated successfully!');
    }

    public function destroy($id)
    {
        $process = ServiceProcess::findOrFail($id);
        $serviceId = $process->service_id;

        // Delete associated files
        if ($process->icon && Storage::disk('public')->exists($process->icon)) {
            Storage::disk('public')->delete($process->icon);
        }
        if ($process->image && Storage::disk('public')->exists($process->image)) {
            Storage::disk('public')->delete($process->image);
        }

        $process->delete();

        // Reorder remaining processes
        $this->reorderProcesses($serviceId);

        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'Process deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        $data = $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:service_processes,id',
        ]);

        foreach ($data['orders'] as $index => $processId) {
            ServiceProcess::where('id', $processId)->update(['order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }

    private function reorderProcesses($serviceId)
    {
        $processes = ServiceProcess::where('service_id', $serviceId)
            ->orderBy('order')
            ->get();

        foreach ($processes as $index => $process) {
            $process->update(['order' => $index]);
        }
    }
}

