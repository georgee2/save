<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordResetMail;
use App\Models\User;
use App\Rules\DisposableEmail;
use App\Services\CustomerRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

/**
 * Mobile-app parity for the web's forgot/reset/resend-activation flows: same brokers,
 * validation, and anti-enumeration behavior as Auth\CustomerForgotPasswordController /
 * Auth\CustomerPasswordController / Auth\CustomerRegisterController::resendActivation,
 * just JSON instead of views/redirects (documents/mobile-api/02_AUTH_AND_ACCOUNT_API.md).
 */
class CustomerPasswordController extends Controller
{
    /**
     * Email a password-reset link. Response is uniform regardless of whether the
     * email exists (anti-enumeration) - mirrors the web exactly.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', new DisposableEmail()],
        ]);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        if ($user && $user->isCustomer() && $user->is_active) {
            // Per-email cooldown (anti email-bomb), same as the web.
            $cooldownKey = 'pwreset-cooldown:'.$email;
            if (!Cache::has($cooldownKey)) {
                Cache::put($cooldownKey, true, now()->addMinutes(10));

                $token = Password::broker()->createToken($user);

                dispatch(function () use ($user, $token) {
                    try {
                        Mail::to($user->email)->send(new CustomerPasswordResetMail($user, $token));
                    } catch (\Throwable $e) {
                        Log::warning('Customer password-reset mail failed (API): '.$e->getMessage());
                    }
                })->afterResponse();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'If that email exists, a reset link has been sent.',
        ]);
    }

    /**
     * Consume EITHER an activation-invite token (invitations broker, from register's
     * invite email) OR a standard forgot-password token (default broker) and set a
     * new password - same dual-broker order as the web's set-password page, so this
     * one endpoint completes both "activate a new account" and "reset a forgotten
     * password" natively in the app, no browser needed for either. Does NOT auto-login
     * (there's no session for a Sanctum client) - the app calls /login next.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            // regex restricts to printable ASCII (no Arabic / non-Latin characters),
            // same rule as updatePassword/setPassword.
            'password' => ['required', 'string', 'confirmed', 'regex:/^[\x20-\x7E]+$/', PasswordRule::defaults()],
        ], [
            'password.regex' => __('lang.account_password_english_only'),
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $callback = function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'password_set_at' => now(),
                'email_verified_at' => $user->email_verified_at ?? now(),
                'is_active' => true,
            ])->save();
        };

        // Try the invitation token first (activation), then fall back to a standard
        // reset token - mirrors Auth\CustomerPasswordController::setPassword exactly.
        $status = Password::broker('invitations')->reset($credentials, $callback);

        if ($status !== Password::PASSWORD_RESET) {
            $status = Password::broker()->reset($credentials, $callback);
        }

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'message' => __($status),
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Resend the activation invite. Response is uniform regardless of whether the
     * account exists (anti-enumeration) - mirrors the web exactly, including that it
     * does not gate on password_set_at (the web controller doesn't either).
     */
    public function resendActivation(Request $request, CustomerRegistrationService $registration)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', new DisposableEmail()],
        ]);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        if ($user && $user->isCustomer() && $user->is_active) {
            $registration->sendInvite($user);
        }

        return response()->json([
            'success' => true,
            'message' => "If that account needs activation, we've sent a new link.",
        ]);
    }
}
