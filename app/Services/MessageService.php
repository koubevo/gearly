<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Enums\NotificationType;
use App\Jobs\ProcessNewMessageEmailNotification;
use App\Models\Message;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    /**
     * Initializes a new instance of the MessageService class.
     */
    public function __construct()
    {
        //
    }

    /**
     * Creates and persists a new message associated with the given offer.
     *
     * @param Offer $offer The offer to which the message is linked.
     * @param int $sellerId The ID of the seller involved in the offer.
     * @param int|null $buyerId The ID of the buyer, or null if not applicable.
     * @param int $authorId The ID of the user authoring the message.
     * @param int $receiverId The ID of the user receiving the message.
     * @param MessageType $type The type of the message.
     * @param string $message The message content in English.
     * @param string|null $messageCs The message content in Czech, or null if not provided.
     * @param int|null $stars The star rating for the message, or null if not applicable.
     * @return Message The newly created message instance.
     */
    private function createMessage(
        Offer $offer,
        int $sellerId,
        int|null $buyerId,
        int $authorId,
        int $receiverId,
        MessageType $type,
        string $message,
        string|null $messageCs = null,
        int|null $stars = null
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
            'stars' => $stars
        ]);
    }

    /**
     * Creates and returns a normal type message associated with the given offer.
     *
     * @param Offer $offer The offer to which the message is linked.
     * @param int $sellerId The ID of the seller.
     * @param int $buyerId The ID of the buyer.
     * @param int $authorId The ID of the message author.
     * @param int $receiverId The ID of the message receiver.
     * @param string $message The message content.
     * @return Message The created normal message instance.
     */
    private function createNormalMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId,
        string $message
    ): Message {
        return $this->createMessage(
            $offer,
            $sellerId,
            $buyerId,
            $authorId,
            $receiverId,
            MessageType::Normal,
            $message,
            null
        );
    }

    /**
     * Creates a "sold" type message for an offer, including localized English and Czech texts with the buyer's name.
     *
     * @param Offer $offer The offer associated with the message.
     * @param int $sellerId The ID of the seller.
     * @param int $buyerId The ID of the buyer.
     * @param int $authorId The ID of the message author.
     * @param int $receiverId The ID of the message receiver.
     * @param string $buyerName The name of the buyer to include in the message.
     * @return Message The created "sold" message instance.
     */
    private function createSoldMessage(
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

    /**
     * Creates and returns a "received" type message for the specified offer, with localized English and Czech texts.
     *
     * @param Offer $offer The offer associated with the message.
     * @param int $sellerId The ID of the seller.
     * @param int $buyerId The ID of the buyer.
     * @param int $authorId The ID of the message author.
     * @param int $receiverId The ID of the message receiver.
     * @return Message The created "received" message instance.
     */
    private function createReceivedMessage(
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

    /**
     * Creates a cancelled type message for an offer with localized English and Czech texts.
     *
     * @param Offer $offer The offer associated with the cancelled message.
     * @param int $sellerId The ID of the seller.
     * @param int $buyerId The ID of the buyer.
     * @param int $authorId The ID of the message author.
     * @param int $receiverId The ID of the message receiver.
     * @return Message The created cancelled message instance.
     */
    private function createCancelledMessage(
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

    /**
     * Creates and returns a rating message associated with the given offer, including localized text and star rating.
     *
     * @param Offer $offer The offer to associate the message with.
     * @param int $sellerId The ID of the seller.
     * @param int $buyerId The ID of the buyer.
     * @param int $authorId The ID of the message author.
     * @param int $receiverId The ID of the user being rated.
     * @param int $stars The number of stars given in the rating.
     * @return Message The created rating message instance.
     */
    private function createRatingMessage(
        Offer $offer,
        int $sellerId,
        int $buyerId,
        int $authorId,
        int $receiverId,
        int $stars
    ): Message {
        return $this->createMessage(
            $offer,
            $sellerId,
            $buyerId,
            $authorId,
            $receiverId,
            MessageType::Rating,
            __('messages.rating_message', ['user' => User::find($authorId)->name, 'ratedUser' => User::find($receiverId)->name, 'stars' => $stars], 'en'),
            __('messages.rating_message', ['user' => User::find($authorId)->name, 'ratedUser' => User::find($receiverId)->name, 'stars' => $stars], 'cs'),
            $stars
        );
    }

    /**
     * Broadcasts a message sent event for real-time delivery.
     *
     * @param Message $message The message instance to broadcast.
     */
    private function sendMessage(Message $message): void
    {
        broadcast(new \App\Events\MessageSent($message));
    }

    /**
     * Creates and sends an action-specific message related to an offer, such as sold, received, cancelled, or rating.
     *
     * Depending on the provided message type, generates the appropriate message, optionally triggers a notification, and broadcasts the message event.
     *
     * @param Offer $offer The offer associated with the message.
     * @param MessageType $messageType The type of action message to send.
     * @param int|null $buyerId Optional buyer ID, required for certain message types.
     * @param int|null $ratedUserId Optional user ID being rated, used for rating messages.
     * @param int|null $stars Optional star rating, used for rating messages.
     * @throws \Exception If the message type is unsupported.
     */
    public function sendActionMessage(Offer $offer, MessageType $messageType, ?int $buyerId = null, ?int $ratedUserId = null, ?int $stars = null): void
    {
        // create message
        switch ($messageType) {
            case MessageType::Sold:
                $notificationType = NotificationType::Sold;
                $message = $this->createSoldMessage(
                    $offer,
                    $offer->seller->id,
                    $offer->buyer->id,
                    Auth::user()->id,
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
                    Auth::user()->id,
                    $offer->seller->id
                );
                break;
            case MessageType::Cancelled:
                $message = $this->createCancelledMessage(
                    $offer,
                    $offer->seller->id,
                    $buyerId,
                    Auth::user()->id,
                    $buyerId
                );
                break;
            case MessageType::Rating:
                $notificationType = NotificationType::Rating;
                $message = $this->createRatingMessage(
                    $offer,
                    $offer->seller->id,
                    $offer->buyer->id,
                    Auth::user()->id,
                    $ratedUserId,
                    $stars
                );
                break;
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

    /**
     * Creates and sends a normal chat message for the given offer, then dispatches an email notification job.
     *
     * @param Offer $offer The offer associated with the message.
     * @param User $user The author of the message.
     * @param User $buyer The buyer involved in the offer.
     * @param int $receiverId The ID of the message recipient.
     * @param string $messageText The content of the message.
     */
    public function sendNormalMessage(Offer $offer, User $user, User $buyer, int $receiverId, string $messageText): void
    {
        $message = $this->createNormalMessage(
            $offer,
            $offer->seller->id,
            $buyer->id,
            $user->id,
            $receiverId,
            $messageText
        );

        $this->sendMessage($message);

        ProcessNewMessageEmailNotification::dispatch($message, $user, $offer, $buyer);
    }
}
