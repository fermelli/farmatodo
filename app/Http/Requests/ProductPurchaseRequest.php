<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPurchaseRequest extends FormRequest
{
    protected $redirect = '/purchases';

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
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.purchase_quantity' => ['required', 'min:1'],
        ];
    }
}
