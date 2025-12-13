<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\DefaultProcess;
use App\Models\DefaultProcessCard;

class DefaultProcessController extends Controller
{
    protected $defaultProcess;

    public function __construct(DefaultProcess $defaultProcess)
    {
        $this->defaultProcess = $defaultProcess;
    }

    /**
     * Display a listing of default processes
     */
    public function index()
    {
        $processes = $this->defaultProcess->list();
        
        return view('admin::default-processes.index', [
            'processes' => $processes
        ]);
    }

    /**
     * Show the form for creating a new default process
     */
    public function create()
    {
        return view('admin::default-processes.create');
    }

    /**
     * Store a newly created default process
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'sub_title_english' => 'required|string|max:100',
            'sub_title_arabic' => 'required|string|max:100',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'button_text_english' => 'nullable|string|max:50',
            'button_text_arabic' => 'nullable|string|max:50',
            'url_english' => 'nullable|url|max:255',
            'url_arabic' => 'nullable|url|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        $subTitleEnglishWords = str_word_count($data['sub_title_english']);
        $subTitleArabicWords = str_word_count($data['sub_title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }
        if ($subTitleEnglishWords > 3) {
            return back()->withErrors(['sub_title_english' => 'English subtitle must not exceed 3 words'])->withInput();
        }
        if ($subTitleArabicWords > 3) {
            return back()->withErrors(['sub_title_arabic' => 'Arabic subtitle must not exceed 3 words'])->withInput();
        }
        
        // Validate button text word count if provided
        if (!empty($data['button_text_english'])) {
            $buttonEnglishWords = str_word_count($data['button_text_english']);
            if ($buttonEnglishWords > 2) {
                return back()->withErrors(['button_text_english' => 'English button text must not exceed 2 words'])->withInput();
            }
        }
        if (!empty($data['button_text_arabic'])) {
            $buttonArabicWords = str_word_count($data['button_text_arabic'], 0, 'أ-ي');
            if ($buttonArabicWords > 2) {
                return back()->withErrors(['button_text_arabic' => 'Arabic button text must not exceed 2 words'])->withInput();
            }
        }

        DefaultProcess::create($data);

        return redirect()->route('admin.default-processes.index')->with('success', 'Default Process created successfully!');
    }

    /**
     * Display the specified default process
     */
    public function show($id)
    {
        $process = DefaultProcess::with('cards')->findOrFail($id);
        $cards = DefaultProcessCard::listByProcess($id);
        
        return view('admin::default-processes.show', [
            'process' => $process,
            'cards' => $cards
        ]);
    }

    /**
     * Show the form for editing the specified default process
     */
    public function edit($id)
    {
        $process = DefaultProcess::findOrFail($id);
        
        return view('admin::default-processes.edit', [
            'process' => $process
        ]);
    }

    /**
     * Update the specified default process
     */
    public function update(Request $request, $id)
    {
        $process = DefaultProcess::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'sub_title_english' => 'required|string|max:100',
            'sub_title_arabic' => 'required|string|max:100',
            'bio_english' => 'nullable|string|max:150',
            'bio_arabic' => 'nullable|string|max:150',
            'button_text_english' => 'nullable|string|max:50',
            'button_text_arabic' => 'nullable|string|max:50',
            'url_english' => 'nullable|url|max:255',
            'url_arabic' => 'nullable|url|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        $subTitleEnglishWords = str_word_count($data['sub_title_english']);
        $subTitleArabicWords = str_word_count($data['sub_title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }
        if ($subTitleEnglishWords > 3) {
            return back()->withErrors(['sub_title_english' => 'English subtitle must not exceed 3 words'])->withInput();
        }
        if ($subTitleArabicWords > 3) {
            return back()->withErrors(['sub_title_arabic' => 'Arabic subtitle must not exceed 3 words'])->withInput();
        }
        
        // Validate button text word count if provided
        if (!empty($data['button_text_english'])) {
            $buttonEnglishWords = str_word_count($data['button_text_english']);
            if ($buttonEnglishWords > 2) {
                return back()->withErrors(['button_text_english' => 'English button text must not exceed 2 words'])->withInput();
            }
        }
        if (!empty($data['button_text_arabic'])) {
            $buttonArabicWords = str_word_count($data['button_text_arabic'], 0, 'أ-ي');
            if ($buttonArabicWords > 2) {
                return back()->withErrors(['button_text_arabic' => 'Arabic button text must not exceed 2 words'])->withInput();
            }
        }

        $process->update($data);

        return redirect()->route('admin.default-processes.index')->with('success', 'Default Process updated successfully!');
    }

    /**
     * Remove the specified default process (soft delete)
     */
    public function destroy($id)
    {
        $process = DefaultProcess::findOrFail($id);
        $process->delete();

        return redirect()->route('admin.default-processes.index')->with('success', 'Default Process moved to trash successfully!');
    }

    /**
     * Display trashed default processes
     */
    public function trashed()
    {
        $processes = DefaultProcess::trashed();
        
        return view('admin::default-processes.trashed', [
            'processes' => $processes
        ]);
    }

    /**
     * Restore a trashed default process
     */
    public function restore($id)
    {
        $process = DefaultProcess::withTrashed()->findOrFail($id);
        $process->restore();

        return redirect()->route('admin.default-processes.trashed')->with('success', 'Default Process restored successfully!');
    }

    /**
     * Permanently delete a default process
     */
    public function forceDelete($id)
    {
        $process = DefaultProcess::withTrashed()->findOrFail($id);
        $process->forceDelete();

        return redirect()->route('admin.default-processes.trashed')->with('success', 'Default Process permanently deleted!');
    }

    /**
     * Toggle default process status (Active/Not Active)
     */
    public function toggleStatus($id)
    {
        $process = DefaultProcess::findOrFail($id);
        $process->status = $process->status == 0 ? 1 : 0;
        $process->save();

        $statusText = $process->status == 0 ? 'activated' : 'deactivated';
        return redirect()->route('admin.default-processes.index')->with('success', "Default Process {$statusText} successfully!");
    }
}

