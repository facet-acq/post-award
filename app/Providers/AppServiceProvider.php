<?php

namespace App\Providers;

use App\SloaAccountingLine;
use Illuminate\Support\ServiceProvider;
use App\Observers\SloaAccountingLineObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SloaAccountingLine::observe(SloaAccountingLineObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
