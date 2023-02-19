<?php

namespace Jk\Logger\LogWriters\DbWriter;

use Jk\Logger\LogWriters\ILogWriter;
use PDO;

class DbWriter implements ILogWriter {
    public const DEFAULT_TABLE_NAME = 'runtime_logs';

    public function __construct(private PDO $connection, private string $table = self::DEFAULT_TABLE_NAME)
    {
        if (!isset($table) || !strlen($table)) {
            throw new BadTableNameException;
        }
        $this->createTable();
    }

    public function write($level, \Stringable|string $message, array $context): void
    {
        $table = $this->table;
        $serializedContext = serialize($context);

        $timestamp = date('Y-m-d H:i:s');

        $sql = <<<____SQL

            INSERT INTO `$table` (level, message, context, created_at, updated_at)
            VALUES ('$level', '$message', '$serializedContext', '$timestamp', '$timestamp');
        
        ____SQL;

        $this->connection->exec($sql);
    }

    private function createTable()
    {
        $table = $this->table;
        $sql = <<<____SQL

             CREATE TABLE IF NOT EXISTS `$table` (
        
                `id` int NOT NULL AUTO_INCREMENT,
        
                `level` varchar(10) NOT NULL,
                
                `message` varchar(255) NOT NULL,
                 
                `context` text NOT NULL,
        
                `created_at` timestamp,
        
                `updated_at` timestamp,
                 PRIMARY KEY (id)
             );
        
        ____SQL;

        $this->connection->exec($sql);
    }
}