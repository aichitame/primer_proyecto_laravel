<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteLineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'=> ['required', 'exists:products,id'],
            'qty'=> ['required', 'integer', 'min:1'],
            'discount_rate'=> ['nullable', 'numeric', 'min:0'],
        ];
    }
}
