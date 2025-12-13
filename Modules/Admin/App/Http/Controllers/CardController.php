<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Card;
use App\Models\HomeBlock;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class CardController extends Controller
{
    protected $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * Display a listing of cards
     */
    public function index()
    {
        $cards = $this->card->list();
        
        return view('admin::cards.index', [
            'cards' => $cards
        ]);
    }

    /**
     * Show the form for creating a new card
     */
    public function create()
    {
        $homeBlocks = HomeBlock::all();
        
        return view('admin::cards.create', [
            'homeBlocks' => $homeBlocks
        ]);
    }

    /**
     * Store a newly created card
     */
    public function store(Request $request)
    {
        // Base validation
        $rules = [
            'card_type' => 'required|in:card_with_background,icon_card',
            'home_block_id' => 'required|exists:home_blocks,id',
            'status' => 'nullable|in:0,1',
        ];

        // Conditional validation based on card type
        if ($request->card_type == 'card_with_background') {
            // Card with Background: only background + icon white
            $rules['background'] = 'required|image|mimes:png,jpg,jpeg,webp|max:2048';
            $rules['icon_white'] = 'required|image|mimes:png,jpg,jpeg,webp|max:2048';
        } else {
            // Icon Card: icon dark + icon white + text fields
            $rules['title_english'] = 'required|string|max:100';
            $rules['title_arabic'] = 'required|string|max:100';
            $rules['bio_english'] = 'required|string|max:150';
            $rules['bio_arabic'] = 'required|string|max:150';
            $rules['icon_dark'] = 'required|image|mimes:png,jpg,jpeg,webp|max:2048';
            $rules['icon_white'] = 'required|image|mimes:png,jpg,jpeg,webp|max:2048';
        }

        $data = $request->validate($rules);
        $data['status'] = $request->input('status', 0);

        // Handle Icon Dark Upload (100x100) - for card_with_background
        if ($request->hasFile('icon_dark')) {
            $iconDarkFile = $request->file('icon_dark');
            $image = Image::make($iconDarkFile)->resize(100, 100)->encode('webp', 90);
            $iconDarkName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/icons-dark/' . $iconDarkName, (string) $image);
            $data['icon_dark'] = "/uploads/cards/icons-dark/{$iconDarkName}";
        }

        // Handle Icon White Upload (100x100) - for both types
        if ($request->hasFile('icon_white')) {
            $iconWhiteFile = $request->file('icon_white');
            $image = Image::make($iconWhiteFile)->resize(100, 100)->encode('webp', 90);
            $iconWhiteName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/icons-white/' . $iconWhiteName, (string) $image);
            $data['icon_white'] = "/uploads/cards/icons-white/{$iconWhiteName}";
        }

        // Handle Background Upload (300x300) - for icon_card
        if ($request->hasFile('background')) {
            $backgroundFile = $request->file('background');
            $image = Image::make($backgroundFile)->resize(420, 345)->encode('webp', 90);
            $backgroundName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/backgrounds/' . $backgroundName, (string) $image);
            $data['background'] = "/uploads/cards/backgrounds/{$backgroundName}";
        }

        Card::create($data);

        return redirect()->route('card.index')->with('success', 'Card created successfully!');
    }

    /**
     * Show the form for editing card
     */
    public function edit($id)
    {
        $card = Card::findOrFail($id);
        $homeBlocks = HomeBlock::all();
        
        return view('admin::cards.edit', [
            'card' => $card,
            'homeBlocks' => $homeBlocks
        ]);
    }

    /**
     * Update the specified card
     */
    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        
        // Base validation
        $rules = [
            'card_type' => 'required|in:card_with_background,icon_card',
            'home_block_id' => 'required|exists:home_blocks,id',
            'status' => 'nullable|in:0,1',
        ];

        // Conditional validation based on card type
        if ($request->card_type == 'card_with_background') {
            // Card with Background: only background + icon white
            $rules['background'] = 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048';
            $rules['icon_white'] = 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048';
        } else {
            // Icon Card: icon dark + icon white + text fields
            $rules['title_english'] = 'required|string|max:100';
            $rules['title_arabic'] = 'required|string|max:100';
            $rules['bio_english'] = 'required|string|max:150';
            $rules['bio_arabic'] = 'required|string|max:150';
            $rules['icon_dark'] = 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048';
            $rules['icon_white'] = 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048';
        }

        $data = $request->validate($rules);
        $data['status'] = $request->input('status', 0);

        // Handle Icon Dark Upload if new image provided
        if ($request->hasFile('icon_dark')) {
            if ($card->icon_dark) {
                Storage::disk('public')->delete(ltrim($card->icon_dark, '/'));
            }
            $iconDarkFile = $request->file('icon_dark');
            $image = Image::make($iconDarkFile)->resize(100, 100)->encode('webp', 90);
            $iconDarkName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/icons-dark/' . $iconDarkName, (string) $image);
            $data['icon_dark'] = "/uploads/cards/icons-dark/{$iconDarkName}";
        }

        // Handle Icon White Upload if new image provided
        if ($request->hasFile('icon_white')) {
            if ($card->icon_white) {
                Storage::disk('public')->delete(ltrim($card->icon_white, '/'));
            }
            $iconWhiteFile = $request->file('icon_white');
            $image = Image::make($iconWhiteFile)->resize(100, 100)->encode('webp', 90);
            $iconWhiteName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/icons-white/' . $iconWhiteName, (string) $image);
            $data['icon_white'] = "/uploads/cards/icons-white/{$iconWhiteName}";
        }

        // Handle Background Upload if new image provided
        if ($request->hasFile('background')) {
            if ($card->background) {
                Storage::disk('public')->delete(ltrim($card->background, '/'));
            }
            $backgroundFile = $request->file('background');
            $image = Image::make($backgroundFile)->resize(420, 345)->encode('webp', 90);
            $backgroundName = Str::random() . ".webp";
            Storage::disk('public')->put('/uploads/cards/backgrounds/' . $backgroundName, (string) $image);
            $data['background'] = "/uploads/cards/backgrounds/{$backgroundName}";
        }

        $card->update($data);

        return redirect()->route('card.index')->with('success', 'Card updated successfully!');
    }

    /**
     * Soft delete the card
     */
    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $card->delete();

        return redirect()->route('card.index')->with('success', 'Card deleted successfully!');
    }

    /**
     * Display trashed cards
     */
    public function trashed()
    {
        $cards = $this->card->trashed();
        
        return view('admin::cards.trashed', [
            'cards' => $cards
        ]);
    }

    /**
     * Restore trashed card
     */
    public function restore($id)
    {
        $card = Card::withTrashed()->findOrFail($id);
        $card->restore();

        return redirect()->route('card.trashed')->with('success', 'Card restored successfully!');
    }
}

