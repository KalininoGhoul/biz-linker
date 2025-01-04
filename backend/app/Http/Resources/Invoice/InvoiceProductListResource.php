<?php

namespace App\Http\Resources\Invoice;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class InvoiceProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => fileUrl($this->image),
            'price' => $this->price,
            'count' => $this->pivot->count,
        ];
    }
}
