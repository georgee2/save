<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FavouritesNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $grouped;
    public $shareUrl;
    public $recipientName;
    public $favouriteId;
    public $updateNote;

    public function __construct(array $grouped, string $shareUrl, ?string $recipientName, ?string $favouriteId, ?string $updateNote)
    {
        $this->grouped = $grouped;
        $this->shareUrl = $shareUrl;
        $this->recipientName = $recipientName;
        $this->favouriteId = $favouriteId;
        $this->updateNote = $updateNote;
    }

    public function build()
    {
        return $this->from('care@svec.ae', 'Smart Vision Engineering Consultant')
                    ->subject('Favourites Update - Smart Vision Engineering Consultant')
                    ->view('emails.favourites-notification')
                    ->with([
                        'grouped' => $this->grouped,
                        'shareUrl' => $this->shareUrl,
                        'recipientName' => $this->recipientName,
                        'favouriteId' => $this->favouriteId,
                        'updateNote' => $this->updateNote,
                        'subject' => 'Favourites Update - Smart Vision Engineering Consultant',
                    ]);
    }
}
