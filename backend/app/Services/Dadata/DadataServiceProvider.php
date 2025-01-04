<?php

namespace App\Services\Dadata;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class DadataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DadataClient::class, function () {
            return new DadataClient(
                Http::withToken(config('services.dadata.api_key'), 'Token')
                    ->acceptJson()
                    ->asJson(),
            );
        });
    }
}
