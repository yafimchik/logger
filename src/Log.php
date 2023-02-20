<?php

namespace Jk\Logger;

use Jk\Logger\LogWriters\DbWriter\DbWriter;
use Jk\Logger\LogWriters\FileWriter\FileWriter;
use PDO;

class Log {
    private static array $loggers = [];

    public static function toFile(string $directory, string $file = FileWriter::DEFAULT_FILE_NAME): void
    {
        $fileWriter = new FileWriter($directory, $file);
        self::$loggers[] = new Logger($fileWriter);
    }

    public static function toDb(PDO $connection, string $table = DbWriter::DEFAULT_TABLE_NAME): void
    {
        $DbWriter = new DbWriter($connection, $table);
        self::$loggers[] = new Logger($DbWriter);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if (!method_exists(Logger::class, $name)) {
            throw new UnknownMethodException;
        }
        foreach (self::$loggers as $logger) {
            $logger->$name(...$arguments);
        }
    }
}