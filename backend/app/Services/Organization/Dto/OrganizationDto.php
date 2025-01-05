<?php

namespace App\Services\Organization\Dto;

use App\Enums\OrganizationType;

readonly class OrganizationDto
{
    public function __construct(
        public string $name,
        public string $inn,
        public string $ogrn,
        public string $kpp,
        public string $okpo,
        public OrganizationType $type,
        public string $address,
        public bool $invalid,
    )
    {
    }
}
