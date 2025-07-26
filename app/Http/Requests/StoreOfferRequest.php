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
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:60',
            'description' => 'required|string|min:3|max:1000',
            'price' => 'required|numeric|min:0|max:99999|decimal:0,2',
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

        $filterRules = [];
        foreach (array_keys(request()->input()) as $key) {
            if (str_starts_with($key, 'fc')) {
                $filterRules[$key] = 'nullable|integer';
            }
        }

        return array_merge($rules, $filterRules);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        //TODO translations
        return [
            'images.*.image' => 'Každý soubor musí být obrázek.',
            'images.*.max' => 'Maximální velikost obrázku je 5 MB.',
            'images.required' => 'Musíš nahrát alespoň jeden obrázek.',
        ];
    }
}