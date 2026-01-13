<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Slider;
use App\Models\Project;
use App\Models\Offer;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * Display a listing of sliders
     */
    public function index()
    {
        $sliders = Slider::with(['project', 'offer'])
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin::sliders.index', compact('sliders'));
    }
    
    /**
     * Show the form for creating a new slider
     */
    public function create()
    {
        $projects = Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $offers = Offer::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin::sliders.create', compact('projects', 'offers'));
    }
    
    /**
     * Store a newly created slider
     */
    public function store(Request $request)
    {
        $sliderType = $request->input('slider_type', 'default');
        
        // Base validation rules
        $rules = [
            'slider_type' => 'required|in:default,project,offer',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ];
        
        // Conditional validation based on slider type
        if ($sliderType === 'default') {
            $rules['title_english'] = ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }];
            $rules['title_arabic'] = ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }];
            $rules['bio_english'] = 'required|string|max:500';
            $rules['bio_arabic'] = 'required|string|max:500';
            $rules['button_text_english'] = ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }];
            $rules['button_text_arabic'] = ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }];
            $rules['url_english'] = 'nullable|url|max:255';
            $rules['url_arabic'] = 'nullable|url|max:255';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } elseif ($sliderType === 'project') {
            $rules['project_id'] = 'required|exists:projects,id';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } elseif ($sliderType === 'offer') {
            $rules['offer_id'] = 'required|exists:offers,id';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }
        
        $request->validate($rules);
        
        $data = [
            'slider_type' => $sliderType,
            'ordering' => $request->ordering,
            'status' => $request->status,
        ];
        
        // Set data based on slider type
        if ($sliderType === 'default') {
            $data['title_english'] = $request->title_english;
            $data['title_arabic'] = $request->title_arabic;
            $data['bio_english'] = $request->bio_english;
            $data['bio_arabic'] = $request->bio_arabic;
            $data['button_text_english'] = $request->button_text_english;
            $data['button_text_arabic'] = $request->button_text_arabic;
            $data['url_english'] = $request->url_english;
            $data['url_arabic'] = $request->url_arabic;
            $data['project_id'] = null;
            $data['offer_id'] = null;
        } elseif ($sliderType === 'project') {
            $data['project_id'] = $request->project_id;
            $data['offer_id'] = null;
            // Clear default fields
            $data['title_english'] = null;
            $data['title_arabic'] = null;
            $data['bio_english'] = null;
            $data['bio_arabic'] = null;
            $data['button_text_english'] = null;
            $data['button_text_arabic'] = null;
            $data['url_english'] = null;
            $data['url_arabic'] = null;
        } elseif ($sliderType === 'offer') {
            $data['offer_id'] = $request->offer_id;
            $data['project_id'] = null;
            // Clear default fields
            $data['title_english'] = null;
            $data['title_arabic'] = null;
            $data['bio_english'] = null;
            $data['bio_arabic'] = null;
            $data['button_text_english'] = null;
            $data['button_text_arabic'] = null;
            $data['url_english'] = null;
            $data['url_arabic'] = null;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        } else {
            // Use project/offer cover image if no custom image uploaded
            if ($sliderType === 'project' && $request->project_id) {
                $project = Project::find($request->project_id);
                if ($project && $project->cover_image) {
                    $data['image'] = $project->cover_image;
                } elseif ($project && $project->main_image) {
                    $data['image'] = $project->main_image;
                }
            } elseif ($sliderType === 'offer' && $request->offer_id) {
                $offer = Offer::find($request->offer_id);
                if ($offer && $offer->cover_image) {
                    $data['image'] = $offer->cover_image;
                } elseif ($offer && $offer->main_image) {
                    $data['image'] = $offer->main_image;
                }
            }
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
        
        $projects = Project::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $offers = Offer::where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin::sliders.edit', compact('slider', 'projects', 'offers'));
    }
    
    /**
     * Update the specified slider
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $sliderType = $request->input('slider_type', 'default');
        
        // Base validation rules
        $rules = [
            'slider_type' => 'required|in:default,project,offer',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ];
        
        // Conditional validation based on slider type
        if ($sliderType === 'default') {
            $rules['title_english'] = ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }];
            $rules['title_arabic'] = ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 4) {
                    $fail('The ' . $attribute . ' must not exceed 4 words.');
                }
            }];
            $rules['bio_english'] = 'required|string|max:500';
            $rules['bio_arabic'] = 'required|string|max:500';
            $rules['button_text_english'] = ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }];
            $rules['button_text_arabic'] = ['nullable', 'string', 'max:50', function ($attribute, $value, $fail) {
                if ($value) {
                    $wordCount = str_word_count($value);
                    if ($wordCount > 2) {
                        $fail('The ' . $attribute . ' must not exceed 2 words.');
                    }
                }
            }];
            $rules['url_english'] = 'nullable|url|max:255';
            $rules['url_arabic'] = 'nullable|url|max:255';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } elseif ($sliderType === 'project') {
            $rules['project_id'] = 'required|exists:projects,id';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } elseif ($sliderType === 'offer') {
            $rules['offer_id'] = 'required|exists:offers,id';
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }
        
        $request->validate($rules);
        
        $data = [
            'slider_type' => $sliderType,
            'ordering' => $request->ordering,
            'status' => $request->status,
        ];
        
        // Set data based on slider type
        if ($sliderType === 'default') {
            $data['title_english'] = $request->title_english;
            $data['title_arabic'] = $request->title_arabic;
            $data['bio_english'] = $request->bio_english;
            $data['bio_arabic'] = $request->bio_arabic;
            $data['button_text_english'] = $request->button_text_english;
            $data['button_text_arabic'] = $request->button_text_arabic;
            $data['url_english'] = $request->url_english;
            $data['url_arabic'] = $request->url_arabic;
            $data['project_id'] = null;
            $data['offer_id'] = null;
        } elseif ($sliderType === 'project') {
            $data['project_id'] = $request->project_id;
            $data['offer_id'] = null;
            // Clear default fields
            $data['title_english'] = null;
            $data['title_arabic'] = null;
            $data['bio_english'] = null;
            $data['bio_arabic'] = null;
            $data['button_text_english'] = null;
            $data['button_text_arabic'] = null;
            $data['url_english'] = null;
            $data['url_arabic'] = null;
        } elseif ($sliderType === 'offer') {
            $data['offer_id'] = $request->offer_id;
            $data['project_id'] = null;
            // Clear default fields
            $data['title_english'] = null;
            $data['title_arabic'] = null;
            $data['bio_english'] = null;
            $data['bio_arabic'] = null;
            $data['button_text_english'] = null;
            $data['button_text_arabic'] = null;
            $data['url_english'] = null;
            $data['url_arabic'] = null;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it's a custom uploaded one (not from project/offer)
            if ($slider->image && strpos($slider->image, '/uploads/sliders/') !== false) {
                Storage::disk('public')->delete(ltrim($slider->image, '/'));
            }
            
            $data['image'] = $this->handleImageUpload($request->file('image'));
        } else {
            // If changing type and no new image, use project/offer cover image
            if ($sliderType === 'project' && $request->project_id && $request->project_id != $slider->project_id) {
                $project = Project::find($request->project_id);
                if ($project && $project->cover_image) {
                    $data['image'] = $project->cover_image;
                } elseif ($project && $project->main_image) {
                    $data['image'] = $project->main_image;
                }
            } elseif ($sliderType === 'offer' && $request->offer_id && $request->offer_id != $slider->offer_id) {
                $offer = Offer::find($request->offer_id);
                if ($offer && $offer->cover_image) {
                    $data['image'] = $offer->cover_image;
                } elseif ($offer && $offer->main_image) {
                    $data['image'] = $offer->main_image;
                }
            }
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
     * Dimensions: 1890x883 (aspect ratio ~2.14:1)
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and fit to exact 1890x883 dimensions
        // fit() will crop and resize to fill the exact dimensions
        $image = Image::make($file->getRealPath())
            ->fit(1890, 883, function ($constraint) {
                $constraint->upsize(); // Prevent upsizing small images
            })
            ->encode('webp', 85);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/sliders/' . $filename, (string) $image);
        
        return '/uploads/sliders/' . $filename;
    }
}
