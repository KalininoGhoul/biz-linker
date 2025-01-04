<?php

namespace App\Broadcasting;

use App\Models\Chat;
use App\Models\Organization;

class ChatChannel
{
    public function __construct()
    {
    }

    public function join(Organization $organization, string $chat): array|bool
    {
        $chat = Chat::query()->findOrFail($chat);

        return $organization->id === auth()->user()->id
            && $this->organizationInChat($chat, $organization);
    }

    private function organizationInChat(Chat $chat, Organization $organization): bool
    {
        return $chat->members()
            ->where('organizations.id', $organization->id)
            ->exists();
    }
}
