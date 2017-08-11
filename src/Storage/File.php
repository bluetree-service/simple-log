<?php

namespace SimpleLog\Storage;

class File implements StrorageInterface
{
    protected $params = [];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function store($message, $level)
    {
        $logFile = $this->params['log_path'] . DIRECTORY_SEPARATOR . $level . '.log';

        if (!is_dir($this->params['log_path'])) {
            mkdir($this->params['log_path']);
        }

        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
        }

        file_put_contents($logFile, $message, FILE_APPEND);
    }
}
