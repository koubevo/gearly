<?php

namespace App\Notifications;

use App\Models\Message;
use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageSent extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Offer $offer,
        private Message $message
    ) {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'offer_id' => $this->offer->id,
            'offer_name' => $this->offer->name,
            'offer_status_number' => $this->offer->status,
            'offer_thumbnail_url' => $this->offer->getFirstMediaUrl('images', 'thumb'),
            'author_id' => $this->message->author_id,
            'author_name' => $this->message->author->name,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'message_time' => $this->message->created_at,
        ];
    }
}
