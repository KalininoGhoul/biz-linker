<?php

namespace App\Broadcasting;

use App\Models\Organization;

class ChatChannel
{
    public function __construct()
    {
    }

    public function join(Organization $organization): array|bool
    {
        return $organization->id === auth()->id();
    }
}
