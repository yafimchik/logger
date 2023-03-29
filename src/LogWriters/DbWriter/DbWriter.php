<?php

namespace Jk\Logger\LogWriters\DbWriter;

use Jk\Logger\LogWriters\ILogWriter;
use Jk\Logger\LogWriters\LogWriter;
use PDO;

class DbWriter extends LogWriter implements ILogWriter {
    public const DEFAULT_TABLE_NAME = 'runtime_logs';

    public const DEFAULT_USER = 'root';

    private PDO $connection;

    protected function __construct(array $options)
    {
        $table = $options['table'] ?? self::DEFAULT_TABLE_NAME;
        $dsn = $options['dsn'];
        $user = $options['user'] ?? self::DEFAULT_USER;
        $password = $options['password'];

        unset($options['table']);
        unset($options['dsn']);
        unset($options['user']);
        unset($options['password']);

        $this->connection = new PDO($dsn, $user, $password, $options);
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

    public static function getInstanceFromOptions(array $options): ILogWriter
    {
        $key = $options['dsn'];
        return parent::getInstance($key, $options);
    }
}
