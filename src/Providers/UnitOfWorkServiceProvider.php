<?php

namespace MichalWolinski\UnitOfWork\Providers;

use Illuminate\Support\ServiceProvider;
use MichalWolinski\UnitOfWork\Interfaces\UnitOfWorkInterface;
use MichalWolinski\UnitOfWork\UnitOfWork;

/**
 * Class UnitOfWorkServiceProvider
 * @package MichalWolinski\TextAnonymizer\Providers
 */
class UnitOfWorkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UnitOfWorkInterface::class, UnitOfWork::class);
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
