<?php

namespace App\Services\Dadata;

use App\Services\Organization\Dto\OrganizationDto;
use App\Services\Organization\OrganizationFinder;

class DadataOrganizationFinder implements OrganizationFinder
{
    public function __construct(
        protected DadataClient $client,
    )
    {
    }

    public function findByInn(string $inn): ?OrganizationDto
    {
        /** @var OrganizationDto $organization */
        $organization = $this->client->findOrganizationsByInn($inn)->first();

        if (!is_null($organization) && $organization->inn === $inn) return $organization;

        return null;
    }
}
