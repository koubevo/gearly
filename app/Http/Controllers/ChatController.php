<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Message;
use App\Models\Offer;
use App\Models\User;
use App\Services\RatingService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessNewMessageEmailNotification;
use App\Services\ChatService;
use App\ViewModels\ChatShowViewModel;

class ChatController extends Controller
{
    protected $chatService;
    protected $ratingService;
    protected $messageService;

    public function __construct(ChatService $chatService, RatingService $ratingService, MessageService $messageService)
    {
        $this->chatService = $chatService;
        $this->ratingService = $ratingService;
        $this->messageService = $messageService;
    }

    public function index()
    {
        return inertia('Chat/Index', [
            'chats' => $this->chatService->getChats(),
        ]);
    }

    public function show(Offer $offer, User $buyer)
    {
        //TODO: policy
        $user = Auth::user();
        $langColumn = LanguageHelper::getLangColumn();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, __('messages.offer_create_not_allowed'));
        }

        $messagesCount = $this->chatService->getMessagesCount($offer, $buyer);

        // If there are no messages and the user is the seller, he is not allowed to access the chat
        if ($messagesCount == 0 && $user->id == $offer->user_id) {
            abort(403, __('messages.offer_create_not_allowed'));
        }

        // If there are no messages and the user is the buyer, he is not allowed to access the chat if the offer is not active
        if ($messagesCount == 0 && $offer->status !== 1) {
            abort(403, __('messages.offer_create_not_allowed'));
        }

        $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');
        $offer->statusNumber = $offer->status;
        $offer->status = $offer->getStatusEnum()?->label();
        $offer->is_buyer = $buyer->id === $user->id;
        $offer->delivery_option_name = $offer->deliveryOption->$langColumn;

        $this->chatService->markAsRead($offer, $buyer);

        return inertia('Chat/Show', ChatShowViewModel::data(
            $offer,
            $buyer,
            $user,
            $this->chatService,
            $this->ratingService
        ));
    }

    public function loadMessages(Offer $offer, User $buyer)
    {
        $user = Auth::user();

        //TODO: policy
        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, __('messages.offer_create_not_allowed'));
        }

        $messages = $this->chatService->getMessages($offer, $user, $buyer);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, Offer $offer, User $buyer)
    {
        $user = Auth::user();
        $receiver_id = $user->id == $buyer->id ? $offer->user_id : $buyer->id;

        //TODO: policy
        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, __('messages.offer_create_not_allowed'));
        }

        $this->messageService->sendNormalMessage(
            $offer,
            $user,
            $buyer,
            $receiver_id,
            $request->validate([
                'message' => 'required|string|max:255',
            ])['message']
        );
    }

    public function unreadChatsCount()
    {
        $user = Auth::user();

        $unreadChatsCount = $this->chatService->getUnreadChatsCount($user);

        return response()->json([
            'unreadChatsCount' => $unreadChatsCount,
        ]);
    }
}
