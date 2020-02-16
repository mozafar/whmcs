<?php

namespace Mozafar\WHMCS\Providers;

use Illuminate\Support\ServiceProvider;

class WHMCSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->configPath('whmcs.php'), 'whmcs'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                $this->configPath('whmcs.php') => config_path('whmcs.php'),
            ],
            'config'
        );
    }

    private function configPath($filename = 'whmcs.php')
    {
        return __DIR__."../config/$filename";
    }
}