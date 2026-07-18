<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerEmailChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $actionUrl;
    public string $newEmail;

    public function __construct(User $user, string $actionUrl, string $newEmail)
    {
        $this->user = $user;
        $this->actionUrl = $actionUrl;
        $this->newEmail = $newEmail;
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.email_change_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.customer-email-change')
                    ->with([
                        'recipientName' => $this->user->name,
                        'actionUrl' => $this->actionUrl,
                        'newEmail' => $this->newEmail,
                        'subject' => $subject,
                    ]);
    }
}
