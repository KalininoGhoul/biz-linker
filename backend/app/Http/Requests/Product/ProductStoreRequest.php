<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ProductWithFileUrlRequest;
use Illuminate\Validation\Rules\File;

class ProductStoreRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'count' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'image' => ['required_without:image_url', File::image()->max($this->maxFileSize)],
            'image_url' => ['required_without:image', 'url:http,https'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }
}
