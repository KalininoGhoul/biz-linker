<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Invoice
 */
class InvoiceListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'price_sum' => $this->productPriceSum(),
            'supplier' => new OrganizationResource($this->supplier),
            'customer' => new OrganizationResource($this->customer),
            'date' => $this->created_at,
        ];
    }
}
