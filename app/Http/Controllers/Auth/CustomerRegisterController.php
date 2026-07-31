<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use App\Models\User;
use App\Rules\DisposableEmail;
use App\Services\CustomerRegistrationService;
use App\Services\RecaptchaService;
use App\Support\EmailRules;
use App\Support\FormGuard;
use App\Support\RecaptchaFallbackLimiter;
use App\Support\RecaptchaOutcome;
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
            'pageBanner' => PageBanner::getByTarget('register'),
        ]);
    }

    /**
     * Handle a registration submission (web).
     */
    public function register(Request $request)
    {
        // Layers 1 & 2: honeypot + signed time-trap. Bot signals get the uniform success
        // response; a stale page gets a visible prompt to refresh so a real user does not
        // silently lose their submission.
        if ($reason = FormGuard::tripped($request)) {
            if ($reason->isBot()) {
                return $this->done($request);
            }

            return $this->staleForm($request);
        }

        // Layer 3: reCAPTCHA v3 (only enforced when keys are configured). Guards
        // against using registration to email-bomb arbitrary third parties.
        $outcome = $this->recaptcha->check($request->input('g-recaptcha-response'), 'register', $request->ip());

        // Could not reach Google: let the submission through rather than blocking signups
        // during an outage, but hold this IP to a much stricter budget than the route
        // throttle so the fail-open path is not itself a free bypass.
        if ($outcome === RecaptchaOutcome::Unavailable
            && RecaptchaFallbackLimiter::exceeded($request, 'register')) {
            $outcome = RecaptchaOutcome::Failed;
        }

        if ($outcome === RecaptchaOutcome::Failed) {
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
            'email' => ['required', EmailRules::format(), 'max:255', new DisposableEmail()],
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

        return view('pages.account.auth.resend-activation', [
            'pageBanner' => PageBanner::getByTarget('register'),
        ]);
    }

    /**
     * Resend the activation invite. Response is uniform to avoid user enumeration.
     */
    public function resendActivation(Request $request)
    {
        // Honeypot + signed time-trap (mirrors registration): short-circuit bots to the
        // uniform response without revealing anything or sending mail.
        if ($reason = FormGuard::tripped($request)) {
            if ($reason->isBot()) {
                return back()->with('success', __('lang.account_activation_resent'));
            }

            return $this->staleForm($request);
        }

        $request->validate([
            'email' => ['required', EmailRules::format(), new DisposableEmail()],
        ]);

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

    /**
     * The signed form timestamp was missing, forged, or expired. Unlike the bot paths this
     * is visible: it is usually a real person on a page that sat open, and a silent success
     * would let them believe the submission went through.
     */
    private function staleForm(Request $request)
    {
        $message = __('lang.form_expired');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }

        return back()->withInput()->withErrors(['email' => $message]);
    }
}
