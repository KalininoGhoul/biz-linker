<?php

namespace App\Http\Requests\Organization;

use App\Http\Requests\ProductWithFileUrlRequest;
use Illuminate\Validation\Rules\File;

class OrganizationProductsRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
