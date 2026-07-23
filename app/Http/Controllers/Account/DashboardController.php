<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;

class DashboardController extends Controller
{
    /**
     * Minimal customer portal landing page. Projects/profile arrive in later sub-plans.
     */
    public function index()
    {
        return view('pages.account.dashboard', [
            'user' => auth()->user(),
            'pageBanner' => PageBanner::getByTarget('account'),
        ]);
    }
}
