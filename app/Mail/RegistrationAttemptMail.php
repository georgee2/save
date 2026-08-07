<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Sent when someone tries to register with an address that already has an account.
 *
 * Registration used to answer that case with a validation error, which told the submitter
 * the address exists — and, from the wording, whether it was activated and whether it was
 * a staff account. The response is now identical to a successful signup and the fact is
 * delivered here instead, where only the address owner can read it.
 */
class RegistrationAttemptMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.email_registration_attempt_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.registration-attempt')
                    ->with([
                        'recipientName' => $this->user->name,
                        'loginUrl' => route('login'),
                        'resetUrl' => route('password.request'),
                        'subject' => $subject,
                    ]);
    }
}
