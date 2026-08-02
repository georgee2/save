<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\DisposableEmail;
use App\Services\ActivityLogService;
use App\Services\CustomerRegistrationService;
use App\Support\LoginThrottle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    /**
     * Register a customer from the mobile app. Shares logic with the website.
     * An invite email is sent; the customer sets their password before logging in.
     */
    public function register(Request $request, CustomerRegistrationService $registration)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email:rfc,dns', 'max:255', new DisposableEmail()],
            'phone' => 'nullable|string|max:30',
            'consent' => 'accepted',
            'preferred_locale' => 'sometimes|in:en,ar',
        ]);

        // Per-email throttle (route throttle is IP-only): cap repeated signups for
        // the same address to blunt automated account-creation abuse.
        $emailKey = 'api-register:' . Str::lower(trim($data['email']));
        if (RateLimiter::tooManyAttempts($emailKey, 10)) {
            throw ValidationException::withMessages([
                'email' => ['Too many attempts. Please try again later.'],
            ])->status(429);
        }
        RateLimiter::hit($emailKey, 3600);

        $registration->register($data, 'app');

        return response()->json([
            'success' => true,
            'message' => 'Account created. Check your email to set your password and activate your account.',
        ]);
    }

    /**
     * Issue a Sanctum token for a customer account.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string|max:255',
        ]);

        $email = Str::lower(trim($request->email));

        // Narrow per-email+IP throttle. The comment here used to claim this capped failures
        // per account, but the key contains the IP, so rotating addresses reset it - the
        // account-wide ceiling below is what actually does that.
        $throttleKey = 'api-login:' . $email . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again later.'],
            ])->status(429);
        }

        $user = User::where('email', $email)->first();

        // Shared with the web login, so an attacker cannot spend the web budget and then
        // start again on the API against the same account.
        if (LoginThrottle::locked($email, $user)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again later.'],
            ])->status(429);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            LoginThrottle::recordFailure($email, $user);

            try {
                ActivityLogService::logAuth('failed_login', $user, [
                    'email' => $email,
                    'reason' => $user ? 'bad_password' : 'unknown_email',
                    'channel' => 'api',
                ]);
            } catch (\Throwable $e) {
                Log::warning('Failed-login audit entry could not be written: ' . $e->getMessage());
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Only customer accounts may use the app API.
        if (!$user->isCustomer()) {
            throw ValidationException::withMessages([
                'email' => ['This account cannot access the customer app.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['This account is inactive.'],
            ]);
        }

        RateLimiter::clear($throttleKey);
        LoginThrottle::clear($email, $user);

        $token = $user->createToken(
            $request->input('device_name', 'mobile-app'),
            ['customer:read', 'customer:write']
        );

        return response()->json([
            'success' => true,
            'token' => $token->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ]);
    }

    /**
     * Return the authenticated customer.
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'preferred_locale' => $user->preferred_locale,
        ]);
    }

    /**
     * Revoke the current access token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true]);
    }
}
