<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $token;
    public string $actionUrl;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->actionUrl = route('staff.password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.staff_email_reset_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.staff-password-reset')
                    ->with([
                        'recipientName' => $this->user->name,
                        'actionUrl' => $this->actionUrl,
                        'subject' => $subject,
                    ]);
    }
}
