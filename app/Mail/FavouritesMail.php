<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FavouritesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $grouped;
    public $shareUrl;
    public $recipientName;
    public $whatsapp;
    public $favouriteId;

    public function __construct(array $grouped, string $shareUrl, ?string $recipientName, ?string $whatsapp, ?string $favouriteId = null)
    {
        $this->grouped = $grouped;
        $this->shareUrl = $shareUrl;
        $this->recipientName = $recipientName;
        $this->whatsapp = $whatsapp;
        $this->favouriteId = $favouriteId;
    }

    public function build()
    {
        return $this->subject('Your Favourites - Smart Vision Engineering Consultant')
                    ->view('emails.favourites')
                    ->with([
                        'grouped' => $this->grouped,
                        'shareUrl' => $this->shareUrl,
                        'recipientName' => $this->recipientName,
                        'whatsapp' => $this->whatsapp,
                        'favouriteId' => $this->favouriteId,
                        'subject' => 'Your Favourites - Smart Vision Engineering Consultant',
                    ]);
    }
}
