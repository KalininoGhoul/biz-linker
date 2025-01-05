<?php

namespace App\Services\Dadata;

use App\Enums\OrganizationType;
use App\Services\Organization\Dto\OrganizationDto;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;

class DadataClient
{
    public function __construct(
        protected PendingRequest $httpClient,
    )
    {
    }

    public function findOrganizationsByInn(string $inn, int $count = 1): Collection
    {
        $response = $this->suggestions()->get('findById/party', [
            'query' => $inn,
            'count' => $count,
        ])
            ->collect('suggestions');

        return $response->map(fn(array $organization) => new OrganizationDto(
            name: $organization['value'],
            inn: $organization['data']['inn'],
            ogrn: $organization['data']['ogrn'],
            kpp: $organization['data']['kpp'],
            okpo: $organization['data']['okpo'],
            type: OrganizationType::from($organization['data']['type']),
            address: $organization['data']['address']['data']['source'],
            invalid: $organization['data']['invalid'] ?? false,
        ));
    }

    protected function suggestions(): PendingRequest
    {
        return $this->httpClient->baseUrl(config('services.dadata.suggestions_api_url'));
    }
}
