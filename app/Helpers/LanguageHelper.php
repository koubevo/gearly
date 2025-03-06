<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class LanguageHelper
{
    public static function getLangColumn(): string
    {
        $user = Auth::user();
        $languages = array_keys(config('app.languages'));

        return $user?->lang === 'en' ? 'name' : ($user?->lang ?? (in_array(app()->getLocale(), $languages) ? app()->getLocale() : 'name'));
    }

    public static function getLangColumnForMessages(): string
    {
        $user = Auth::user();
        $languages = array_keys(config('app.languages'));

        return $user?->lang === 'en' ? 'name' : ($user?->lang ?? (in_array(app()->getLocale(), $languages) ? app()->getLocale() : 'en'));
    }
}
