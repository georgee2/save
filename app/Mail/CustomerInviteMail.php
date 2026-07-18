<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $token;
    public string $actionUrl;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->actionUrl = route('account.password.set', [
            'token' => $token,
            'email' => $user->email,
        ]);
    }

    public function build()
    {
        $locale = $this->user->preferred_locale ?: app()->getLocale();
        $subject = __('lang.email_invite_subject', [], $locale);

        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($subject)
                    ->view('emails.customer-invite')
                    ->with([
                        'recipientName' => $this->user->name,
                        'actionUrl' => $this->actionUrl,
                        'subject' => $subject,
                    ]);
    }
}
