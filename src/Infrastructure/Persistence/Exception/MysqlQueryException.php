<?php

namespace Dailymotion\Infrastructure\Persistence\Exception;

class MysqlQueryException extends \RuntimeException
{
    public function __construct(string $message, string $code)
    {
        parent::__construct($message, $code);
    }
}
