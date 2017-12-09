<?php

namespace Achillesp\CrudForms;

use Illuminate\Support\ServiceProvider;

class CrudFormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/crud-forms.php' => config_path('crud-forms.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/crud-forms.php', 'crud-forms');

        $this->loadViewsFrom(__DIR__.'/../src/views', 'crud-forms');

        $this->publishes([
            __DIR__.'/../src/views' => resource_path('views/vendor/crud-forms'),
        ], 'views');
    }
}
