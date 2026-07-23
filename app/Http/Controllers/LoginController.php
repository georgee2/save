<?php

namespace App\Http\Controllers;

use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Maximum login attempts before lockout (per email + IP).
     */
    protected $maxAttempts = 5;
    
    /**
     * Lockout duration in seconds.
     */
    protected $decaySeconds = 60;

    /**
     * Maximum login attempts per IP address (guards distributed credential-stuffing
     * that rotates many emails from a single IP). Wider window than the per-email cap.
     */
    protected $maxAttemptsPerIp = 20;

    /**
     * Per-IP lockout window in seconds.
     */
    protected $ipDecaySeconds = 300;

    /**
     * Failed attempts (per email + IP) after which a CAPTCHA challenge is required.
     */
    protected $captchaThreshold = 3;

    public function __construct(protected RecaptchaService $recaptcha)
    {
    }

    /**
     * Show the login form
     */
    public function login()
    {
        return view('auth.login', [
            'recaptchaEnabled' => $this->recaptcha->isEnabled(),
        ]);
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

        // Rate limiting: a narrow per-email+IP cap and a wider per-IP cap. The
        // per-IP cap blocks distributed credential-stuffing that rotates many
        // emails from a single address (which the per-email key alone misses).
        $throttleKey = $this->throttleKey($request);
        $ipThrottleKey = $this->ipThrottleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => [
                    "Too many login attempts. Please try again in {$seconds} seconds."
                ],
            ])->status(429);
        }

        if (RateLimiter::tooManyAttempts($ipThrottleKey, $this->maxAttemptsPerIp)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);

            throw ValidationException::withMessages([
                'email' => [
                    "Too many login attempts. Please try again in {$seconds} seconds."
                ],
            ])->status(429);
        }

        // Step-up CAPTCHA: once an email+IP pair has failed repeatedly, require a
        // valid reCAPTCHA before attempting auth. Legitimate first attempts stay
        // frictionless; automated retries get challenged. Only when reCAPTCHA is
        // configured (skipped locally / when keys are absent).
        if ($this->recaptcha->isEnabled()
            && RateLimiter::attempts($throttleKey) >= $this->captchaThreshold
            && !$this->recaptcha->verify(
                $request->input('g-recaptcha-response'),
                $request->ip(),
                (float) config('services.recaptcha.login_min_score', 0.3)
            )) {
            RateLimiter::hit($throttleKey, $this->decaySeconds);
            RateLimiter::hit($ipThrottleKey, $this->ipDecaySeconds);

            throw ValidationException::withMessages([
                'email' => ['Additional verification failed. Please try again.'],
            ]);
        }

        // Attempt authentication. Use a single generic message whether the email
        // is unknown or the password is wrong, so the login page does not leak
        // which email addresses have accounts (no user enumeration).
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, $this->decaySeconds);
            RateLimiter::hit($ipThrottleKey, $this->ipDecaySeconds);

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

        // Clear rate limiters on successful login
        RateLimiter::clear($throttleKey);
        RateLimiter::clear($ipThrottleKey);

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

        // Drop the guest favourites cookie so the next visitor on a shared
        // browser doesn't inherit the previous customer's wishlist.
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('favourite_session_id'));

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Generate throttle key for rate limiting
     */
    protected function throttleKey(Request $request): string
    {
        return 'login|' . strtolower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * Generate a per-IP throttle key for rate limiting.
     */
    protected function ipThrottleKey(Request $request): string
    {
        return 'login-ip|' . $request->ip();
    }
}
