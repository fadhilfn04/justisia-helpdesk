<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Carbon\Carbon;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Update defaultStringLength
        Builder::defaultStringLength(191);

        KTBootstrap::init();
        Carbon::setLocale('id');

        URL::forceScheme('https');
        URL::forceRootUrl(Config::get('app.url'));
    }
}
