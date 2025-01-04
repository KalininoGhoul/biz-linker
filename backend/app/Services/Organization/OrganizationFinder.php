<?php

namespace App\Services\Organization;

use App\Services\Organization\Dto\OrganizationDto;

interface OrganizationFinder
{
    public function findByInn(string $inn): ?OrganizationDto;
}
