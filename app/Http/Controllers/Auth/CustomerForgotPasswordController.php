<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CustomerForgotPasswordController extends Controller
{
    /**
     * Show the "forgot password" request form.
     */
    public function showRequestForm()
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('pages.account.auth.forgot-password');
    }

    /**
     * Email a password-reset link. Response is uniform to avoid user enumeration.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        // Only send for active customer accounts; silently skip otherwise.
        if ($user && $user->isCustomer() && $user->is_active) {
            $token = Password::broker()->createToken($user);

            // Send after the response so slow SMTP does not block the form.
            dispatch(function () use ($user, $token) {
                try {
                    Mail::to($user->email)->send(new CustomerPasswordResetMail($user, $token));
                } catch (\Throwable $e) {
                    Log::warning('Customer password-reset mail failed: ' . $e->getMessage());
                }
            })->afterResponse();
        }

        return back()->with('success', __('lang.account_reset_link_sent'));
    }
}
