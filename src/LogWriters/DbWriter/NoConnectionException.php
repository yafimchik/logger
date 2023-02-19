<?php

namespace Jk\Logger\LogWriters\DbWriter;

use Throwable;

class NoConnectionException extends \Exception {
    public const DEFAULT_MESSAGE = 'DbWriter: db connection is not defined';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}