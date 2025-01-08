<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Organization;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessagePinned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message,
    )
    {
    }

    public function broadcastOn(): array
    {
        return $this->message
            ->chat
            ->members()
            ->whereNot('organization_id', auth()->id())
            ->get()
            ->map(fn(Organization $organization) =>
                new PrivateChannel(sprintf('chats.%s', $organization->id))
            )
            ->toArray();
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->message->chat_id,
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
            'message' => [
                'id' => $this->message->id,
                'message' => $this->message->message,
                'pinned' => $this->message->pinned,
                'status' => $this->message->status,
            ],
            'date' => $this->message->created_at,
        ];
    }
}
