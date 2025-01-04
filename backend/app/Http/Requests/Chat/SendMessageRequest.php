<?php

namespace App\Http\Requests\Chat;

use App\Http\Requests\ProductWithFileUrlRequest;

class SendMessageRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'message' => ['required', 'string'],
        ];
    }
}
