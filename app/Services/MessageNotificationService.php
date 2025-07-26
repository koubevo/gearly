<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\EmailLog;
use App\Mail\NewMessageMail;
use App\Mail\ChatActionMail;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Offer;
use Notification;

class MessageNotificationService
{
    /**
     * Sends a new message email notification to the receiver if enabled and not recently sent.
     *
     * Checks if the receiver has enabled new message notifications and ensures that a similar notification has not been sent within the last 5 minutes. If eligible, sends an email about the new message and logs the notification to prevent duplicates.
     *
     * @param Message $message The message triggering the notification.
     * @param User $user The sender of the message.
     * @param Offer $offer The related offer.
     * @param User $buyer The buyer involved in the chat.
     */
    public static function notifyNewMessage(Message $message, User $user, Offer $offer, User $buyer): void
    {
        if ($message->receiver->notifications_new_message) {
            $alreadySent = EmailLog::where('sender_id', $user->id)
                ->where('receiver_id', $message->receiver->id)
                ->where('offer_id', $offer->id)
                ->where('type', NotificationType::Normal->value)
                ->where('sent_at', '>=', now()->subMinutes(5))
                ->exists();

            if (!$alreadySent) {
                Mail::to($message->receiver->email)->send(new NewMessageMail(
                    senderName: $user->name,
                    offerName: $offer->name,
                    chatUrl: route('chat.show', ['offer' => $offer->id, 'buyer' => $buyer->id]),
                    messageText: $message->message,
                ));

                EmailLog::create([
                    'receiver_id' => $message->receiver->id,
                    'sender_id' => $user->id,
                    'offer_id' => $offer->id,
                    'type' => NotificationType::Normal->value,
                    'sent_at' => now(),
                ]);
            }
        }
    }

    /**
     * Sends a chat action email notification to the message receiver if a similar notification has not been sent within the last 5 minutes.
     *
     * Prevents duplicate notifications by checking recent logs, and records the notification after sending.
     *
     * @param \App\Models\Message $message The message instance related to the chat action.
     * @param \App\Models\Offer $offer The offer associated with the chat.
     * @param \App\Models\User $buyer The buyer involved in the chat.
     * @param NotificationType $notificationType The type of chat action notification to send.
     */
    public static function notifyChatAction(Message $message, Offer $offer, User $buyer, NotificationType $notificationType): void
    {
        $alreadySent = EmailLog::where('sender_id', $message->author->id)
            ->where('receiver_id', $message->receiver->id)
            ->where('offer_id', $offer->id)
            ->where('type', $notificationType->value)
            ->where('sent_at', '>=', now()->subMinutes(5))
            ->exists();

        if (!$alreadySent) {
            Mail::to($message->receiver->email)->send(new ChatActionMail(
                senderName: $message->author->name,
                offerName: $offer->name,
                chatUrl: route('chat.show', ['offer' => $offer->id, 'buyer' => $buyer->id]),
                notificationType: $notificationType
            ));

            EmailLog::create([
                'receiver_id' => $message->receiver->id,
                'sender_id' => $message->author->id,
                'offer_id' => $offer->id,
                'type' => $notificationType->value,
                'sent_at' => now(),
            ]);
        }
    }

}
