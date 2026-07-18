<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Maximum login attempts before lockout
     */
    protected $maxAttempts = 5;
    
    /**
     * Lockout duration in seconds
     */
    protected $decaySeconds = 60;

    /**
     * Show the login form
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt with enhanced validation
     */
    public function checkuser(Request $request)
    {
        // Validate input with custom messages
        $credentials = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address is too long.',
            'password.required' => 'Please enter your password.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Check rate limiting
        $throttleKey = $this->throttleKey($request);
        
        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            throw ValidationException::withMessages([
                'email' => [
                    "Too many login attempts. Please try again in {$seconds} seconds."
                ],
            ])->status(429);
        }

        // Attempt authentication. Use a single generic message whether the email
        // is unknown or the password is wrong, so the login page does not leak
        // which email addresses have accounts (no user enumeration).
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, $this->decaySeconds);

            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // Credentials are valid; only now is it safe to reveal a deactivated state
        // (the user has proven ownership of the account).
        if (Auth::user()->is_active === false) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact support.'],
            ]);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($throttleKey);

        // Regenerate session for security
        $request->session()->regenerate();

        // Log the successful login
        try {
            \App\Services\ActivityLogService::logAuth(
                'login',
                Auth::user(),
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        } catch (\Exception $e) {
            // Silently fail if logging doesn't work
        }

        // Route by account type: customers go to the front-end portal,
        // staff go to the admin dashboard.
        if (Auth::user()->isCustomer()) {
            return redirect()->intended(route('account.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return redirect()->intended(route('Admin'))
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Log the logout
        if (Auth::check()) {
            try {
                \App\Services\ActivityLogService::logAuth(
                    'logout',
                    Auth::user(),
                    ['ip' => $request->ip()]
                );
            } catch (\Exception $e) {
                // Silently fail
            }
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Generate throttle key for rate limiting
     */
    protected function throttleKey(Request $request): string
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }
}
