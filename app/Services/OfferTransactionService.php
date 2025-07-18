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
     * Create a new class instance.
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function sellOffer(Request $request, Offer $offer): void
    {
        $offer->buyer_id = $request->buyer['id'];
        $offer->status = StatusEnum::Sold;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Sold);
    }

    public function receiveOffer(Offer $offer): void
    {
        $offer->status = StatusEnum::Received;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Received);
    }

    public function cancelOffer(Offer $offer): void
    {
        $offer->buyer_id = null;
        $offer->status = StatusEnum::Active;
        $offer->save();

        $this->messageService->sendActionMessage($offer, MessageType::Cancelled);
    }
}
