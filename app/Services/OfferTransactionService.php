<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Services\MessageService;

class OfferTransactionService
{

    protected $messageService;

    /**
     * Initializes the OfferTransactionService with a MessageService dependency.
     *
     * @param MessageService $messageService Service used to send offer-related messages.
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Marks the given offer as sold to the buyer specified in the request and sends a sold notification.
     *
     * Updates the offer's buyer ID and status to sold, persists the changes, and triggers a corresponding action message.
     */
    public function sellOffer(Request $request, Offer $offer): void
    {
        $offer->buyer_id = $request->buyer['id'];
        $offer->status = StatusEnum::Sold;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Sold);
    }

    /**
     * Marks the given offer as received and sends a corresponding notification.
     *
     * Updates the offer's status to "Received", persists the change, and triggers a "Received" action message.
     *
     * @param Offer $offer The offer to update.
     */
    public function receiveOffer(Offer $offer): void
    {
        $offer->status = StatusEnum::Received;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Received);
    }

    /**
     * Cancels an offer by resetting its buyer and status, then sends a cancellation message.
     *
     * The offer's buyer is cleared, its status is set to active, and the changes are saved. A cancellation message is sent, including the previous buyer's ID.
     */
    public function cancelOffer(Offer $offer): void
    {
        $buyerId = $offer->buyer_id;
        $offer->buyer_id = null;
        $offer->status = StatusEnum::Active;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Cancelled, $buyerId);
    }
}
