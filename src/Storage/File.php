<?php

namespace SimpleLog\Storage;

use SimpleLog\LogException;

class File implements StorageInterface
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $message
     * @param string $level
     * @throws \SimpleLog\LogException
     * @return $this
     */
    public function store($message, $level)
    {
        $flag = 0;
        $logFile = $this->params['log_path'] . DIRECTORY_SEPARATOR . $level . '.log';

        if (!file_exists($this->params['log_path'])) {
            $bool = mkdir($this->params['log_path']);

            if (!$bool) {
                throw new LogException('Unable to create log directory: ' . $this->params['log_path']);
            }
        }

        if (file_exists($logFile)) {
            $flag = FILE_APPEND;
        }

        $bool = file_put_contents($logFile, $message, $flag);

        if (!$bool) {
            throw new LogException('Unable to save log file: ' . $logFile);
        }

        return $this;
    }
}
