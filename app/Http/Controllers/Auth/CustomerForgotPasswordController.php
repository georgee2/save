<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordResetMail;
use App\Models\PageBanner;
use App\Models\User;
use App\Rules\DisposableEmail;
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
        // Honeypot + time-trap (mirrors registration): bots fill hidden fields
        // and submit instantly. Short-circuit to the uniform response.
        if ($request->filled('website_url')) {
            return $this->done();
        }
        $formLoaded = (int) $request->input('_form_loaded', 0);
        if ($formLoaded > 0 && (time() - $formLoaded) < 3) {
            return $this->done();
        }

        $request->validate([
            'email' => ['required', 'email:rfc,dns', new DisposableEmail()],
        ]);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        // Only send for active customer accounts; silently skip otherwise.
        if ($user && $user->isCustomer() && $user->is_active) {
            // Per-email cooldown (anti email-bomb): only one reset mail per email
            // every 10 minutes, on top of the broker's built-in throttle.
            $cooldownKey = 'pwreset-cooldown:' . $email;
            if (!Cache::has($cooldownKey)) {
                Cache::put($cooldownKey, true, now()->addMinutes(10));

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
