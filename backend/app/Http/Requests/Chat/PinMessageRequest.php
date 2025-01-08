<?php

namespace App\Http\Requests\Chat;

use App\Http\Requests\ProductWithFileUrlRequest;
use App\Models\Message;

class PinMessageRequest extends ProductWithFileUrlRequest
{
    public ?Message $message = null;

    public function rules(): array
    {
        return [
            'message' => [
                'required',

                'integer',

                function (string $attribute, int $messageId) {
                    $this->message = Message::query()
                        ->where('id', $messageId)
                        ->whereRelation('chat', 'chats.id', $this->route('chat')->id)
                        ->first();

                    return !is_null($this->message);
                },
            ],
        ];
    }
}
