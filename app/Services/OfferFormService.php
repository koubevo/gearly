<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryOption;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Support\Collection;

class OfferFormService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getBrands(): Collection
    {
        return Brand::select('id', 'name')->orderBy('name', 'asc')->get();
    }

    public function getDeliveryOptions(string $langColumn): Collection
    {
        return DeliveryOption::select('id', "$langColumn as name")->get();
    }

    public function getCategories(string $langColumn): Collection
    {
        return Category::with('filterCategories')
            ->select('id', "$langColumn as name", 'logo', 'created_at', 'updated_at')
            ->orderBy('name', 'asc')
            ->get();
    }

    private function getActiveOffersByUser(User $user): int
    {
        return $user->offers()->where('status', StatusEnum::Active->value)->count();
    }

    public function isOfferLimitExceeded(User $user): bool
    {
        return !$user->hasPremium() && $this->getActiveOffersByUser($user) >= Offer::MAX_FREE_ACTIVE_OFFERS;
    }

    public function getIndexCategories($langColumn): Collection
    {
        return Category::with([
            'filterCategories' => fn($q) => $q->select('filter_categories.id', "{$langColumn} as name")
        ])->select('id', "{$langColumn} as name")->orderBy($langColumn, 'asc')->get();
    }
}
