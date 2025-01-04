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
            'receiver' => [
                'id' => $this->members->first()->id,
                'name' => $this->members->first()->name,
            ],
            'last_message' => $this->lastMessage->first() ? [
                'sender' => [
                    'id' => $this->lastMessage->first()->id,
                    'name' => $this->lastMessage->first()->sender->name,
                ],
                'message' => $this->lastMessage->first()->message,
            ] : null,
        ];
    }
}
