<?php

namespace App\Enums;

use App\Helpers\LanguageHelper;

enum StatusEnum: int
{
    case Active = 1;
    case Sold = 2;
    case Received = 3;
    case Draft = 4;
    case Deleted = 5;

    public function label(): string
    {
        $langColumn = LanguageHelper::getLangColumn();

        switch ($langColumn) {
            case 'cs':
                $active = 'Aktivní';
                $sold = 'Prodané';
                $received = 'Doručené';
                $draft = 'Návrh';
                $deleted = 'Smazáno';
                break;
            default:
                $active = 'Active';
                $sold = 'Sold';
                $received = 'Received';
                $draft = 'Draft';
                $deleted = 'Deleted';
                break;
        }

        return match ($this) {
            self::Active => $active,
            self::Sold => $sold,
            self::Received => $received,
            self::Draft => $draft,
            self::Deleted => $deleted,
        };
    }
}