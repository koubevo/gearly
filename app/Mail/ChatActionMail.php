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

    /**
     * Initializes a new ChatActionMail instance with sender, offer, chat URL, and notification type.
     *
     * @param string $senderName The name of the user who initiated the chat action.
     * @param string $offerName The name of the offer related to the chat action.
     * @param string $chatUrl The URL to the chat conversation.
     * @param NotificationType $notificationType The type of notification to be sent.
     */
    public function __construct(string $senderName, string $offerName, string $chatUrl, NotificationType $notificationType)
    {
        $this->senderName = $senderName;
        $this->offerName = $offerName;
        $this->chatUrl = $chatUrl;
        $this->notificationType = $notificationType;
    }

    /**
     * Creates an email envelope with a subject based on the notification type.
     *
     * @return Envelope The envelope containing the subject line for the email.
     */
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

    /**
     * Returns the email content configuration based on the notification type.
     *
     * Selects the appropriate Blade view template for the email according to the notification type (sold, received, or rating).
     *
     * @return Content The content object specifying the email view template.
     */
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