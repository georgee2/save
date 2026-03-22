<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FavouritesDirectMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailBody;
    public $attachmentFiles;
    public $attachmentNames;

    public function __construct(string $subject, string $body, array $attachmentFiles = [], array $attachmentNames = [])
    {
        $this->emailSubject = $subject;
        $this->emailBody = $body;
        $this->attachmentFiles = $attachmentFiles;
        $this->attachmentNames = $attachmentNames;
    }

    public function build()
    {
        $mail = $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                     ->subject($this->emailSubject)
                     ->view('emails.favourites-direct')
                     ->with([
                         'emailSubject' => $this->emailSubject,
                         'emailBody' => $this->emailBody,
                         'attachmentNames' => $this->attachmentNames,
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
