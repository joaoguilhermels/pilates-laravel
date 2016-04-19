<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
        
        // Easy calls just getting the id from the urls
        $router->model('payment_methods', 'App\PaymentMethod');
        $router->model('bank_accounts', 'App\BankAccount');
        $router->model('professionals', 'App\Professional');
        $router->model('rooms', 'App\Room');
        $router->model('clients', 'App\Client');
        $router->model('classes', 'App\ClassType');
        $router->model('plans', 'App\Plan');
        $router->model('schedules', 'App\Schedule');
        $router->model('expenses', 'App\Expense');
        
        //If we need more verification like if a user is enabled for example we can use the following code
        //$route->bind('articles', function($id)
        //{
        //    return \App\Article::published()->findOrFail($id);  
        //});
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
