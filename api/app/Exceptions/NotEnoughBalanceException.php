<?php

namespace App\Exceptions;

class NotEnoughBalanceException extends \Exception
{
    const ERROR_CODE = 400;
    const ERROR_MESSAGE = "Not enough balance";

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
    }
}
