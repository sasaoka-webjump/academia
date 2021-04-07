<?php

use Pecee\SimpleRouter\SimpleRouter as Router;


/**
 * Handles the errors thrown in the application
 */
function handler(\Throwable $error)
{
    $message = $error->getMessage();

    // die(var_dump($message));
    if ($error instanceof \Exception) {
        $code = $error->getCode();
    } else {
        $code = 500;
    }

    return Router::response()
        ->httpCode($code)
        ->json([
            'message' => $message,
            'error' => $error
        ]);
}

set_exception_handler('handler');
