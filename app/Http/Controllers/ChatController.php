<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return inertia('Chat/Index');
    }

    public function show(User $user)
    {
        return inertia('Chat/Show', [
            'receiver' => $user,
        ]);
    }
}
