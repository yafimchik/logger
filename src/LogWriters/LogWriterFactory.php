<?php

namespace Jk\Logger\LogWriters;
use Jk\Logger\LogWriters\DbWriter\DbWriter;
use Jk\Logger\LogWriters\FileWriter\FileWriter;

class LogWriterFactory
{
    public static function create(string $type, array $options): ILogWriter
    {
        switch ($type) {
            case 'db':
                return DbWriter::getInstanceFromOptions($options);
            case 'file':
                return FileWriter::getInstanceFromOptions($options);
        }

        throw new \Exception('Unknown log writer type');
    }
}
