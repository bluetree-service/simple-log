<?php

namespace SimpleLog;

class LogStatic
{
    /**
     * @var null|Log
     */
    protected static $_instance = null;

    /**
     * @var array
     */
    protected $_defaultParams = [
        'log_path' => './log',
        'type' => 'notice',
    ];

    /**
     * log event information into file
     *
     * @param array|string $message
     * @param array $params
     * @return Log
     */
    public static function makeLog($message, array $params = [])
    {
        self::init();
        return self::$_instance->makeLog($message, $params);
    }

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return Log
     */
    public static function setOption($key, $val)
    {
        self::init();
        return self::$_instance->setOption($key, $val);
    }

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return array|mixed
     */
    public static function getOption($key = null)
    {
        self::init();
        return self::$_instance->getOption($key);
    }

    /**
     * create Log object if not exists
     */
    protected static function init()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Log;
        }
    }
}
