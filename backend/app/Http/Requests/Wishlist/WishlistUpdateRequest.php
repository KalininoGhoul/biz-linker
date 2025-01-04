<?php

namespace App\Http\Requests\Wishlist;

use App\Http\Requests\ProductWithFileUrlRequest;
use App\Models\WishlistProduct;
use Illuminate\Validation\Rule;

class WishlistUpdateRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.id' => ['required', Rule::exists(WishlistProduct::class, 'id')],
            'products.*.name' => ['sometimes', 'required'],
            'products.*.count' => ['sometimes', 'required', 'integer', 'min:1'],
            'products.*.price' => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
