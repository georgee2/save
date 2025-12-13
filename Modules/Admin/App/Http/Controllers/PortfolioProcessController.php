<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PortfolioProcess;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PortfolioProcessController extends Controller
{
    /**
     * Store a newly created portfolio process
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1500',
            'description_arabic' => 'required|string|max:1500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5000',
            'icon' => 'required|image|mimes:jpeg,png,jpg,webp|max:2000',
        ]);

        // Get the next order number
        $maxOrder = PortfolioProcess::where('portfolio_id', $request->portfolio_id)->max('order');
        $data['order'] = $maxOrder ? $maxOrder + 1 : 1;

        // Image Upload (600x600)
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(600, 600)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolio-processes/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/portfolio-processes/images/{$imageName}";
        }

        // Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $icon = Image::make($iconFile)->resize(100, 100)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolio-processes/icons/' . $iconName, (string) $icon);
            $data['icon'] = "/uploads/portfolio-processes/icons/{$iconName}";
        }

        PortfolioProcess::create($data);

        return redirect()->route('portfolio.show', ['id' => $request->portfolio_id])
            ->with('success', 'Portfolio Process added successfully!');
    }

    /**
     * Update the specified portfolio process
     */
    public function update(Request $request, $id)
    {
        $process = PortfolioProcess::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_arabic' => 'required|string|max:255',
            'description_english' => 'required|string|max:1500',
            'description_arabic' => 'required|string|max:1500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2000',
        ]);

        // Image Upload (600x600)
        if ($request->hasFile('image')) {
            // Delete old image
            if ($process->image && Storage::disk('public')->exists(ltrim($process->image, '/'))) {
                Storage::disk('public')->delete(ltrim($process->image, '/'));
            }
            
            $imageFile = $request->file('image');
            $image = Image::make($imageFile)->resize(600, 600)->encode('webp', 80);
            $imageName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolio-processes/images/' . $imageName, (string) $image);
            $data['image'] = "/uploads/portfolio-processes/images/{$imageName}";
        }

        // Icon Upload (100x100)
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($process->icon && Storage::disk('public')->exists(ltrim($process->icon, '/'))) {
                Storage::disk('public')->delete(ltrim($process->icon, '/'));
            }
            
            $iconFile = $request->file('icon');
            $icon = Image::make($iconFile)->resize(100, 100)->encode('webp', 100);
            $iconName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/portfolio-processes/icons/' . $iconName, (string) $icon);
            $data['icon'] = "/uploads/portfolio-processes/icons/{$iconName}";
        }

        $process->update($data);

        return redirect()->route('portfolio.show', ['id' => $process->portfolio_id])
            ->with('success', 'Portfolio Process updated successfully!');
    }

    /**
     * Remove the specified portfolio process
     */
    public function destroy($id)
    {
        $process = PortfolioProcess::findOrFail($id);
        $portfolioId = $process->portfolio_id;
        
        // Delete images
        if ($process->image && Storage::disk('public')->exists(ltrim($process->image, '/'))) {
            Storage::disk('public')->delete(ltrim($process->image, '/'));
        }
        if ($process->icon && Storage::disk('public')->exists(ltrim($process->icon, '/'))) {
            Storage::disk('public')->delete(ltrim($process->icon, '/'));
        }
        
        $process->delete();

        return redirect()->route('portfolio.show', ['id' => $portfolioId])
            ->with('success', 'Portfolio Process deleted successfully!');
    }

    /**
     * Update the order of portfolio processes
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            PortfolioProcess::where('id', $order)->update(['order' => array_search($order, $orders) + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Process order updated successfully!']);
    }
}


