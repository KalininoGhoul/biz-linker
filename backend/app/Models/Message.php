<?php

namespace App\Models;

use App\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property-read \App\Models\Organization|null $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|Message forOrganization(\App\Models\Organization $organization)
 * @property int $chat_id
 * @property-read \App\Models\Chat|null $chat
 * @property bool $pinned
 * @property MessageStatus $status
 * @mixin \Eloquent
 */
class Message extends Model
{
    protected $table = 'messages';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => MessageStatus::class,
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'sender_id');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
