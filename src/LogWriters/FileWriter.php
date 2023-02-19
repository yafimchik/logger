<?php

namespace Jk\Logger\LogWriters;

class FileWriter implements ILogWriter {
    public const DEFAULT_FILE_NAME = 'run.log';
    public function __construct(
        private string $directory,
        private string $file = self::DEFAULT_FILE_NAME
    )
    {
        $realLocation = realpath($directory);
        if (!realpath($directory)) {
            throw new \Exception('Log file location does not exist');
        }
        $this->directory = $realLocation;

        if (!$file || !strlen($file)) {
            throw new \Exception('File name is not defined properly');
        }
    }

    public function write($level, \Stringable|string $message, array $context): void
    {
        $date = date('d-m-y h:i:s');
        $serializedContext = serialize($context);
        $string = "$date | $level | $message | $serializedContext";

        $filePath = $this->directory . '/' . $this->file;

        $result = file_put_contents($filePath, $string . PHP_EOL, FILE_APPEND);

        if (!$result) {
            throw new \Exception('Cannot access file: ' . $filePath);
        }
    }
}