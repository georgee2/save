<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\StaffPasswordResetMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ProfileController extends Controller
{
    /**
     * Show the authenticated staff member's account page.
     */
    public function edit()
    {
        return view('admin::profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Email a secure password-reset link to the authenticated staff member's own address.
     * The target is always the caller's own account, so there is no user-enumeration concern.
     */
    public function sendResetLink(): RedirectResponse
    {
        $user = Auth::user();

        $token = Password::broker()->createToken($user);

        // Send after the response so slow SMTP does not block the request.
        dispatch(function () use ($user, $token) {
            try {
                Mail::to($user->email)->send(new StaffPasswordResetMail($user, $token));
            } catch (\Throwable $e) {
                Log::warning('Staff password-reset mail failed: ' . $e->getMessage());
            }
        })->afterResponse();

        return redirect()->route('admin.profile.edit')
            ->with('success', __('lang.staff_reset_link_sent'));
    }
}
