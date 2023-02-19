<?php

namespace Jk\Logger;

use Jk\Logger\LogWriters\DbWriter\DbWriter;
use Jk\Logger\LogWriters\FileWriter\FileWriter;
use PDO;
use Psr\Log\LoggerInterface;

class Log {
    public static function toFile(string $directory, string $file = FileWriter::DEFAULT_FILE_NAME): LoggerInterface
    {
        $fileWriter = new FileWriter($directory, $file);
        return new Logger($fileWriter);
    }

    public static function toDb(PDO $connection, string $table = DbWriter::DEFAULT_TABLE_NAME): LoggerInterface
    {
        $DbWriter = new DbWriter($connection, $table);
        return new Logger($DbWriter);
    }
}