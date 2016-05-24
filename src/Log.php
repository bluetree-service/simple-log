<?php

namespace SimpleLog;

class Log implements LogInterface
{
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
     * @return $this
     */
    public function makeLog($message, array $params = [])
    {
        $params = array_merge($this->_defaultParams, $params);

        if (is_array($message)) {
            $information = '';

            foreach ($message as $key => $value) {
                if (is_array($value)) {
                    $newValue = PHP_EOL;

                    foreach ($value as $valueKey => $description) {
                        $newValue .=  "    - $valueKey: $description" . PHP_EOL;
                    }

                    $value = $newValue;
                }

                $information .= "- $key: $value" . PHP_EOL;
            }

            $message = $information;
        } else {
            $message .= PHP_EOL;
        }

        $message = strftime('%H:%M:%S - %d-%m-%Y')
            . PHP_EOL
            . $message
            . PHP_EOL
            . '-----------------------------------------------------------'
            . PHP_EOL;

        $logFile = $params['log_path'] . DIRECTORY_SEPARATOR . $params['type'] . '.log';

        if (!is_dir($params['log_path'])) {
            mkdir($params['log_path']);
        }

        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
        }

        file_put_contents($logFile, $message, FILE_APPEND);

        return $this;
    }

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function setOption($key, $val)
    {
        $this->_defaultParams[$key] = $val;
        return $this;
    }

    /**
     * return all configuration or only given key value
     * 
     * @param null|string $key
     * @return array|mixed
     */
    public function getOption($key = null)
    {
        if (is_null($key)) {
            return $this->_defaultParams;
        }

        return $this->_defaultParams[$key];
    }
}
