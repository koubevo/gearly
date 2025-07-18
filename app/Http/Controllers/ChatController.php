<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\Message;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessNewMessageEmailNotification;
use App\Services\ChatService;
use App\ViewModels\ChatShowViewModel;

class ChatController extends Controller
{
    protected $chatService;
    protected $ratingService;

    public function __construct(ChatService $chatService, RatingService $ratingService)
    {
        $this->chatService = $chatService;
        $this->ratingService = $ratingService;
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

        $this->markAsRead($offer, $buyer);

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
        $langColumn = LanguageHelper::getLangColumnForMessages();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $messages = $offer->messages()
            ->where(function ($query) use ($user) {
                $query->where('seller_id', $user->id)
                    ->orWhere('buyer_id', $user->id);
            })
            ->where('offer_id', $offer->id)
            ->where('buyer_id', $buyer->id)
            ->get()
            ->map(function ($message) use ($langColumn) {
                $message->created_at_formatted = $message->created_at->diffForHumans();
                if (!empty($message->$langColumn)) {
                    $message->message = $message->$langColumn;
                }
                return $message;
            });

        return response()->json([
            'messages' => $messages,
        ]);

    }

    public function sendMessage(Request $request, Offer $offer, User $buyer)
    {
        $user = Auth::user();
        $receiver_id = $user->id == $buyer->id ? $offer->user_id : $buyer->id;

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        $message = $offer->messages()->create([
            'seller_id' => $offer->user_id,
            'buyer_id' => $buyer->id,
            'author_id' => $user->id,
            'receiver_id' => $receiver_id,
            'offer_id' => $offer->id,
            'type_id' => $request->type_id,
            'message' => $request->validate([
                'message' => 'required|string|max:255',
            ])['message'],
        ]);

        /*$message->receiver->notify(
            new MessageSent($offer, $message)
        );*/

        broadcast(new \App\Events\MessageSent($message));

        ProcessNewMessageEmailNotification::dispatch($message, $user, $offer, $buyer);
    }

    public function markAsRead(Offer $offer, User $buyer)
    {
        $user = Auth::user();

        if (!($buyer->id === $user->id || $offer->user_id === $user->id)) {
            abort(403, 'You are not allowed to access this page.');
        }

        Message::where('offer_id', $offer->id)
            ->where('buyer_id', $buyer->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function unreadChatsCount()
    {
        $user = Auth::user();

        $unreadChatsCount = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->whereHas('offer', function ($query) {
                $query->whereIn('status', [1, 2, 3]);
            })
            ->selectRaw('offer_id, buyer_id')
            ->groupBy('offer_id', 'buyer_id')
            ->get()
            ->count();

        return response()->json([
            'unreadChatsCount' => $unreadChatsCount,
        ]);
    }
}
