<?php

namespace Jk\Logger\LogWriters\FileWriter;

use Throwable;

class BadLocationException extends \Exception {
    public const DEFAULT_MESSAGE = 'File Writer: Log file location does not exist';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}