<?php

declare(strict_types=1);

namespace SimpleLog;

interface LogInterface
{
    /**
     * create log message
     *
     * @param array|string|object $message
     * @param array $context
     * @return $this
     */
    public function makeLog($message, array $context = []): LogInterface;

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function setOption(string $key, $val): LogInterface;

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return array|mixed
     */
    public function getOption(?string $key = null);
}
