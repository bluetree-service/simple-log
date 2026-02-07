<?php

declare(strict_types=1);

namespace SimpleLog;

class LogStatic
{
    /**
     * @var Log
     */
    protected static Log $instance;

    /**
     * log event information into file
     *
     * @param string $level
     * @param array|string $message
     * @param array $context
     * @param array $params
     * @throws \ReflectionException
     */
    public static function log(string $level, array|string $message, array $context = [], array $params = []): void
    {
        self::init($params);
        self::$instance->log($level, $message, $context);
    }

    /**
     * log event information into file
     *
     * @param array|string $message
     * @param array $context
     * @param array $params
     * @throws \ReflectionException
     */
    public static function makeLog(array|string $message, array $context = [], array $params = []): void
    {
        self::init($params);
        self::$instance->makeLog($message, $context);
    }

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return Log
     * @throws \ReflectionException
     */
    public static function setOption(string $key, mixed $val): Log
    {
        self::init();
        return self::$instance->setOption($key, $val);
    }

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getOption(?string $key = null): mixed
    {
        self::init();
        return self::$instance->getOption($key);
    }

    /**
     * create Log object if not exists
     *
     * @param array $params
     * @throws \ReflectionException
     */
    protected static function init(array $params = []): void
    {
        if (is_null(self::$instance)) {
            self::$instance = new Log($params);
        }
    }
}
