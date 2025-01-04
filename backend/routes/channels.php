<?php

use App\Broadcasting\ChatChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chats.{chatId}.{organizationId}', ChatChannel::class);
