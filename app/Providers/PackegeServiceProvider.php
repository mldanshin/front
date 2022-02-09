<?php

namespace Danshin\Front\Providers;

//use App;

use Illuminate\Support\ServiceProvider;
use Danshin\Front\Console\Commands\Routes as RoutesCommand;
use Danshin\Front\Console\Commands\Lang as LangCommand;

class PackegeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RoutesCommand::class,
                LangCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../../resources/js' => resource_path('js')
        ], 'danshin-front');
    }
}
