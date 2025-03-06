<?php

namespace App\Enums;

use App\Helpers\LanguageHelper;

enum ConditionEnum: int
{
    case New = 1;
    case Used = 2;
    case Damaged = 3;

    public function label(): string
    {
        $langColumn = LanguageHelper::getLangColumn();

        switch ($langColumn) {
            case 'cs':
                $new = 'Nové';
                $used = 'Použité';
                $damaged = 'Poškozené';
                break;
            default:
                $new = 'New';
                $used = 'Used';
                $damaged = 'Damaged';
                break;
        }

        return match ($this) {
            self::New => $new,
            self::Used => $used,
            self::Damaged => $damaged,
        };
    }
}