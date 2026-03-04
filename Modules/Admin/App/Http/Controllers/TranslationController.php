<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'from' => 'nullable|string|max:5',
            'to' => 'nullable|string|max:5',
        ]);

        try {
            $tr = new GoogleTranslate(
                $request->input('to', 'ar'),
                $request->input('from', 'en'),
                ['verify' => storage_path('cacert.pem')]
            );

            $translated = $tr->translate($request->input('text'));

            return response()->json(['success' => true, 'translation' => $translated]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Translation failed. Please try again.'], 500);
        }
    }
}
