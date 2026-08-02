<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class CustomerPasswordController extends Controller
{
    /**
     * Show the set-password form (reached from the invite email link).
     */
    public function showForm(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('pages.account.auth.set-password', [
            'token' => $request->route('token'),
            'email' => $request->query('email'),
            'pageBanner' => PageBanner::getByTarget('reset_password'),
        ]);
    }

    /**
     * Consume the invite token, set the password, verify the email, and log in.
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            // regex restricts to printable ASCII (no Arabic / non-Latin characters).
            'password' => ['required', 'string', 'confirmed', 'regex:/^[\x20-\x7E]+$/', PasswordRule::defaults()],
        ], [
            'password.regex' => __('lang.account_password_english_only'),
        ]);

        // This endpoint falls back to the default broker below, which reads the same
        // password_reset_tokens table staff resets use. Without an account-type check a
        // staff/admin reset token could be redeemed here and then session-logged-in at the
        // bottom of this method, bypassing LoginController entirely (no rate limiting, no
        // reCAPTCHA step-up, no audit log). StaffPasswordController applies the mirror guard.
        //
        // isCustomer() is a strict comparison and fails closed; isStaff() treats a NULL
        // account_type as staff, so !isStaff() would be the wrong test here.
        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (! $user || ! $user->isCustomer() || ! $user->is_active) {
            return $this->invalidLink($request);
        }

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $callback = function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'password_set_at' => now(),
                'email_verified_at' => $user->email_verified_at ?? now(),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        };

        // The same page serves two token types: long-lived activation invites
        // (invitations broker) and short-lived forgot-password links (default
        // broker). Try the invitation token first, then fall back to a reset.
        $status = Password::broker('invitations')->reset($credentials, $callback);

        if ($status !== Password::PASSWORD_RESET) {
            $status = Password::broker()->reset($credentials, $callback);
        }

        if ($status !== Password::PASSWORD_RESET) {
            return $this->invalidLink($request);
        }

        // Log the customer in immediately after activation. Safe: the guard above already
        // established this address belongs to an active customer account.
        Auth::login($user->refresh());

        $message = app()->getLocale() === 'ar'
            ? 'تم تفعيل حسابك بنجاح.'
            : 'Your account has been activated successfully.';

        return redirect()->route('account.dashboard')->with('success', $message);
    }

    /**
     * One response for every failure mode.
     *
     * Returning the broker status verbatim distinguished "we can't find a user with that
     * email" (passwords.user) from "this token is invalid" (passwords.token), which turned
     * this unauthenticated endpoint into an account-existence oracle.
     */
    private function invalidLink(Request $request)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __('lang.account_reset_link_invalid')]);
    }
}
