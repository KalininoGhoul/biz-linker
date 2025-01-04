<?php

namespace App\Http\Resources\WishlistProduct;

use App\Models\WishlistProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WishlistProduct
 */
class WishlistProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'count' => $this->count,
        ];
    }
}
