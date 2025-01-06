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
            'name' => ['sometimes', 'required'],
            'count' => ['sometimes', 'required', 'integer', 'min:1'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
