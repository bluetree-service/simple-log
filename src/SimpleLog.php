<?php

namespace SimpleLog;

class Log implements SimpleLogInterface
{
    /**
     * log event information into file
     *
     * @param string $type
     * @param array $params
     * @return $this
     */
    public function makeLog($type, array $params)
    {
        $message = $type . ': '
            . $params['event_name']
            . ' - '
            . strftime('%H:%M:%S - %d-%m-%Y') . PHP_EOL
            . 'Listener: '
            . $params['listener']
            . ' -> '
            . $params['status'] . PHP_EOL
            . '-----------------------------------------------------------'
            . PHP_EOL;

        if (!file_exists($params['log_path'])) {
            file_put_contents($params['log_path'], '');
        }

        file_put_contents($params['log_path'], $message, FILE_APPEND);

        return $this;
    }
}
