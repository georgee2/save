<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountLockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public int $minutes;

    public function __construct(User $user, int $minutes)
    {
        $this->user = $user;
        $this->minutes = $minutes;
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.email_account_locked_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.account-locked')
                    ->with([
                        'recipientName' => $this->user->name,
                        'minutes' => $this->minutes,
                        'resetUrl' => route('password.request'),
                        'subject' => $subject,
                    ]);
    }
}
