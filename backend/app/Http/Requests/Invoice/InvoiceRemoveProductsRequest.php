<?php

namespace App\Http\Requests\Invoice;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRemoveProductsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products' => ['sometimes', 'required', 'array'],
            'products.*' => ['required', 'integer', Rule::exists(Product::class, 'id')],
        ];
    }
}
