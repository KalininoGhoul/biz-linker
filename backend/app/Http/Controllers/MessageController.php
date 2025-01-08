<?php

namespace App\Http\Controllers;

use App\Enums\MessageStatus;
use App\Events\ChatMessageDelivered;
use App\Events\ChatMessagePinned;
use App\Events\ChatMessageSent;
use App\Events\ChatMessageUnpinned;
use App\Http\Requests\Chat\MessageDeliveredRequest;
use App\Http\Requests\Chat\PinMessageRequest;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Http\Requests\Chat\UnpinMessageRequest;
use App\Http\Resources\Chat\MessageListResource;
use App\Models\Chat;
use App\Models\Message;
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
    public function sendMessage(SendMessageRequest $request, Chat $chat): MessageListResource
    {
        /** @var Message $message */
        $message = $chat->messages()->create([
            'sender_id' => $this->organization->id,
            'message' => $request->validated('message'),
            'status' => MessageStatus::SENT,
            'pinned' => false,
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return new MessageListResource($message);
    }

    /** Закрепить сообщение */
    public function pinMessage(PinMessageRequest $request, Chat $chat): JsonResponse
    {
        $request->message->update(['pinned' => true]);

        broadcast(new ChatMessagePinned($request->message))->toOthers();

        return new JsonResponse([
            'status' => true,
        ]);
    }

    /** Открепить сообщение */
    public function unpinMessage(UnpinMessageRequest $request, Chat $chat): JsonResponse
    {
        $request->message->update(['pinned' => false]);

        broadcast(new ChatMessageUnpinned($request->message))->toOthers();

        return new JsonResponse([
            'status' => true,
        ]);
    }

    /** Доставлено */
    public function delivered(MessageDeliveredRequest $request, Chat $chat): JsonResponse
    {
        $request->message->update(['status' => MessageStatus::DELIVERED]);

        broadcast(new ChatMessageDelivered($request->message))->toOthers();

        return new JsonResponse([
            'status' => true,
        ]);
    }
}
