<?php

namespace App\Rules;

use App\Services\Organization\Dto\OrganizationDto;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InnIsValid implements ValidationRule
{
    public function __construct(
        private ?OrganizationDto $organizationDto,
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->organizationDto)) {
            $fail(trans('auth.organization_not_found'));
            return;
        };

        if (is_null($this->organizationDto->invalid)) $fail(trans('auth.invalid_organization_data'));
    }
}
