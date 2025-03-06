<?php

namespace App\Enums;

use App\Helpers\LanguageHelper;

enum SportEnum: int
{
    case Both = 1;
    case Baseball = 2;
    case Softball = 3;

    public function label(): string
    {
        $langColumn = LanguageHelper::getLangColumn();

        switch ($langColumn) {
            case 'cs':
                $message = 'Oboje';
                break;
            default:
                $message = 'Both';
                break;
        }

        $message .= ' (Baseball & Softball)';

        return match ($this) {
            self::Both => $message,
            self::Baseball => 'Baseball',
            self::Softball => 'Softball',
        };
    }
}