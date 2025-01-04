<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Chat;
use App\Models\Organization;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

/**
 * @tags Чаты
 */
class MessageController extends Controller
{
    /** @var Organization|Authenticatable  */
    private Organization $organization;

    public function __construct(
        private AuthManager $authManager,
    )
    {
        $this->organization = $authManager->user();
    }

    /** Отправить сообщение */
    public function sendMessage(SendMessageRequest $request, Chat $chat): JsonResponse
    {
        $message = $chat->messages()->create([
            'sender_id' => $this->organization->id,
            'message' => $request->validated('message'),
        ]);

        broadcast(new ChatMessageSent($message));

        return new JsonResponse([
            'status' => true,
        ]);
    }
}
