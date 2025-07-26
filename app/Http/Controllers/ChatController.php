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

    /**
     * Initializes the ChatController with required service dependencies.
     *
     * @param ChatService $chatService Service for chat-related operations.
     * @param RatingService $ratingService Service for handling ratings.
     * @param MessageService $messageService Service for managing messages.
     */
    public function __construct(ChatService $chatService, RatingService $ratingService, MessageService $messageService)
    {
        $this->chatService = $chatService;
        $this->ratingService = $ratingService;
        $this->messageService = $messageService;
    }

    /**
     * Displays the chat index page with a list of the user's chats.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia('Chat/Index', [
            'chats' => $this->chatService->getChats(),
        ]);
    }

    /**
     * Displays the chat view for a specific offer and buyer, enforcing access restrictions.
     *
     * Only the buyer or the offer's seller can access the chat. Access is denied if there are no messages and the user is the seller, or if there are no messages and the offer is not active. The method prepares offer details, marks the chat as read, and returns the chat view with relevant data.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $buyer The buyer involved in the chat.
     * @return \Inertia\Response The rendered chat view.
     */
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

    /**
     * Returns the messages for a chat between the authenticated user and the specified buyer for a given offer.
     *
     * Access is restricted to the buyer or the seller of the offer. Responds with a JSON object containing the chat messages.
     *
     * @param Offer $offer The offer associated with the chat.
     * @param User $buyer The buyer participating in the chat.
     * @return \Illuminate\Http\JsonResponse JSON response containing the chat messages.
     */
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

    /**
     * Sends a chat message from the authenticated user to the other participant in the offer's chat.
     *
     * Validates the message content and ensures that only the buyer or the offer's seller can send messages in the chat.
     *
     * @param Request $request The HTTP request containing the message content.
     * @param Offer $offer The offer associated with the chat.
     * @param User $buyer The buyer participating in the chat.
     */
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

    /**
     * Returns the number of unread chats for the authenticated user as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the unread chats count.
     */
    public function unreadChatsCount()
    {
        $user = Auth::user();

        $unreadChatsCount = $this->chatService->getUnreadChatsCount($user);

        return response()->json([
            'unreadChatsCount' => $unreadChatsCount,
        ]);
    }

    /**
     * Marks the chat between the specified offer and buyer as read.
     *
     * This updates the chat's read status for the given offer and buyer.
     */
    public function markAsRead(Offer $offer, User $buyer): void
    {
        $this->chatService->markAsRead($offer, $buyer);
    }
}
