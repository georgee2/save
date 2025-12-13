<?php

namespace Modules\Basicdata\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Display a listing of language keys
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        // Read English language file
        $enPath = resource_path('lang/en/lang.php');
        $arPath = resource_path('lang/ar/lang.php');
        
        if (!File::exists($enPath) || !File::exists($arPath)) {
            return redirect()->back()->with('error', 'Language files not found!');
        }
        
        $enLang = include $enPath;
        $arLang = include $arPath;
        
        // Combine keys
        $languages = [];
        foreach ($enLang as $key => $value) {
            $languages[] = [
                'key' => $key,
                'english' => $value,
                'arabic' => $arLang[$key] ?? '',
            ];
        }
        
        // Search filter
        if ($search) {
            $languages = array_filter($languages, function($item) use ($search) {
                return stripos($item['key'], $search) !== false ||
                       stripos($item['english'], $search) !== false ||
                       stripos($item['arabic'], $search) !== false;
            });
        }
        
        // Paginate manually
        $perPage = 50;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $total = count($languages);
        $languages = array_slice($languages, $offset, $perPage);
        
        return view('basicdata::languages.index', [
            'languages' => $languages,
            'search' => $search,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage,
        ]);
    }
    
    /**
     * Show the form for editing a language key
     */
    public function edit($key)
    {
        $enPath = resource_path('lang/en/lang.php');
        $arPath = resource_path('lang/ar/lang.php');
        
        $enLang = include $enPath;
        $arLang = include $arPath;
        
        if (!isset($enLang[$key])) {
            return redirect()->route('language.index')->with('error', 'Language key not found!');
        }
        
        $language = [
            'key' => $key,
            'english' => $enLang[$key],
            'arabic' => $arLang[$key] ?? '',
        ];
        
        return view('basicdata::languages.edit', ['language' => $language]);
    }
    
    /**
     * Update the specified language key
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'english' => 'required|string',
            'arabic' => 'required|string',
        ]);
        
        $enPath = resource_path('lang/en/lang.php');
        $arPath = resource_path('lang/ar/lang.php');
        
        // Read current language files
        $enLang = include $enPath;
        $arLang = include $arPath;
        
        // Update values
        $enLang[$key] = $request->english;
        $arLang[$key] = $request->arabic;
        
        // Write back to files
        $this->writeLanguageFile($enPath, $enLang);
        $this->writeLanguageFile($arPath, $arLang);
        
        return redirect()->route('language.index')->with('success', 'Language key updated successfully!');
    }
    
    /**
     * Write language array to file
     */
    private function writeLanguageFile($path, $data)
    {
        $content = "<?php\n\nreturn [\n";
        
        foreach ($data as $key => $value) {
            // Escape single quotes in the value
            $escapedValue = str_replace("'", "\\'", $value);
            $content .= "    '{$key}' => '{$escapedValue}',\n";
        }
        
        $content .= "];\n";
        
        File::put($path, $content);
    }
}

