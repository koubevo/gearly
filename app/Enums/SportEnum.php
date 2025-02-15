<?php

namespace App\Enums;

enum SportEnum: int
{
    case Both = 1;
    case Baseball = 2;
    case Softball = 3;

    public function label(): string
    {
        return match ($this) {
            self::Both => 'Both (Baseball & Softball)',
            self::Baseball => 'Baseball',
            self::Softball => 'Softball',
        };
    }
}