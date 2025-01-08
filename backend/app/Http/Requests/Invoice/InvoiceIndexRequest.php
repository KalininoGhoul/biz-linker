<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\ProductWithFileUrlRequest;
use Illuminate\Validation\Rules\File;

class InvoiceIndexRequest extends ProductWithFileUrlRequest
{
    public function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
