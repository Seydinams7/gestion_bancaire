<?php

namespace App\Providers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/redirect';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */


    public function boot()
    {
        parent::boot();

        // Redirection personnalisée après login
        Route::middleware('web')->group(function () {
            Route::get('/redirect', function () {
                $user = Auth::user();

                if (!$user) {
                    return redirect('/login');
                }

                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    default => redirect()->route('dashboard'),
                };
            });
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
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

}
