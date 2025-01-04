<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @mixin \Eloquent
 */
class Chat extends Model
{
    protected $table = 'chats';

    protected $guarded = ['id'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id')->orderBy('id');
    }

    public function lastMessage(): HasMany
    {
        return $this->messages()->latest('id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'chat_organization', 'chat_id', 'organization_id');
    }
}
