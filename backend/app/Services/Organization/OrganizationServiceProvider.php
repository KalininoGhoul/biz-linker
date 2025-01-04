<?php

namespace App\Services\Organization;

use App\Services\Dadata\DadataOrganizationFinder;
use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrganizationFinder::class, DadataOrganizationFinder::class);
    }
}
