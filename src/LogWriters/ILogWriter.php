<?php

namespace Jk\Logger\LogWriters;

interface ILogWriter {
    public function write($level, string | \Stringable $message, array $context): void;
}