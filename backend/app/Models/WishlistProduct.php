<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $organization_id
 * @property string $product_name
 * @property int $count
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishlistProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishlistProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WishlistProduct query()
 * @property string $name
 * @mixin \Eloquent
 */
class WishlistProduct extends Model
{
    protected $table = 'wishlist_products';

    protected $guarded = ['id'];
}
