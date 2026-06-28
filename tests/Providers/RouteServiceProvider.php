<?php

namespace Achillesp\CrudForms\Test\Providers;

use Illuminate\Routing\Router;
use Achillesp\CrudForms\Test\Controllers\PostController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->get('/', function () {
            return 'home';
        });

        $router->middleware('web')->group(function ($router) {
            $router->resource('/post', PostController::class);
            $router->put('/post/{post}/restore', [PostController::class, 'restore']);
        });
    }
}
