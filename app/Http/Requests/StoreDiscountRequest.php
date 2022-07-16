<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:64',
            'percentage' => 'required|integer|min:1|max:15',
            'start_date' => 'date|after_or_equal:today',
            'end_date' => 'date|after_or_equal:start_date',
            'products' => 'required|array',
            'products.*.id' => ['required', 'exists:products,id'],
        ];
    }
}
