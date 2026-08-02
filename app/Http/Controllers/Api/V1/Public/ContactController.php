<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactConfirmationMail;
use App\Models\ContactInformation;
use App\Models\ContactUs;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * App-only mirror of App\Http\Controllers\ContactController::store - same validation,
 * spam filter, and ContactUs persistence, but always JSON (the web version replies
 * with a redirect unless the client sends an Accept: application/json header, which
 * a mobile client can't rely on). Honeypot/time-trap are web-form-only concerns
 * (there's no HTML form here); route throttle stands in for anti-spam instead.
 */
class ContactController extends Controller
{
    public function store(Request $request)
    {
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

        return response()->json([
            'success' => true,
            'message' => app()->getLocale() == 'en'
                ? 'Your message has been sent successfully! We will contact you soon.'
                : 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.',
        ]);
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
            Log::warning('Contact confirmation email failed (API): '.$e->getMessage());
        }
    }
}
