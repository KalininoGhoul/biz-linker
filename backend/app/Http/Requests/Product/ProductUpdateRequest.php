<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ProductWithFileUrlRequest;
use Illuminate\Validation\Rules\File;

class ProductUpdateRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'count' => ['sometimes', 'required', 'integer', 'min:1'],
            'description' => ['sometimes', 'required', 'string'],
            'image' => ['sometimes', 'required', File::image()->max($this->maxFileSize)],
            'image_url' => ['sometimes', 'required', 'url:http,https'],
            'price' => ['sometimes', 'required', 'numeric', 'min:1'],
        ];
    }
}
