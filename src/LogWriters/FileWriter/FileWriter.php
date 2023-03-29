<?php

namespace Jk\Logger\LogWriters\FileWriter;

use Jk\Logger\LogWriters\ILogWriter;
use Jk\Logger\LogWriters\LogWriter;

class FileWriter extends LogWriter implements ILogWriter {
    public const DEFAULT_FILE_NAME = 'run.log';

    protected $file = null;

    protected string $filePath = '';

    protected function __construct(array $options)
    {
        $filePath = $options['filePath'] ?? self::DEFAULT_FILE_NAME;

        if (!$filePath || !strlen($filePath)) {
            throw new BadFileNameException;
        }

        $realLocation = realpath(dirname($filePath));
        if (!$realLocation) {
            throw new BadLocationException;
        }

        $this->filePath = $filePath;
        $this->file = fopen($this->filePath, 'a+');
    }

    public function write($level, \Stringable|string $message, array $context): void
    {
        if (!$this->file) {
            throw new \Exception('Writing before initializing');
        }

        $date = date('d-m-y h:i:s');
        $serializedContext = serialize($context);
        $string = "$date | $level | $message | $serializedContext";

        $result = fwrite($this->file, $string . PHP_EOL);
        if (!$result) {
            throw new \Exception('Cannot access file: ' . $this->filePath);
        }
    }

    public static function getInstanceFromOptions(array $options): ILogWriter
    {
        $key = $options['filePath'] ?? self::DEFAULT_FILE_NAME;
        return parent::getInstance($key, $options);
    }
}
