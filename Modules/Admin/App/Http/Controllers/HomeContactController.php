<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeContact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class HomeContactController extends Controller
{
    /**
     * Display and edit the home contact (single record)
     */
    public function index()
    {
        $homeContact = HomeContact::getSingle();
        
        return view('admin::homecontact.index', [
            'homeContact' => $homeContact
        ]);
    }

    /**
     * Update or create the home contact record
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:125',
            'title_arabic' => 'required|string|max:125',
            'subtitle_english' => 'nullable|string|max:50',
            'subtitle_arabic' => 'nullable|string|max:50',
            'background' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $homeContact = HomeContact::getSingle();

        // Handle Background Upload (500x500)
        if ($request->hasFile('background')) {
            // Delete old background if exists
            if ($homeContact && $homeContact->background) {
                Storage::disk('public')->delete(ltrim($homeContact->background, '/'));
            }
            
            $backgroundFile = $request->file('background');
            $image = Image::make($backgroundFile)->resize(585,629)->encode('webp', 90);
            $backgroundName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/homecontact/' . $backgroundName, (string) $image);
            $data['background'] = "/uploads/homecontact/{$backgroundName}";
        }

        HomeContact::updateOrCreateSingle($data);

        return redirect()->route('homecontact.index')->with('success', 'Home Contact updated successfully!');
    }
}

