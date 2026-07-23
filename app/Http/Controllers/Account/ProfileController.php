<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;

class ProfileController extends Controller
{
    /**
     * Show the authenticated customer's profile (read-only).
     */
    public function show()
    {
        return view('pages.account.profile', [
            'user' => auth()->user(),
            'pageBanner' => PageBanner::getByTarget('account'),
        ]);
    }
}
