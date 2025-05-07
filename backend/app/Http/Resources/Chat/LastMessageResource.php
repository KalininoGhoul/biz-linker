<?php

namespace App\Http\Resources\Chat;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 */
class LastMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sender' => new ChatMemberListResource($this->sender),
            'message' => $this->message,
            'date' => $this->created_at,
        ];
    }
}
