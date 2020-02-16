<?php

namespace Mozafar\WHMCS\Providers;

use Illuminate\Support\ServiceProvider;
use Mozafar\WHMCS\Clients;
use Mozafar\WHMCS\Contracts\ClientsInterface;
use Mozafar\WHMCS\Contracts\WHMCSContract;
use Mozafar\WHMCS\WHMCS;

class WHMCSServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        ClientsInterface::class => Clients::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->alias(WHMCSContract::class, 'whmcs');

        $this->mergeConfigFrom(
            $this->configPath('whmcs.php'), 'whmcs'
        );

        $this->app->singleton('whmcs', function ($app) {
            return $app->make(WHMCS::class);
        });
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
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR."$filename";
    }
}