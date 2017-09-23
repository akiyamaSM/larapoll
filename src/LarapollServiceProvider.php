<?php
namespace Inani\Larapoll;

use Illuminate\Support\ServiceProvider;

class LarapollServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Boot What is needed
     *
     */
    public function boot()
    {
        // migrations
        $this->publishes([
            __DIR__. '/database/migrations/2017_01_23_115718_create_polls_table.php'
            => base_path('database/migrations/2017_01_23_115718_create_polls_table.php'),
            __DIR__. '/database/migrations/2017_01_23_124357_create_options_table.php'
            => base_path('database/migrations/2017_01_23_124357_create_options_table.php'),
            __DIR__. '/database/migrations/2017_01_25_111721_create_votes_table.php'
            => base_path('database/migrations/2017_01_25_111721_create_votes_table.php'),
        ]);
        // routes
        include __DIR__ . '/Http/routes.php';
        // views
        $this->loadViewsFrom(__DIR__.'/views', 'larapoll');

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('larapoll_config.php'),
        ]);
    }
}