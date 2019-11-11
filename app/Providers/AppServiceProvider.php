<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

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
        $channels = Cache::rememberForever('channels', function() {
            return Channel::all();
        });

        \View::composer('*', function($view) use ($channels) {
            $view->with('channels', $channels);
        });

    }
}
