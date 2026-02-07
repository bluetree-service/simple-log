<?php

declare(strict_types=1);

namespace SimpleLog;

interface LogInterface
{
    /**
     * create log message
     *
     * @param array|string $message
     * @param array $context
     * @return $this
     */
    public function makeLog(array|string $message, array $context = []): LogInterface;

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function setOption(string $key, mixed $val): LogInterface;

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return mixed
     */
    public function getOption(?string $key = null): mixed;
}
