<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Enums\NotificationType;
use App\Models\Message;
use App\Models\Offer;
use App\Models\User;

class MessageService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    private function createMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId,
        MessageType $type,
        string $message,
        string $messageCs
    ): Message {
        return $offer->messages()->create([
            'seller_id' => $sellerId,
            'buyer_id' => $buyerId,
            'author_id' => $authorId,
            'receiver_id' => $receiverId,
            'offer_id' => $offer->id,
            'type_id' => $type,
            'message' => $message,
            'cs' => $messageCs,
        ]);
    }

    public function createSoldMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId,
        string $buyerName
    ): Message {
        return $this->createMessage(
            $offer,
            $sellerId,
            $buyerId,
            $authorId,
            $receiverId,
            MessageType::Sold,
            __('messages.sold_message', ['buyerName' => $buyerName], 'en'),
            __('messages.sold_message', ['buyerName' => $buyerName], 'cs')
        );
    }

    public function createReceivedMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId
    ): Message {
        return $this->createMessage(
            $offer,
            $sellerId,
            $buyerId,
            $authorId,
            $receiverId,
            MessageType::Received,
            __('messages.offer_received', locale: 'en'),
            __('messages.offer_received', locale: 'cs')
        );
    }

    public function createCancelledMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId
    ): Message {
        return $this->createMessage(
            $offer,
            $sellerId,
            $buyerId,
            $authorId,
            $receiverId,
            MessageType::Cancelled,
            __('messages.offer_cancelled', locale: 'en'),
            __('messages.offer_cancelled', locale: 'cs')
        );
    }

    private function sendMessage(Message $message): void
    {
        broadcast(new \App\Events\MessageSent($message));
    }

    public function sendActionMessage(Offer $offer, MessageType $messageType): void
    {
        // create message
        switch ($messageType) {
            case MessageType::Sold:
                $notificationType = NotificationType::Sold;
                $message = $this->createSoldMessage(
                    $offer,
                    $offer->seller->id,
                    $offer->buyer->id,
                    $offer->seller->id,
                    $offer->buyer->id,
                    $offer->buyer->name
                );
                break;
            case MessageType::Received:
                $notificationType = NotificationType::Received;
                $message = $this->createReceivedMessage(
                    $offer,
                    $offer->seller->id,
                    $offer->buyer->id,
                    $offer->buyer->id,
                    $offer->seller->id
                );
                break;
            case MessageType::Cancelled:
                $message = $this->createCancelledMessage(
                    $offer,
                    $offer->seller->id,
                    $offer->buyer->id,
                    $offer->buyer->id,
                    $offer->seller->id
                );
            default:
                throw new \Exception('Unsupported message type');
        }

        // notify
        if (isset($notificationType)) {
            MessageNotificationService::notifyChatAction(
                $message,
                $offer,
                $offer->buyer,
                $notificationType
            );
        }

        // send message
        $this->sendMessage($message);
    }

    public function sendNormalMessage(): void
    {

    }
}
