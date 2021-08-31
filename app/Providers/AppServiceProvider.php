<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\Input;

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
        // @todo potential to refactor to its own validator class
        validator()->extend('min_date_diff', function ($attribute, $value, $parameters, $validator) {
            try {
                $firstDate = Carbon::parse(request($parameters[0]));
                $secondDate = Carbon::parse(request($parameters[1]));
                $minDifference = (int) $parameters[2];
                $diffFunction = 'diffIn' . ucfirst($parameters[3]);
                return $firstDate->{$diffFunction}($secondDate) >= $minDifference;
            } catch (\Exception $e) {
                return false;
            }
        });

        validator()->replacer('min_date_diff', function ($message, $attribute, $rule, $parameters) {
            $message = "{$parameters[1]} and {$parameters[0]} must have a difference of {$parameters[2]} {$parameters[3]}.";
            return ucfirst(str_replace('_', ' ', $message));
        });

        view()->composer('*', function ($view) {
            $view
                ->with('currentUser', auth()->user())
                ->with('loggedIn', auth()->check());
        });

        Paginator::useBootstrap();
    }
}
