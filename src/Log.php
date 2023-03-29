<?php

namespace Jk\Logger;

use Jk\Logger\LogWriters\LogWriterFactory;

class Log {
    private static array $loggers = [];

    public static function __callStatic(string $name, array $arguments)
    {
        if (!method_exists(Logger::class, $name)) {
            throw new UnknownMethodException;
        }
        foreach (self::$loggers as $logger) {
            $logger->$name(...$arguments);
        }
    }

    public static function set(string $type, array $options, array $levels = []): void
    {
        $logWriter = LogWriterFactory::create($type, $options);
        self::$loggers[] = new Logger($logWriter, $levels);
    }
}
