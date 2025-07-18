<?php

namespace App\Enums;

enum NotificationType: int
{
    case Normal = 1;
    case Sold = 5;
    case Received = 6;
    case Rating = 7;

    public function label(): string
    {
        return match ($this) {
            self::NewMessage => 'New Message',
            self::Sold => 'Sell Offer',
            self::Received => 'Receive Offer',
            self::Rating => 'Rating',
        };
    }
}
