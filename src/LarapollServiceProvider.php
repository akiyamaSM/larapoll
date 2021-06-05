<?php
namespace Inani\Larapoll;

use Illuminate\Support\ServiceProvider;
use Inani\Larapoll\Helpers\PollWriter;
use Illuminate\Database\Eloquent\Factories\Factory;

class LarapollServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPollWriter();
    }

    /**
     * Boot What is needed
     *
     */
    public function boot()
    {
        // migrations
        $this->publishes([
            __DIR__ . '/database/migrations/2017_01_23_115718_create_polls_table.php'
            => base_path('database/migrations/2017_01_23_115718_create_polls_table.php'),
            __DIR__ . '/database/migrations/2017_01_23_124357_create_options_table.php'
            => base_path('database/migrations/2017_01_23_124357_create_options_table.php'),
            __DIR__ . '/database/migrations/2017_01_25_111721_create_votes_table.php'
            => base_path('database/migrations/2017_01_25_111721_create_votes_table.php'),
            __DIR__ . '/database/migrations/2019_04_20_145921_schema_changes.php'
            => base_path('database/migrations/2019_04_20_145921_schema_changes.php'),
        ]);
        // routes
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        // views
        $this->loadViewsFrom(__DIR__ . '/views', 'larapoll');

        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('larapoll_config.php'),
        ]);
    }

    /**
     * Register the poll writer instance.
     *
     * @return void
     */
    protected function registerPollWriter()
    {
        $this->app->singleton('pollwritter', function ($app) {
            return new PollWriter();
        });
    }

}
