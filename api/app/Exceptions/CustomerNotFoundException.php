<?php

namespace App\Exceptions;

class CustomerNotFoundException extends \Exception
{
    const ERROR_CODE = 404;
    const ERROR_MESSAGE = "Customer not found";

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
    }
}
