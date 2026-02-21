<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\User;

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

        // Check if user exists
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            RateLimiter::hit($throttleKey, $this->decaySeconds);
            
            throw ValidationException::withMessages([
                'email' => ['No account found with this email address.'],
            ]);
        }

        // Check if user account is active (if you have is_active field)
        if (method_exists($user, 'getAttribute') && $user->getAttribute('is_active') === false) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact support.'],
            ]);
        }

        // Attempt authentication
        $remember = $request->boolean('remember');
        
        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, $this->decaySeconds);
            
            throw ValidationException::withMessages([
                'password' => ['The password you entered is incorrect.'],
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
