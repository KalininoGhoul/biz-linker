<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Chat
 */
class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'my_id' => auth()->id(),
            'members' => ChatMemberListResource::collection($this->members),
            'pinned_messages' => MessageListResource::collection($this->pinnedMessages),
            'messages' => MessageListResource::collection($this->messages),
        ];
    }
}
