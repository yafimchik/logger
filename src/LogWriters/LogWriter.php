<?php

namespace Jk\Logger\LogWriters;

use Jk\Logger\Common\Multiton;

abstract class LogWriter extends Multiton implements ILogWriter
{
    abstract protected function __construct(array $options);

    abstract public function write($level, string | \Stringable $message, array $context): void;

    abstract public static function getInstanceFromOptions(array $options): ILogWriter;
}
