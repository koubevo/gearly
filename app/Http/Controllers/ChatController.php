<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return inertia('Chat/Index');
    }

    public function show(Offer $offer, Request $request, User $buyer = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        //TODO: zkontrolovat
        if (!$buyer && $user->id !== $offer->user_id) {
            $buyer = $user;
        } else if (!$buyer) {
            return redirect()->route('chat.index');
        } else if ($buyer->id === $user->id) {
            return redirect()->route('chat.index');
        }

        $offer->thumbnail_url = $offer->getFirstMediaUrl('images', 'thumb');

        return inertia('Chat/Show', [
            'seller' => $offer->seller,
            'buyer' => $buyer,
            'offer' => $offer,
            'thumbnail_url' => $offer->thumbnail_url,
        ]);
    }

}
