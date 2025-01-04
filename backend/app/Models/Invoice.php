<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $customer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @property-read \App\Models\Organization|null $customer
 * @property-read \App\Models\Organization|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoices';

    protected $guarded = ['id'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'customer_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product', 'invoice_id', 'product_id')
            ->withPivot('count')
            ->orderByPivot('id');
    }

    public function productPriceSum(): float
    {
        return $this->products->sum(fn(Product $product) => $product->price * $product->pivot->count);
    }
}
