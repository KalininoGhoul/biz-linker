<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\ChatStoreRequest;
use App\Http\Resources\Chat\ChatListResource;
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use App\Models\Organization;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Чаты
 */
class ChatController extends Controller
{
    /** @var Organization|Authenticatable  */
    private Organization $organization;

    public function __construct(
        private AuthManager $authManager,
    )
    {
        $this->organization = $authManager->user();
    }

    /** Все чаты */
    public function index(): AnonymousResourceCollection
    {
        return ChatListResource::collection(
            $this->organization
                ->chats()
                ->with([
                    'members' => fn($q) => $q->whereNot('organization_id', $this->organization->id),
                    'lastMessage.sender'
                ])
                ->get()
        );
    }

    /** Создать чат. Если такой чат уже существует, то вернется он  */
    public function store(ChatStoreRequest $request): ChatListResource
    {
        $chat = Chat::query()
            ->whereRelation('members', 'organizations.id', $request->validated('receiver_id'))
            ->whereRelation('members', 'organizations.id', $this->organization->id)
            ->first();

        if (is_null($chat)) {
            $chat = Chat::query()->create();

            $chat->members()->attach([
                $request->validated('receiver_id'),
                $this->organization->id
            ]);
        }

        return new ChatListResource($chat);
    }

    /** Данные о чате */
    public function show(Chat $chat): ChatResource
    {
        return new ChatResource($chat);
    }

    /** Удаление */
    public function delete(Chat $chat): JsonResponse
    {
        $this->organization->chats()->findOrFail($chat->id)->delete();

        return new JsonResponse([
            'status' => true
        ]);
    }
}
