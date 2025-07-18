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
        // change offer status
        $offer->buyer_id = $request->buyer['id'];
        $offer->status = StatusEnum::Sold;
        $offer->save();

        // send message
        $this->messageService->sendActionMessage($offer, MessageType::Sold);
    }
}
