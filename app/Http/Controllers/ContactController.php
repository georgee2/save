<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactInformation;
use App\Models\ContactUs;
use App\Models\Service;
use App\Models\PageBanner;
use App\Support\FormGuard;
use App\Models\Partner;
use App\Models\AboutInformation;
use App\Models\ContactPageSection;
use App\Mail\ContactConfirmationMail;

class ContactController extends Controller
{
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

        // Layer 3: reCAPTCHA v3 verification (only if keys are configured)
        $recaptchaSecret = config('services.recaptcha.secret_key');
        if ($recaptchaSecret && $request->filled('g-recaptcha-response')) {
            if (!$this->verifyRecaptcha($request->input('g-recaptcha-response'), $recaptchaSecret)) {
                $errorMessage = app()->getLocale() == 'en'
                    ? 'Spam verification failed. Please try again.'
                    : 'فشل التحقق من البريد العشوائي. يرجى المحاولة مرة أخرى.';

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $errorMessage], 422);
                }
                return back()->withErrors(['recaptcha' => $errorMessage])->withInput();
            }
        }

        // Layer 4: Standard validation + content filtering
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
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
            'source' => 'nullable|string|max:50',
        ]);

        ContactUs::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'service_id' => $request->service_id,
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

            Mail::to($email)->send(
                new ContactConfirmationMail($name ?? '', $contactInfo, $branches, $emailBody)
            );
        } catch (\Exception $e) {
            Log::warning('Contact confirmation email failed: ' . $e->getMessage());
        }
    }

    private function verifyRecaptcha(string $token, string $secret): bool
    {
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $data = $response->json();
            $minScore = config('services.recaptcha.min_score', 0.5);

            return ($data['success'] ?? false) && ($data['score'] ?? 0) >= $minScore;
        } catch (\Exception $e) {
            Log::warning('reCAPTCHA verification failed: ' . $e->getMessage());
            return true;
        }
    }
}

