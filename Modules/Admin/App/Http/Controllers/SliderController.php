<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * Display a listing of sliders
     */
    public function index()
    {
        $sliders = Slider::list();
        return view('admin::sliders.index', compact('sliders'));
    }
    
    /**
     * Show the form for creating a new slider
     */
    public function create()
    {
        return view('admin::sliders.create');
    }
    
    /**
     * Store a newly created slider
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_english' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }],
            'title_arabic' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }],
            'bio_english' => 'required|string|max:500',
            'bio_arabic' => 'required|string|max:500',
            'button_text_english' => ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }],
            'button_text_arabic' => ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }],
            'url_english' => 'nullable|url|max:255',
            'url_arabic' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
        
        Slider::create($data);
        
        return redirect()->route('slider.index')->with('success', 'Slider created successfully!');
    }
    
    /**
     * Show the form for editing the specified slider
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin::sliders.edit', compact('slider'));
    }
    
    /**
     * Update the specified slider
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        
        $request->validate([
            'title_english' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }],
            'title_arabic' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }],
            'bio_english' => 'required|string|max:500',
            'bio_arabic' => 'required|string|max:500',
            'button_text_english' => ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }],
            'button_text_arabic' => ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }],
            'url_english' => 'nullable|url|max:255',
            'url_arabic' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);
        
        $data = $request->except('image');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image) {
                Storage::disk('public')->delete(ltrim($slider->image, '/'));
            }
            
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }
        
        $slider->update($data);
        
        return redirect()->route('slider.index')->with('success', 'Slider updated successfully!');
    }
    
    /**
     * Soft delete the slider
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        
        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully!');
    }
    
    /**
     * Display trashed sliders
     */
    public function trashed()
    {
        $sliders = Slider::trashed();
        return view('admin::sliders.trashed', compact('sliders'));
    }
    
    /**
     * Restore trashed slider
     */
    public function restore($id)
    {
        $slider = Slider::withTrashed()->findOrFail($id);
        $slider->restore();
        
        return redirect()->route('slider.trashed')->with('success', 'Slider restored successfully!');
    }
    
    /**
     * Toggle publish status
     */
    public function toggleStatus($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->status = $slider->status == 0 ? 1 : 0;
        $slider->save();
        
        $status = $slider->status == 0 ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Slider {$status} successfully!");
    }
    
    /**
     * Update slider orders via AJAX
     */
    public function updateOrders(Request $request)
    {
        try {
            \Log::info('Update Orders Request:', [
                'all_data' => $request->all(),
                'orders_raw' => $request->input('orders')
            ]);
            
            $orders = $request->input('orders');
            
            // Check if orders is a JSON string and decode it
            if (is_string($orders)) {
                $orders = json_decode($orders, true);
                \Log::info('Decoded JSON string', ['decoded_orders' => $orders]);
            }
            
            if (!$orders || !is_array($orders)) {
                \Log::error('Invalid orders data', [
                    'orders' => $orders,
                    'type' => gettype($orders)
                ]);
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid order data - expected array, got ' . gettype($orders)
                ], 400);
            }
            
            $updated = 0;
            foreach ($orders as $order) {
                if (isset($order['id']) && isset($order['order'])) {
                    $result = Slider::where('id', $order['id'])->update(['ordering' => $order['order']]);
                    \Log::info('Updated slider', [
                        'id' => $order['id'], 
                        'new_order' => $order['order'],
                        'rows_affected' => $result
                    ]);
                    $updated++;
                }
            }
            
            \Log::info('Orders updated successfully', ['count' => $updated]);
            
            return response()->json([
                'success' => true, 
                'message' => "Order updated successfully! ({$updated} sliders updated)"
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating orders:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Handle image upload, convert to WebP and resize
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize to 1890x883
        $image = Image::make($file->getRealPath())
            ->resize(1890, 883, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 80);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/sliders/' . $filename, (string) $image);
        
        return '/uploads/sliders/' . $filename;
    }
}

