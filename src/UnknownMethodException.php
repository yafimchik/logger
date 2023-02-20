<?php

namespace Jk\Logger;

use Throwable;

class UnknownMethodException extends \Exception {
    public const DEFAULT_MESSAGE = 'Unknown Logger method';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}