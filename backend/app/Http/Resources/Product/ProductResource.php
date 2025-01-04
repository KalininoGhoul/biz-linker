<?php

namespace App\Http\Resources\Product;

use App\Models\Organization;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => fileUrl($this->image),
            'price' => $this->price,
            'count' => $this->count,
        ];
    }
}
