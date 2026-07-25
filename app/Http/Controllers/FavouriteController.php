<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Project;
use App\Models\Offer;
use App\Models\InteriorDesignGallery;
use App\Models\Emirate;
use App\Models\ContactInformation;
use App\Mail\FavouritesMail;
use App\Support\GroupsFavourites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FavouriteController extends Controller
{
    use GroupsFavourites;

    public function index()
    {
        $sessionId = Favourite::getSessionId();

        $favourites = Favourite::forSession($sessionId)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        $grouped = $this->groupFavourites($favourites);
        $totalCount = $grouped['projects']->count() + $grouped['offers']->count() + $grouped['interiors']->count();
        $shareUrl = route('favourites.shared', ['token' => $sessionId]);
        $favouriteId = strtoupper(substr($sessionId, 0, 8));

        return view('pages.favourites.index', compact('grouped', 'totalCount', 'shareUrl', 'favouriteId'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:project,offer,interior',
            'item_id' => 'required|integer',
            'emirate_id' => 'nullable|integer',
            'price' => 'nullable|numeric',
        ]);

        $sessionId = Favourite::getSessionId();
        $itemType = $request->input('item_type');
        $itemId = $request->input('item_id');

        $existing = Favourite::forSession($sessionId)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Favourite::create([
                'session_id' => $sessionId,
                'item_type' => $itemType,
                'item_id' => $itemId,
                'emirate_id' => $request->input('emirate_id'),
                'price' => $request->input('price'),
                'expires_at' => now()->addDays(30),
            ]);
            $added = true;
        }

        $count = Favourite::countForSession($sessionId);

        return response()->json([
            'success' => true,
            'added' => $added,
            'count' => $count,
        ]);
    }

    public function remove($id)
    {
        $sessionId = Favourite::getSessionId();

        $favourite = Favourite::forSession($sessionId)->findOrFail($id);
        $favourite->delete();

        $count = Favourite::countForSession($sessionId);

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    public function clear()
    {
        $sessionId = Favourite::getSessionId();
        Favourite::forSession($sessionId)->delete();

        return response()->json([
            'success' => true,
            'count' => 0,
        ]);
    }

    public function count()
    {
        $sessionId = Favourite::getSessionId();

        $items = Favourite::forSession($sessionId)
            ->active()
            ->select('item_type', 'item_id')
            ->get()
            ->map(fn($f) => $f->item_type . '_' . $f->item_id)
            ->toArray();

        return response()->json([
            'count' => count($items),
            'items' => $items,
        ]);
    }

    public function shared($token)
    {
        $favourites = Favourite::forSession($token)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        if ($favourites->isEmpty()) {
            abort(404);
        }

        $grouped = $this->groupFavourites($favourites);
        $totalCount = $grouped['projects']->count() + $grouped['offers']->count() + $grouped['interiors']->count();

        return view('pages.favourites.shared', compact('grouped', 'totalCount'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:100',
        ]);

        $sessionId = Favourite::getSessionId();

        $favourites = Favourite::forSession($sessionId)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        if ($favourites->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No favourites to send.'], 422);
        }

        // Stamp the requester's details only once we know this session actually owns rows.
        // These columns are what the CRM surfaces as the lead identity, so writing them
        // before the check let a caller overwrite a lead record without holding any items.
        Favourite::forSession($sessionId)->active()->update(array_filter([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
        ]));

        $grouped = $this->groupFavourites($favourites);
        $shareUrl = route('favourites.shared', ['token' => $sessionId]);
        $favouriteId = strtoupper(substr($sessionId, 0, 8));

        $contactInfo = ContactInformation::getContactInfo();
        $whatsapp = $contactInfo->whatsapp ?? null;

        try {
            Mail::to($request->input('email'))->send(
                new FavouritesMail(
                    $grouped,
                    $shareUrl,
                    $request->input('name'),
                    $whatsapp,
                    $favouriteId
                )
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send email. Please try again.'], 500);
        }
    }

}
