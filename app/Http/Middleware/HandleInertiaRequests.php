<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $unreadChatsCount = Message::where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->whereHas('offer', function ($query) {
                $query->whereIn('status', [1, 2, 3]);
            })
            ->selectRaw('offer_id, buyer_id')
            ->groupBy('offer_id', 'buyer_id')
            ->get()
            ->count();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'restart' => $request->session()->get('restart') ?? false
            ],
            'notifications' => [
                'unreadChatsCount' => $unreadChatsCount,
            ]
        ];
    }
}
