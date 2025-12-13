<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\DefaultProcess;
use App\Models\DefaultProcessCard;

class DefaultProcessCardController extends Controller
{
    /**
     * Display cards for a specific process
     */
    public function index($processId)
    {
        $process = DefaultProcess::findOrFail($processId);
        $cards = DefaultProcessCard::listByProcess($processId);
        
        return view('admin::default-process-cards.index', [
            'process' => $process,
            'cards' => $cards
        ]);
    }

    /**
     * Show the form for creating a new card
     */
    public function create($processId)
    {
        $process = DefaultProcess::findOrFail($processId);
        
        return view('admin::default-process-cards.create', [
            'process' => $process
        ]);
    }

    /**
     * Store a newly created card
     */
    public function store(Request $request, $processId)
    {
        $process = DefaultProcess::findOrFail($processId);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'bio_english' => 'required|string|max:300',
            'bio_arabic' => 'required|string|max:300',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }

        $data['default_process_id'] = $processId;
        DefaultProcessCard::create($data);

        return redirect()->route('admin.default-process-cards.index', ['processId' => $processId])
            ->with('success', 'Card created successfully!');
    }

    /**
     * Show the form for editing the specified card
     */
    public function edit($processId, $id)
    {
        $process = DefaultProcess::findOrFail($processId);
        $card = DefaultProcessCard::findOrFail($id);
        
        return view('admin::default-process-cards.edit', [
            'process' => $process,
            'card' => $card
        ]);
    }

    /**
     * Update the specified card
     */
    public function update(Request $request, $processId, $id)
    {
        $card = DefaultProcessCard::findOrFail($id);
        
        $data = $request->validate([
            'title_english' => 'required|string|max:150',
            'title_arabic' => 'required|string|max:150',
            'bio_english' => 'required|string|max:300',
            'bio_arabic' => 'required|string|max:300',
            'ordering' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        // Validate word count for titles
        $titleEnglishWords = str_word_count($data['title_english']);
        $titleArabicWords = str_word_count($data['title_arabic'], 0, 'أ-ي');
        
        if ($titleEnglishWords > 5) {
            return back()->withErrors(['title_english' => 'English title must not exceed 5 words'])->withInput();
        }
        if ($titleArabicWords > 5) {
            return back()->withErrors(['title_arabic' => 'Arabic title must not exceed 5 words'])->withInput();
        }

        $card->update($data);

        return redirect()->route('admin.default-process-cards.index', ['processId' => $processId])
            ->with('success', 'Card updated successfully!');
    }

    /**
     * Remove the specified card (soft delete)
     */
    public function destroy($processId, $id)
    {
        $card = DefaultProcessCard::findOrFail($id);
        $card->delete();

        return redirect()->route('admin.default-process-cards.index', ['processId' => $processId])
            ->with('success', 'Card moved to trash successfully!');
    }

    /**
     * Display trashed cards for a specific process
     */
    public function trashed($processId)
    {
        $process = DefaultProcess::findOrFail($processId);
        $cards = DefaultProcessCard::trashedByProcess($processId);
        
        return view('admin::default-process-cards.trashed', [
            'process' => $process,
            'cards' => $cards
        ]);
    }

    /**
     * Restore a trashed card
     */
    public function restore($processId, $id)
    {
        $card = DefaultProcessCard::withTrashed()->findOrFail($id);
        $card->restore();

        return redirect()->route('admin.default-process-cards.trashed', ['processId' => $processId])
            ->with('success', 'Card restored successfully!');
    }

    /**
     * Permanently delete a card
     */
    public function forceDelete($processId, $id)
    {
        $card = DefaultProcessCard::withTrashed()->findOrFail($id);
        $card->forceDelete();

        return redirect()->route('admin.default-process-cards.trashed', ['processId' => $processId])
            ->with('success', 'Card permanently deleted!');
    }

    /**
     * Toggle card status
     */
    public function toggleStatus($processId, $id)
    {
        $card = DefaultProcessCard::findOrFail($id);
        $card->status = $card->status == 0 ? 1 : 0;
        $card->save();

        $statusText = $card->status == 0 ? 'activated' : 'deactivated';
        return redirect()->route('admin.default-process-cards.index', ['processId' => $processId])
            ->with('success', "Card {$statusText} successfully!");
    }

    /**
     * Update cards ordering via AJAX
     */
    public function updateOrders(Request $request, $processId)
    {
        try {
            $orders = json_decode($request->input('orders'), true);
            
            if (!is_array($orders)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid orders data'
                ], 400);
            }

            foreach ($orders as $order) {
                DefaultProcessCard::where('id', $order['id'])->update(['ordering' => $order['order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cards order updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }
}

