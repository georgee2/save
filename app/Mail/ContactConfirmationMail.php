<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
    public $contactInfo;
    public $branches;
    public $emailBody;

    public function __construct(string $recipientName, $contactInfo, $branches, string $emailBody)
    {
        $this->recipientName = $recipientName;
        $this->contactInfo = $contactInfo;
        $this->branches = $branches;
        $this->emailBody = $emailBody;
    }

    public function build()
    {
        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject('Thank you for contacting us - SVEC')
                    ->view('emails.contact-confirmation')
                    ->with([
                        'recipientName' => $this->recipientName,
                        'contactInfo' => $this->contactInfo,
                        'branches' => $this->branches,
                        'emailBody' => $this->emailBody,
                        'whatsapp' => $this->contactInfo->whatsapp ?? null,
                        'subject' => 'Thank you for contacting us - SVEC',
                    ]);
    }
}
