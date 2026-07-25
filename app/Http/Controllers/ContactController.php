<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Rules\DisposableEmail;
use App\Models\ContactInformation;
use App\Models\ContactUs;
use App\Models\Service;
use App\Models\PageBanner;
use App\Services\RecaptchaService;
use App\Support\FormGuard;
use App\Support\RecaptchaFallbackLimiter;
use App\Support\RecaptchaOutcome;
use App\Models\Partner;
use App\Models\AboutInformation;
use App\Models\ContactPageSection;
use App\Mail\ContactConfirmationMail;

class ContactController extends Controller
{
    public function __construct(protected RecaptchaService $recaptcha)
    {
    }

    /**
     * Display the contact page.
     */
    public function index()
    {
        $contactInfo = ContactInformation::getContactInfo();
        $aboutInfo = AboutInformation::getAboutInfo();

        $services = Service::where('deleted_at', null)
                          ->where('is_sub_service', 0)
                          ->where('publish_status', 0)
                          ->select('id', 'title_english', 'title_arabic')
                          ->get();

        $pageBanner = PageBanner::getByTarget('contact');
        $branches = Partner::getBranches();
        $sections = ContactPageSection::getActiveSections();

        return view('pages.contact.contact', compact('contactInfo', 'aboutInfo', 'services', 'pageBanner', 'branches', 'sections'));
    }

    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        // Layers 1 & 2: honeypot + signed time-trap. Bot signals get the same success
        // response a real submission would, so the bot cannot tune around the trap; a
        // stale page instead gets a visible prompt to refresh.
        if ($reason = FormGuard::tripped($request)) {
            if ($reason->isBot()) {
                return $this->fakeSuccess($request);
            }

            return $this->staleForm($request);
        }

        // Layer 3: reCAPTCHA v3. This used to run only when the request happened to carry
        // a token, so omitting the field skipped verification entirely; the token is now
        // always assessed. Both the contact page and the home inline form post here, hence
        // two acceptable actions.
        $outcome = $this->recaptcha->check(
            $request->input('g-recaptcha-response'),
            ['contact_form', 'home_contact'],
            $request->ip()
        );

        // Could not reach Google: accept the message rather than dropping leads during an
        // outage, but hold this IP to a much stricter budget so failing verification is
        // not itself a bypass.
        if ($outcome === RecaptchaOutcome::Unavailable
            && RecaptchaFallbackLimiter::exceeded($request, 'contact')) {
            $outcome = RecaptchaOutcome::Failed;
        }

        if ($outcome === RecaptchaOutcome::Failed) {
            $errorMessage = app()->getLocale() == 'en'
                ? 'Spam verification failed. Please try again.'
                : 'فشل التحقق من البريد العشوائي. يرجى المحاولة مرة أخرى.';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $errorMessage], 422);
            }
            return back()->withErrors(['recaptcha' => $errorMessage])->withInput();
        }

        // Layer 4: Standard validation + content filtering
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            // Matches the auth flows, which already use this combination. DisposableEmail
            // existed but had never been applied to the form spammers actually target.
            'email' => ['required', 'email:rfc,dns', 'max:255', new DisposableEmail()],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'message' => ['required', 'string', 'max:5000', function ($attr, $value, $fail) {
                $spamPatterns = [
                    '/\[url[=\]]/i',
                    '/\[link[=\]]/i',
                    '/(https?:\/\/\S+.*){4,}/i',
                    '/\b(viagra|cialis|casino|poker|lottery|bitcoin\s*investment|earn\s*\$?\d+\s*daily|click\s*here\s*to\s*win)\b/i',
                    '/<\s*a\s+href/i',
                    '/\{[a-z]+\}/i',
                ];
                foreach ($spamPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        $fail(app()->getLocale() == 'en'
                            ? 'Your message was detected as spam.'
                            : 'تم اكتشاف رسالتك كرسالة غير مرغوب فيها.');
                        return;
                    }
                }
            }],
            'service_id' => 'nullable|exists:services,id',
            // Client-controlled and now persisted and shown in the CRM, so it is pinned to
            // the values our own forms post rather than accepting free text.
            'source' => 'nullable|in:home_inline,contact_page',
        ]);

        // Drop repeat submissions of the same message. Fingerprinted in the cache rather
        // than queried from the database because `message` is a TEXT column and MySQL
        // cannot index it without a prefix length. Cache::add is atomic on the file driver
        // when given a TTL, so two concurrent posts cannot both win.
        $fingerprint = 'contact-dup:' . sha1(Str::lower($request->email) . '|' . $request->message);
        if (!Cache::add($fingerprint, true, 600)) {
            return $this->fakeSuccess($request);
        }

        ContactUs::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'service_id' => $request->service_id,
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 250, ''),
            'source' => $request->input('source', 'contact_page'),
            'status' => 'Pending',
        ]);

        $this->sendConfirmationEmail($request->email, $request->name);

        $successMessage = app()->getLocale() == 'en'
            ? 'Your message has been sent successfully! We will contact you soon.'
            : 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage
            ]);
        }

        return back()->with('success', $successMessage);
    }

    private function fakeSuccess(Request $request)
    {
        $msg = app()->getLocale() == 'en'
            ? 'Your message has been sent successfully! We will contact you soon.'
            : 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    /**
     * The signed form timestamp was missing, forged, or expired. Shown to the user rather
     * than faked as a success: this is usually a real person whose page sat open, and
     * silently discarding their message would be worse than asking them to resend.
     */
    private function staleForm(Request $request)
    {
        $msg = __('lang.form_expired');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $msg], 422);
        }

        return back()->withInput()->withErrors(['_form_ts' => $msg]);
    }

    private function sendConfirmationEmail(string $email, ?string $name): void
    {
        // One auto-reply per address per 10 minutes. This endpoint is unauthenticated and
        // mails whatever address is typed in, so without a per-address cap it is a way to
        // point our SMTP relay at someone else's inbox.
        if (!Cache::add('contact-confirm:' . Str::lower($email), true, 600)) {
            return;
        }

        try {
            $contactInfo = ContactInformation::getContactInfo();

            $locale = app()->getLocale();
            $emailBody = $locale == 'ar'
                ? ($contactInfo->confirmation_email_body_ar ?? null)
                : ($contactInfo->confirmation_email_body_en ?? null);

            if (!$emailBody) {
                $emailBody = $locale == 'ar'
                    ? "شكراً لتواصلك معنا!\n\nلقد استلمنا رسالتك وسيقوم فريقنا بالرد عليك في أقرب وقت ممكن.\n\nنقدر اهتمامك بخدماتنا ونتطلع للعمل معك."
                    : "Thank you for reaching out to us!\n\nWe have received your message and our team will get back to you as soon as possible.\n\nWe appreciate your interest in our services and look forward to working with you.";
            }

            $branches = Partner::getBranches();

            // Send after the response is flushed so a slow SMTP round-trip never holds the
            // submitter's request open. Matches CustomerRegistrationService::sendInvite;
            // afterResponse rather than ->queue() because there is no queue worker.
            dispatch(function () use ($email, $name, $contactInfo, $branches, $emailBody) {
                try {
                    Mail::to($email)->send(
                        new ContactConfirmationMail($name ?? '', $contactInfo, $branches, $emailBody)
                    );
                } catch (\Throwable $e) {
                    Log::warning('Contact confirmation email failed: ' . $e->getMessage());
                }
            })->afterResponse();
        } catch (\Exception $e) {
            Log::warning('Contact confirmation email failed: ' . $e->getMessage());
        }
    }
}

