<?php

namespace Jk\Logger\LogWriters;

class FileWriter implements ILogWriter {
    public function __construct(private string $filePath)
    {
    }

    public function write($level, \Stringable|string $message, array $context): void
    {
        $date = date('d-m-y h:i:s');
        $serializedContext = serialize($context);
        $string = "$date | $level | $message | $serializedContext";

        file_put_contents($this->filePath, $string . PHP_EOL, FILE_APPEND);
    }
}