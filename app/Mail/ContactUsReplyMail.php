<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailBody;
    public $recipientName;
    public $originalSubject;
    public $attachmentFiles;
    public $attachmentNames;
    public $externalLinks;

    public function __construct(
        string $subject,
        string $body,
        string $recipientName,
        string $originalSubject,
        array $attachmentFiles = [],
        array $attachmentNames = [],
        array $externalLinks = []
    ) {
        $this->emailSubject = $subject;
        $this->emailBody = $body;
        $this->recipientName = $recipientName;
        $this->originalSubject = $originalSubject;
        $this->attachmentFiles = $attachmentFiles;
        $this->attachmentNames = $attachmentNames;
        $this->externalLinks = $externalLinks;
    }

    public function build()
    {
        $mail = $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject($this->emailSubject)
                    ->view('emails.contact-us-reply')
                    ->with([
                        'emailSubject' => $this->emailSubject,
                        'emailBody' => $this->emailBody,
                        'recipientName' => $this->recipientName,
                        'originalSubject' => $this->originalSubject,
                        'attachmentNames' => $this->attachmentNames,
                        'externalLinks' => $this->externalLinks,
                        'subject' => $this->emailSubject,
                    ]);

        foreach ($this->attachmentFiles as $index => $path) {
            if (file_exists($path)) {
                $name = $this->attachmentNames[$index] ?? basename($path);
                $mail->attach($path, ['as' => $name]);
            }
        }

        return $mail;
    }
}
