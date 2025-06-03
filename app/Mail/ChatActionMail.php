<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $senderName;
    public string $offerName;
    public string $chatUrl;
    public int $actionType;

    public function __construct(string $senderName, string $offerName, string $chatUrl, int $actionType)
    {
        $this->senderName = $senderName;
        $this->offerName = $offerName;
        $this->chatUrl = $chatUrl;
        $this->actionType = $actionType;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->actionType) {
            5 => 'Byla ti prodána nabídka!',
            6 => 'Tvoje nabídka byla vyzvednuta!',
            7 => 'Dostal jsi hodnocení!',
        };

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        $view = match ($this->actionType) {
            5 => 'emails.notifications.sold_offer_html',
            6 => 'emails.notifications.received_offer_html',
            7 => 'emails.notifications.rating_html',
        };

        return new Content(view: $view);
    }


    public function attachments(): array
    {
        return [];
    }
}