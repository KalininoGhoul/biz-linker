<?php

namespace App\Services\Organization\Dto;

readonly class OrganizationDto
{
    public function __construct(
        public string $name,
        public string $inn,
        public string $ogrn,
        public string $kpp,
        public string $okpo,
        public bool $invalid,
    )
    {
    }
}
