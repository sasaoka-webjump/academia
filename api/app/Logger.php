<?php

namespace App;

use Monolog\Logger as Monolog;
use Monolog\Handler\StreamHandler;


class Logger
{
    /**
     * @var \Monolog\Logger
     */
    protected $logger;


    public function __construct()
    {
        $this->logger = new Monolog('logger');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/academy.log', Monolog::WARNING));
    }

    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public function warn(string $message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error(string $message, array $context = [])
    {
        $this->logger->error($message, $context);
    }
}
