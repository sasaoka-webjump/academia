<?php

namespace App;

use \Dotenv\Dotenv;

class EnvironmentVariablesLoader extends Dotenv
{

    /**
     * Loads the environment variables from the .env file
     *
     * @return void
     */
    public static function start()
    {
        $dotenv = parent::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }
}
