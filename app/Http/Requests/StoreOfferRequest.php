<?php

namespace App\Http\Requests;

use App\Enums\ConditionEnum;
use App\Enums\SportEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @mixin \Illuminate\Http\Request
 */
class StoreOfferRequest extends FormRequest
{
    /**
     * Allows all users to make this request.
     *
     * @return bool Always returns true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Returns the validation rules for storing an offer request.
     *
     * Defines validation constraints for offer fields such as name, description, price, currency, condition, sport, category, brand, delivery option, delivery details, and images. Also dynamically adds nullable integer validation for any input keys starting with "fc".
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> The array of validation rules for the request fields.
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:60',
            'description' => 'required|string|min:3|max:1000',
            'price' => 'required|numeric|min:0|max:99999|regex:/^\d{1,5}(\.\d{1,2})?$/',
            'currency' => 'required|string|in:eur,czk',
            'condition' => ['required', new Enum(ConditionEnum::class)],
            'sport_id' => ['required', new Enum(SportEnum::class)],
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:5120',
        ];

        $filterRules = collect(request()->input())
            ->filter(fn($value, $key) => str_starts_with($key, 'fc'))
            ->mapWithKeys(fn($value, $key) => [$key => 'nullable|integer'])
            ->toArray();

        return array_merge($rules, $filterRules);
    }

    /**
     * Returns custom error messages for image validation failures.
     *
     * @return array<string, string> An array mapping validation rule keys to custom error messages for image fields.
     */
    public function messages(): array
    {
        return [
            'images.*.image' => 'Každý soubor musí být obrázek.',
            'images.*.max' => 'Maximální velikost obrázku je 5 MB.',
            'images.required' => 'Musíš nahrát alespoň jeden obrázek.',
        ];
    }
}