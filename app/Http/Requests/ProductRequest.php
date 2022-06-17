<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric|between:0.001,99999.999',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'file|max:512|mimes:jpg,jpeg,png',
        ];
    }
}
