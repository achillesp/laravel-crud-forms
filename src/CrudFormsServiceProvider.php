<?php

namespace Achillesp\CrudForms;

use Illuminate\Support\ServiceProvider;

class CrudFormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/crud-forms.php' => config_path('crud-forms.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/crud-forms.php', 'crud-forms');

        // Register the bundled view set selected by the `theme` config option.
        // Published views (resources/views/vendor/crud-forms) still take precedence.
        $theme = config('crud-forms.theme', 'bootstrap');
        $themeDir = 'tailwind' === $theme ? 'views-tailwind' : 'views';
        $this->loadViewsFrom(__DIR__.'/'.$themeDir, 'crud-forms');

        // Default (Bootstrap 3) view set.
        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/crud-forms'),
        ], 'views');

        // Tailwind CSS view set. Publishing this overrides the rendered views
        // (Laravel resolves published vendor views before the package's own).
        $this->publishes([
            __DIR__.'/views-tailwind' => resource_path('views/vendor/crud-forms'),
        ], 'views-tailwind');
    }
}
