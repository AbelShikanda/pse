<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

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
        Paginator::useBootstrap();

        Event::listen(
            Registered::class,
            SendEmailVerificationNotification::class,
        );

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
