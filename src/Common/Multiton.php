<?php

namespace Jk\Logger\Common;

abstract class Multiton
{
    private static $instances = [];

    protected function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    protected static function getInstance(string $key, array $options = [])
    {
        if (!$key || !strlen($key)) {
            throw new \Exception('Wrong key for multiton instance');
        }
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = [];
        }
        if (!isset(self::$instances[$class][$key])) {
            self::$instances[$class][$key] = new static($options);
        }

        return self::$instances[$class][$key];
    }
}
