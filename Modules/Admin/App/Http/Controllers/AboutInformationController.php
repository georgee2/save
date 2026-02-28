<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AboutInformation;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AboutInformationController extends Controller
{
    /**
     * Display and edit about information (single view)
     */
    public function index()
    {
        $aboutInfo = AboutInformation::getAboutInfo();
        return view('admin::about-information.index', compact('aboutInfo'));
    }
    
    /**
     * Update about information
     */
    public function update(Request $request)
    {
        // Word count validation helper
        $wordCountRule = function ($attribute, $value, $fail, $maxWords) {
            if ($value) {
                $wordCount = str_word_count($value);
                if ($wordCount > $maxWords) {
                    $fail("The {$attribute} must not exceed {$maxWords} words.");
                }
            }
        };
        
        $request->validate([
            'title_english' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) use ($wordCountRule) {
                $wordCountRule($attribute, $value, $fail, 4);
            }],
            'title_arabic' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) use ($wordCountRule) {
                $wordCountRule($attribute, $value, $fail, 4);
            }],
            'subtitle_english' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) use ($wordCountRule) {
                $wordCountRule($attribute, $value, $fail, 8);
            }],
            'subtitle_arabic' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) use ($wordCountRule) {
                $wordCountRule($attribute, $value, $fail, 8);
            }],
            'about_english' => 'nullable|string|max:2500',
            'about_arabic' => 'nullable|string|max:2500',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'mission_english' => 'nullable|string|max:2000',
            'mission_arabic' => 'nullable|string|max:2000',
            'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'vision_english' => 'nullable|string|max:2000',
            'vision_arabic' => 'nullable|string|max:2000',
            'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'values_english' => 'nullable|string|max:2000',
            'values_arabic' => 'nullable|string|max:2000',
            'values_points_english' => 'nullable|string',
            'values_points_arabic' => 'nullable|string',
            'values_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'page_cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'company_profile' => 'nullable|file|mimes:pdf|max:15360',
        ]);
        
        $aboutInfo = AboutInformation::getAboutInfo();
        $data = $request->except(['about_image', 'mission_image', 'vision_image', 'values_image', 'page_cover_image', 'company_profile', 'values_points_english', 'values_points_arabic']);
        
        $data['values_points_english'] = $request->values_points_english ? tags($request->values_points_english) : null;
        $data['values_points_arabic'] = $request->values_points_arabic ? tags($request->values_points_arabic) : null;
        
        // Handle About Image (850x795)
        if ($request->hasFile('about_image')) {
            // Delete old image
            if ($aboutInfo->about_image && Storage::exists('public' . $aboutInfo->about_image)) {
                Storage::delete('public' . $aboutInfo->about_image);
            }
            $data['about_image'] = $this->handleImageUpload($request->file('about_image'), 850, 795, 'about');
        }
        
        // Handle Mission Image (880x900)
        if ($request->hasFile('mission_image')) {
            if ($aboutInfo->mission_image && Storage::exists('public' . $aboutInfo->mission_image)) {
                Storage::delete('public' . $aboutInfo->mission_image);
            }
            $data['mission_image'] = $this->handleImageUpload($request->file('mission_image'), 880, 900, 'mission');
        }
        
        // Handle Vision Image (880x900)
        if ($request->hasFile('vision_image')) {
            if ($aboutInfo->vision_image && Storage::exists('public' . $aboutInfo->vision_image)) {
                Storage::delete('public' . $aboutInfo->vision_image);
            }
            $data['vision_image'] = $this->handleImageUpload($request->file('vision_image'), 880, 900, 'vision');
        }
        
        // Handle Values Image (880x900)
        if ($request->hasFile('values_image')) {
            if ($aboutInfo->values_image && Storage::exists('public' . $aboutInfo->values_image)) {
                Storage::delete('public' . $aboutInfo->values_image);
            }
            $data['values_image'] = $this->handleImageUpload($request->file('values_image'), 880, 900, 'values');
        }
        
        // Handle Page Cover Image (1920x450)
        if ($request->hasFile('page_cover_image')) {
            if ($aboutInfo->page_cover_image && Storage::exists('public' . $aboutInfo->page_cover_image)) {
                Storage::delete('public' . $aboutInfo->page_cover_image);
            }
            $data['page_cover_image'] = $this->handleImageUpload($request->file('page_cover_image'), 1920, 450, 'cover');
        }
        
        // Handle Company Profile PDF (Max 15MB)
        if ($request->hasFile('company_profile')) {
            // Delete old file
            if ($aboutInfo->company_profile && Storage::exists('public' . $aboutInfo->company_profile)) {
                Storage::delete('public' . $aboutInfo->company_profile);
            }
            $data['company_profile'] = $this->handlePdfUpload($request->file('company_profile'), 'company-profile');
        }
        
        AboutInformation::updateAboutInfo($data);
        
        return redirect()->route('about-information.index')->with('success', 'About Information updated successfully!');
    }
    
    /**
     * Handle image upload, convert to WebP and resize
     */
    private function handleImageUpload($file, $width, $height, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        
        // Create image instance and resize
        $image = Image::make($file->getRealPath())
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 90);
        
        // Save image using Storage::disk('public')
        Storage::disk('public')->put('/uploads/about/' . $folder . '/' . $filename, (string) $image);
        
        return '/uploads/about/' . $folder . '/' . $filename;
    }
    
    /**
     * Handle PDF file upload
     */
    private function handlePdfUpload($file, $folder)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.pdf';
        
        // Store the PDF file using Storage::disk('public')
        Storage::disk('public')->put('/uploads/about/' . $folder . '/' . $filename, file_get_contents($file->getRealPath()));
        
        return '/uploads/about/' . $folder . '/' . $filename;
    }
    
    /**
     * Remove a specific image field
     */
    public function removeImage(Request $request)
    {
        $field = $request->input('field');
        
        // Allowed fields that can be removed
        $allowedFields = [
            'about_image',
            'mission_image',
            'vision_image',
            'values_image',
            'page_cover_image',
            'company_profile',
        ];
        
        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field specified.',
            ], 400);
        }
        
        $aboutInfo = AboutInformation::getAboutInfo();
        
        // Check if the field has a value
        if (empty($aboutInfo->$field)) {
            return response()->json([
                'success' => false,
                'message' => 'No file to remove.',
            ], 400);
        }
        
        // Delete the file from storage
        if (Storage::exists('public' . $aboutInfo->$field)) {
            Storage::delete('public' . $aboutInfo->$field);
        }
        
        // Update the database to set the field to null
        AboutInformation::updateAboutInfo([$field => null]);
        
        return response()->json([
            'success' => true,
            'message' => 'File removed successfully!',
        ]);
    }
}

