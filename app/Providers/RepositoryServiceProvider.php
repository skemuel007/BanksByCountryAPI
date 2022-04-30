<?php

namespace App\Providers;

use App\Interfaces\BankInterface;
use App\Interfaces\CountryInterface;
use App\Repositories\BankRepository;
use App\Repositories\CountryRepository;
use App\Services\IBankService;
use App\Services\ICountryService;
use App\Services\Implementations\BankService;
use App\Services\Implementations\CountryService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CountryInterface::class,
            CountryRepository::class
        );

        $this->app->bind(
            BankInterface::class,
            BankRepository::class
        );

        $this->app->bind(
            IBankService::class,
            BankService::class
        );

        $this->app->bind(
            ICountryService::class,
            CountryService::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
