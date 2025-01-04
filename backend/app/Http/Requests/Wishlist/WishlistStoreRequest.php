<?php

namespace App\Http\Requests\Wishlist;

use App\Http\Requests\ProductWithFileUrlRequest;

class WishlistStoreRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'products' => ['required', 'array'],
            'products.*.name' => ['required'],
            'products.*.count' => ['required', 'integer', 'min:1'],
            'products.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
