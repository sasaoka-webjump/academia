<?php

namespace App\Exceptions;

class PasswordNotMatchException extends \Exception
{
    const ERROR_CODE = 401;
    const ERROR_MESSAGE = "Password not match";

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
    }
}
