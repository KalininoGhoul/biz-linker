<?php

namespace App\Http\Requests\Wishlist;

use App\Http\Requests\ProductWithFileUrlRequest;

class WishlistStoreRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'count' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
