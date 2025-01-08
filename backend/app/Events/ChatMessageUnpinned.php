<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Organization;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageUnpinned implements ShouldBroadcast
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
            'message_id' => $this->message->id,
        ];
    }
}
