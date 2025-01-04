<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $inn
 * @property string $password
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $wishlistProducts
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chat> $chats
 * @mixin \Eloquent
 */
class Organization extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $table = 'organizations';

    protected $guarded = ['id'];

    protected string $guard_name = 'web';

    protected $casts = [
        'password' => 'hashed'
    ];

    public function wishlistProducts(): HasMany
    {
        return $this->hasMany(WishlistProduct::class, 'organization_id');
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_organization', 'organization_id', 'chat_id');
    }
}
