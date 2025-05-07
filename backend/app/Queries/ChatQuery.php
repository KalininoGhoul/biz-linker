<?php

namespace App\Queries;

use App\Models\Chat;
use App\Models\Organization;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ChatQuery
{
    public function getChatForOrganization(Organization $organization, int $receiverId): Chat
    {
        $chat = null;

        if ($organization->id === $receiverId) {
            $chat = Chat::query()
                ->whereRelation(
                    'members',
                    fn(Builder $q) => $q->whereIn('organizations.id', [$organization->id, $receiverId])
                )
                ->whereDoesntHave('members', fn(Builder $q) => $q->whereNotIn('organizations.id', [$organization->id, $receiverId]))
                ->first();
        } else {
            $chat = $organization
                ->chats()
                ->whereRelation('members', 'organizations.id', $receiverId)
                ->whereRelation('members', fn($q) => $q->whereNot('organizations.id', $organization->id))
                ->first();
        }

        if (is_null($chat)) {
            $chat = Chat::query()->create();

            $chat->members()->attach([
                $receiverId,
                $organization->id
            ]);
        }

        return $chat;
    }
}
