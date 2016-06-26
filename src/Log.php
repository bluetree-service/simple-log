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

        $logMessage = strftime('%d-%m-%Y - %H:%M:%S')
            . PHP_EOL
            . $this->buildMessage($message)
            . '-----------------------------------------------------------'
            . PHP_EOL;

        $logFile = $params['log_path'] . DIRECTORY_SEPARATOR . $params['type'] . '.log';

        if (!is_dir($params['log_path'])) {
            mkdir($params['log_path']);
        }

        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
        }

        file_put_contents($logFile, $logMessage, FILE_APPEND);

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

    /**
     * recurrent function to convert array into message
     *
     * @param string|array $message
     * @param string $indent
     * @return string
     */
    protected function buildMessage($message, $indent = '')
    {
        $information = '';

        if (is_array($message)) {
            foreach ($message as $key => $value) {
                if (is_int($key)) {
                    $key = '- ';
                } else {
                    $key = '- ' . $key . ': ';
                }

                if (is_array($value)) {
                    $information .= $key . PHP_EOL;
                    $information .= $this->buildMessage($value, $indent .= '    ');
                } else {
                    $information .= $indent . $key . $value . PHP_EOL;
                }
            }
        } else {
            $information = $message . PHP_EOL;
        }

        return $information;
    }
}
