<?php

namespace App\Http\Resources\Chat;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 */
class MessageListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            'pinned' => $this->pinned,
            'status' => $this->status,
            'date' => $this->created_at,
        ];
    }
}
