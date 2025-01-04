<?php

namespace App\Http\Requests\Auth;

use App\Models\Organization;
use App\Rules\InnIsValid;
use App\Services\Organization\Dto\OrganizationDto;
use App\Services\Organization\OrganizationFinder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class OrganizationRegisterRequest extends FormRequest
{
    public ?OrganizationDto $organizationDto = null;

    public function rules(): array
    {
        return [
            'inn' => ['required', Rule::unique(Organization::class, 'inn'), new InnIsValid($this->organizationDto)],

            'password' => Password::min(6)
                ->numbers()
                ->mixedCase()
                ->uncompromised(),
        ];
    }

    public function messages(): array
    {
        return [
            'inn.unique' => trans('auth.organization_already_registered'),
        ];
    }

    protected function prepareForValidation(): void
    {
        /** @var OrganizationFinder $organizationFinder */
        $organizationFinder = app(OrganizationFinder::class);

        $this->organizationDto = $organizationFinder->findByInn($this->input('inn'));
    }
}
