<?php

namespace App;

use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{


    /**
     * Setup the router configurations
     *
     * @param \Di\Container $container
     * @return void
     */
    public static function setup(\Di\Container $container)
    {
        parent::enableDependencyInjection($container);
        parent::setDefaultNamespace('\App\Controllers');
    }
}
