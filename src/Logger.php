<?php

namespace Jk\Logger;

use Jk\Logger\LogWriters\ILogWriter;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Logger extends AbstractLogger implements LoggerInterface {
    private const LOG_LEVELS_ARRAY = [
        LogLevel::CRITICAL,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::ALERT,
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
    ];

    public function __construct(protected ILogWriter $writer)
    {
    }

    public function log($level, string | \Stringable $message, array $context = []): void
    {
        if (!isset($level) || !in_array($level, self::LOG_LEVELS_ARRAY)) {
            throw new InvalidArgumentException;
        }

        $this->writer->write($level, $message, $context);
    }
}