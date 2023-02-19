<?php

namespace Jk\Logger\LogWriters\FileWriter;

use Throwable;

class BadFileNameException extends \Exception {
    public const DEFAULT_MESSAGE = 'File name is not defined properly';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}