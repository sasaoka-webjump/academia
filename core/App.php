<?php

namespace Core;

use DI\ContainerBuilder;

class App
{
    private static $container;

    /**
     * Returns the container instance. If it doesn't exists
     * yet, create it before returning it.
     *
     * @return \DI\Container
     */
    public static function getContainer()
    {
        if (!isset(self::$container)) {
            self::createContainer();
        }

        return self::$container;
    }

    /**
     * Creates a new container instance.
     *
     * @return void
     */
    private static function createContainer()
    {
        $builder = new ContainerBuilder();

        $builder->useAutowiring(true);
        self::$container = $builder->build();
    }
}
