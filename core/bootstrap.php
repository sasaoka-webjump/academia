<?php

use Core\App;
use App\Router;

require_once '../vendor/autoload.php';

$container = App::getContainer();

Router::setup($container);

require_once '../app/Helpers/routes.php';
require_once '../app/routes.php';

Router::start();
