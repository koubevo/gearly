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
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $offer = request()->route('offer');
        return request()->user()->can('update', $offer);
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
            +'price' => 'required|numeric|min:0|max:99999|regex:/^\d{1,5}(\.\d{1,2})?$/',
            'currency' => 'required|string|in:eur,czk',
            'condition' => ['required', new Enum(ConditionEnum::class)],
            'sport_id' => ['required', new Enum(SportEnum::class)],
            'category_id' => 'required|integer|min:1',
            'brand_id' => 'required|integer|min:1',
            'delivery_option_id' => 'required|integer|min:1',
            'delivery_detail' => 'nullable|string|max:255',
        ];

        //TODO try 
        /*foreach (\App\Models\FilterCategory::pluck('id') as $catId) {
            $rules["fc{$catId}"] = [
                'nullable',
                'integer',
                "exists:filter_categories,id",
                "exists:filters,id,filter_category_id,{$catId}",
            ];
        }*/

        return $rules;
    }

    protected function prepareForValidation()
    {
        if (request()->has('delivery_detail') && (request()->input('delivery_detail') === 'null' || request()->input('delivery_detail') === null)) {
            request()->merge([
                'delivery_detail' => '',
            ]);
        }
    }
}
