<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomerRegistrationService;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerRegisterController extends Controller
{
    public function __construct(
        protected CustomerRegistrationService $registration,
        protected RecaptchaService $recaptcha,
    ) {
    }

    /**
     * Show the registration form.
     */
    public function showForm()
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('pages.account.auth.register', [
            'recaptchaEnabled' => $this->recaptcha->isEnabled(),
        ]);
    }

    /**
     * Handle a registration submission (web).
     */
    public function register(Request $request)
    {
        // Layer 1: Honeypot - bots fill hidden fields, real users do not.
        if ($request->filled('website_url')) {
            return $this->done($request);
        }

        // Layer 2: Time-based check - reject submissions faster than 3 seconds.
        $formLoaded = (int) $request->input('_form_loaded', 0);
        if ($formLoaded > 0 && (time() - $formLoaded) < 3) {
            return $this->done($request);
        }

        // Layer 3: reCAPTCHA v3 (only enforced when keys are configured). Guards
        // against using registration to email-bomb arbitrary third parties.
        if ($this->recaptcha->isEnabled()
            && !$this->recaptcha->verify($request->input('g-recaptcha-response'), $request->ip())) {
            $message = app()->getLocale() === 'ar'
                ? 'فشل التحقق من أنك لست روبوت. يرجى المحاولة مرة أخرى.'
                : 'Spam verification failed. Please try again.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return back()->withInput()->withErrors(['recaptcha' => $message]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'consent' => 'accepted',
        ]);

        $this->registration->register([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'consent' => $request->boolean('consent'),
            'preferred_locale' => app()->getLocale(),
        ], 'web');

        return $this->done($request);
    }

    /**
     * Show the "resend activation email" form.
     */
    public function showResendForm()
    {
        if (auth()->check()) {
            return redirect()->route('account.dashboard');
        }

        return view('pages.account.auth.resend-activation');
    }

    /**
     * Resend the activation invite. Response is uniform to avoid user enumeration.
     */
    public function resendActivation(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = Str::lower(trim($request->email));
        $user = User::where('email', $email)->first();

        // Only (re)send for active customer accounts; silently skip otherwise.
        if ($user && $user->isCustomer() && $user->is_active) {
            $this->registration->sendInvite($user);
        }

        return back()->with('success', __('lang.account_activation_resent'));
    }

    /**
     * Uniform response so the endpoint does not reveal whether an email already exists.
     */
    private function done(Request $request)
    {
        $message = app()->getLocale() === 'ar'
            ? 'تم إنشاء حسابك. تحقق من بريدك الإلكتروني لتعيين كلمة المرور وتفعيل حسابك.'
            : 'Your account has been created. Check your email to set your password and activate your account.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('login')->with('success', $message);
    }
}
