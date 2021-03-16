<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/index';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Route::prefix('admin')
            //     ->middleware('web')
            //     ->namespace($this->namespace . '\Admin')
            //     ->name('admin.')
            //     ->group(base_path('routes/admin.php'));

            // Route::prefix('merchant')
            //     ->middleware('web')
            //     ->namespace($this->namespace . '\Merchant')
            //     ->name('merchant.')
            //     ->group(base_path('routes/merchant.php'));

            // Route::prefix('partner')
            //     ->middleware('web')
            //     ->namespace($this->namespace . '\Partner')
            //     ->name('partner.')
            //     ->group(base_path('routes/partner.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace . '\User')
            //     ->name('partner.')
            //     ->group(base_path('routes/user.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(20);
        });
    }
}
