<?php

namespace Jk\Logger;

use Jk\Logger\LogWriters\DbWriter;
use Jk\Logger\LogWriters\FileWriter;
use PDO;
use Psr\Log\LoggerInterface;

class Log {
    public static function toFile(string $filePath): LoggerInterface
    {
        if (!isset($filePath) || !strlen($filePath)) {
            throw new \Exception('File path to log files is not defined');
        }

        $fileWriter = new FileWriter(realpath($filePath));
        return new Logger($fileWriter);
    }

    public static function toDb(PDO $connection, string $table): LoggerInterface
    {
        if (!isset($connection)) {
            throw new \Exception('Connection is not defined');
        }
        if (!isset($table) || !strlen($table)) {
            throw new \Exception('Log db table name is not defined');
        }

        $DbWriter = new DbWriter($connection, $table);
        return new Logger($DbWriter);
    }
}