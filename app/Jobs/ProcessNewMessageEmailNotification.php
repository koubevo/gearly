<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Offer;
use App\Models\Message;
use App\Services\MessageNotificationService;

class ProcessNewMessageEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Message $message,
        public User $user,
        public Offer $offer,
        public User $buyer,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        MessageNotificationService::notifyNewMessage(
            message: $this->message,
            user: $this->user,
            offer: $this->offer,
            buyer: $this->buyer
        );
    }
}
