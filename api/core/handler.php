<?php

use Pecee\SimpleRouter\SimpleRouter as Router;


/**
 * Handles the errors thrown in the application
 */
function handler(\Throwable $error)
{
    $message = $error->getMessage();

    if ($error instanceof \Exception) {
        $code = $error->getCode();
    } else {
        $code = 500;
    }

    return Router::response()->json([
        'error' => $message,
        'code'  => $code
    ]);
}

set_exception_handler('handler');
