<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Warns the CURRENT address that a change was requested. The new address gets the
 * confirmation link; this one gets told it is about to lose access.
 */
class EmailChangeAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $newEmail;

    public function __construct(User $user, string $newEmail)
    {
        $this->user = $user;
        $this->newEmail = $newEmail;
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.email_change_alert_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.email-change-alert')
                    ->with([
                        'recipientName' => $this->user->name,
                        'newEmail' => $this->newEmail,
                        'subject' => $subject,
                    ]);
    }
}
