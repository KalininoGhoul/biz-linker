<?php

namespace App\Http\Requests\Invoice;

use App\Models\Organization;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'integer', Rule::exists(Organization::class, 'id')],
            'customer_id' => ['required', 'integer', Rule::exists(Organization::class, 'id')],

            'products' => ['sometimes', 'required', 'array'],
            'products.*.id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'products.*.count' => ['required', 'integer', 'min:1'],
        ];
    }
}
