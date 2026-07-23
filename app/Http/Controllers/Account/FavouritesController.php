<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\PageBanner;
use App\Support\GroupsFavourites;

class FavouritesController extends Controller
{
    use GroupsFavourites;

    /**
     * The logged-in customer's favourites. Uses the account-aware session id
     * (Favourite::getSessionId() returns the customer's canonical token), so
     * this shows the same list they built as a guest, merged on login, and the
     * existing public favourites.* endpoints handle toggle/remove/clear/email.
     */
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

        return view('pages.account.favourites', compact('grouped', 'totalCount', 'shareUrl', 'favouriteId') + [
            'user' => auth()->user(),
            'pageBanner' => PageBanner::getByTarget('account'),
        ]);
    }
}
