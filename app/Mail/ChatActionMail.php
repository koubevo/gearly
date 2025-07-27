<?php

namespace App\Mail;

use App\Enums\NotificationType;
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
    public NotificationType $notificationType;

    public function __construct(string $senderName, string $offerName, string $chatUrl, NotificationType $notificationType)
    {
        $this->senderName = $senderName;
        $this->offerName = $offerName;
        $this->chatUrl = $chatUrl;
        $this->notificationType = $notificationType;
    }

    public function envelope(): Envelope
    {
        // TODO: translation
        $subject = match ($this->notificationType) {
            NotificationType::Sold => 'Byla ti prodána nabídka!',
            NotificationType::Received => 'Tvoje nabídka byla vyzvednuta!',
            NotificationType::Rating => 'Někdo ti udělil hodnocení!',
        };

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        $view = match ($this->notificationType) {
            NotificationType::Sold => 'emails.notifications.sold_offer_html',
            NotificationType::Received => 'emails.notifications.received_offer_html',
            NotificationType::Rating => 'emails.notifications.rating_html',
        };

        return new Content(view: $view);
    }


    public function attachments(): array
    {
        return [];
    }
}