<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Organization> $members
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $lastMessage
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Chat withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $pinnedMessages
 * @mixin \Eloquent
 */
class Chat extends Model
{
    use SoftDeletes;

    protected $table = 'chats';

    protected $guarded = ['id'];

    public function resolveRouteBinding($value, $field = null): self
    {
        /** @var Organization $organization */
        $organization = auth()->user();

        return $organization->chats()->findOrFail($value);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function pinnedMessages(): HasMany
    {
        return $this->messages()->where('pinned', true);
    }

    public function lastMessage(): HasMany
    {
        return $this->messages()->latest('id')->take(1);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'chat_organization', 'chat_id', 'organization_id');
    }
}
