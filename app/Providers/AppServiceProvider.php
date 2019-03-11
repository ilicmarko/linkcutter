<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);



        Blade::directive('icon', function ($expression) {
            $class = '';
            $icon = '';

            $args =  explode(',',str_replace(['(',')',' ', "'"], '', $expression));

            if (count($args) === 2) {
                [$icon, $class] = $args;
            } else if(count($args) === 1) {
                [$icon] = $args;
            }

            return "
                    <svg class=\"icons {$class}\">
                        <use xlink:href=\"{{ asset('icons/feather-sprite.svg') }}#{$icon}\" />
                    </svg>";
        });
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
