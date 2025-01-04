<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inn' => ['required'],
            'password' => ['required'],
        ];
    }
}
