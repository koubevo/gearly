<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ConditionEnum;
use App\Enums\SportEnum;
use Illuminate\Validation\Rules\Enum;

/**
 * @mixin \Illuminate\Http\Request
 */
class UpdateOfferRequest extends FormRequest
{
    /**
     * Checks if the authenticated user is authorized to update the specified offer.
     *
     * @return bool True if the user can update the offer; otherwise, false.
     */
    public function authorize(): bool
    {
        $offer = request()->route('offer');
        return request()->user()->can('update', $offer);
    }

    /**
     * Returns the validation rules for updating an offer.
     *
     * The rules enforce required fields, data types, value ranges, and enum constraints for offer attributes such as name, description, price, currency, condition, sport, category, brand, delivery option, and delivery detail.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> The validation rules for the request data.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:60',
            'description' => 'required|string|min:3|max:1000',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0|max:99999',
            'currency' => 'required|string|in:eur,czk',
            'condition' => ['required', new Enum(ConditionEnum::class)],
            'sport_id' => ['required', new Enum(SportEnum::class)],
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string|max:255',
        ];
    }

    /**
     * Normalizes the 'delivery_detail' input by converting null or 'null' values to an empty string before validation.
     */
    protected function prepareForValidation()
    {
        if (request()->has('delivery_detail') && (request()->input('delivery_detail') === 'null' || request()->input('delivery_detail') === null)) {
            request()->merge([
                'delivery_detail' => '',
            ]);
        }
    }
}
