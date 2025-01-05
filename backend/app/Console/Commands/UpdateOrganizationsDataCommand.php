<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Services\Organization\OrganizationFinder;
use Illuminate\Console\Command;
use Throwable;

class UpdateOrganizationsDataCommand extends Command
{
    protected $signature = 'organizations:update';

    protected $description = 'Command description';

    public function handle(OrganizationFinder $organizationFinder): void
    {
        Organization::query()
            ->lazyById()
            ->each(function (Organization $organization) use ($organizationFinder) {
                $organizationDto = $organizationFinder->findByInn($organization->inn);

                try {
                    $organization->update([
                        'name' => $organizationDto->name,
                        'ogrn' => $organizationDto->ogrn,
                        'kpp' => $organizationDto->kpp,
                        'okpo' => $organizationDto->okpo,
                        'type' => $organizationDto->type,
                        'address' => $organizationDto->address,
                    ]);
                } catch (Throwable) {
                    logger()->error('Error update organization ' . $organization->inn);
                }
            });
    }
}
