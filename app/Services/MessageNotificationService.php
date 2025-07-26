<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\EmailLog;
use App\Mail\NewMessageMail;
use App\Mail\ChatActionMail;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Offer;

class MessageNotificationService
{
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
     * @param \App\Models\Message $message
     * @param \App\Models\User $user
     * @param \App\Models\Offer $offer
     * @param \App\Models\User $buyer
     * @param NotificationType $notificationType
     * @return void
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
