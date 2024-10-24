<?php

namespace Wing5wong\KamarDirectoryServices;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Wing5wong\KamarDirectoryServices\Commands\RemoveOldDataFiles;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyServiceInterface;
use Wing5wong\KamarDirectoryServices\Emergency\LogEmergencyService;

class KamarDirectoryServicesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        $router->middlewareGroup('kamar', [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Mtownsend\RequestXml\Middleware\XmlRequest::class,
        ]);

        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command(RemoveOldDataFiles::class)->daily();
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/kamar-directory-services.php', 'kamar-directory-services');

        $this->app->bind(EmergencyServiceInterface::class, LogEmergencyService::class);
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/kamar-directory-services.php' => config_path('kamar-directory-services.php'),
        ], 'kamar-directory-services');

        // Registering package commands.
        $this->commands([
            RemoveOldDataFiles::class
        ]);
    }
}
