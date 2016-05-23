<?php

namespace SimpleLog;

interface SimpleLogInterface
{
    /**
     * create log message
     *
     * @param string $type
     * @param array $params
     * @return mixed
     */
    public function makeLog($type, array $params);
}
