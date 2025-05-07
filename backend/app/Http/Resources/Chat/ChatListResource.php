<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Chat
 */
class ChatListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'receiver' => new ChatMemberListResource($this->members->first() ?? $request->user()),
            'last_message' => new LastMessageResource($this->lastMessage->first()),
        ];
    }
}
