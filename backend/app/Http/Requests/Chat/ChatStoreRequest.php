<?php

namespace App\Http\Requests\Chat;

use App\Http\Requests\ProductWithFileUrlRequest;
use App\Models\Organization;
use Illuminate\Validation\Rule;

class ChatStoreRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'receiver_id' => ['required', Rule::exists(Organization::class, 'id')],
        ];
    }
}
