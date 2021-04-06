<?php

use Core\App;
use App\Router;
use App\EnvironmentVariablesLoader;
use Illuminate\Database\Capsule\Manager as Capsule;

// Require the autoloaded classes
require_once(__DIR__ . '/../vendor/autoload.php');

// Require the global error handler
require_once(__DIR__ . '/handler.php');

// Loads the environment variables from .env 
EnvironmentVariablesLoader::start();

// Inicialize the database toolkit
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_NAME'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Inicializes and get the application container
$container = App::getContainer();
$container->set('log', 'bar');


// Setup the Router, require the routes and then starts the router
Router::setup($container);
require_once(__DIR__ . '/../app/Helpers/routes.php');
require_once(__DIR__ . '/../app/routes.php');
Router::start();
