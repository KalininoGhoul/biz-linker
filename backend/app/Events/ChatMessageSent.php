<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Organization;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
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
                new PrivateChannel(sprintf('chats.%s.%s', $this->message->chat_id, $organization->id))
            )
            ->toArray();
    }

    public function broadcastWith(): array
    {
        return [
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
            'message' => $this->message->message,
            'date' => $this->message->created_at,
        ];
    }
}
