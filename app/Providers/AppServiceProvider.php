<?php

namespace App\Providers;

use App\Services\EntryHarianInterface;
use App\Services\EntryHarianService;
use App\Services\MasterTargetInterface;
use App\Services\MasterTargetService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EntryHarianInterface::class, EntryHarianService::class);
        $this->app->bind(MasterTargetInterface::class, MasterTargetService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
