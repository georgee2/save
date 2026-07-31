<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordResetMail;
use App\Models\PageBanner;
use App\Models\User;
use App\Rules\DisposableEmail;
use App\Support\EmailRules;
use App\Support\FormGuard;
use App\Support\TimingGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        return view('pages.account.auth.forgot-password', [
            'pageBanner' => PageBanner::getByTarget('reset_password'),
        ]);
    }

    /**
     * Email a password-reset link. Response is uniform to avoid user enumeration.
     */
    public function sendResetLink(Request $request)
    {
        // Honeypot + signed time-trap (mirrors registration): bots fill hidden fields
        // and submit instantly. Short-circuit to the uniform response.
        if ($reason = FormGuard::tripped($request)) {
            if ($reason->isBot()) {
                return $this->done();
            }

            // Safe to surface: it says nothing about whether the address has an account.
            return back()->withInput()->withErrors(['email' => __('lang.form_expired')]);
        }

        $request->validate([
            'email' => ['required', EmailRules::format(), new DisposableEmail()],
        ]);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        $issued = false;

        // Only send for active customer accounts; silently skip otherwise.
        if ($user && $user->isCustomer() && $user->is_active) {
            // Per-email cooldown (anti email-bomb): one reset mail per address every 10
            // minutes. Cache::add is atomic; the previous has()-then-put() let two
            // concurrent requests both pass and send twice.
            $cooldownKey = 'pwreset-cooldown:' . $email;
            if (Cache::add($cooldownKey, true, now()->addMinutes(10))) {
                $issued = true;

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
        }

        // createToken bcrypt-hashes the token, and that hash is the whole timing signal:
        // without it an unknown address answers measurably faster than a real one, which
        // enumerates users regardless of the uniform message below.
        if (!$issued) {
            TimingGuard::burnPasswordHash();
        }

        return $this->done();
    }

    /**
     * Uniform response so the endpoint does not reveal whether an email exists.
     */
    private function done()
    {
        return back()->with('success', __('lang.account_reset_link_sent'));
    }
}
