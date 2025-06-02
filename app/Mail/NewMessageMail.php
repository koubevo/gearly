<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $senderName;
    public string $offerName;
    public string $chatUrl;
    public string $messageText;

    public function __construct(string $senderName, string $offerName, string $chatUrl, string $messageText)
    {
        $this->senderName = $senderName;
        $this->offerName = $offerName;
        $this->chatUrl = $chatUrl;
        $this->messageText = $messageText;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nová zpráva na Gearly!'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifications.new_message_html'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}