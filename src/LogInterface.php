<?php

namespace SimpleLog;

interface LogInterface
{
    /**
     * create log message
     *
     * @param array|string $message
     * @param array $params
     * @return $this
     */
    public function makeLog($message, array $params = []);

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function setOption($key, $val);

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return array|mixed
     */
    public function getOption($key = null);
}
