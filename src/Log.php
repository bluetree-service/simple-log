<?php

namespace SimpleLog;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

class Log implements LogInterface, LoggerInterface
{
    use LoggerTrait;

    /**
     * @var array
     */
    protected $defaultParams = [
        'log_path' => './log',
        'level' => 'notice',
        'storage' => \SimpleLog\Storage\File::class,
        'message' => \Message\DefaultMessage::class,
    ];

    /**
     * @var \SimpleLog\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var array
     */
    protected $levels = [];

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param array $params
     * @throws \ReflectionException
     */
    public function __construct(array $params = [])
    {
        $this->defaultParams = array_merge($this->defaultParams, $params);

        $levels = new \ReflectionClass(new LogLevel);
        $this->levels = $levels->getConstants();

        $this->reloadStorage();
    }

    /**
     * log event information into file
     *
     * @param array|string|object $message
     * @param array $context
     * @return $this
     */
    public function makeLog($message, array $context = [])
    {
        return $this->log($this->defaultParams['level'], $message, $context);
    }

    /**
     * @param string $level
     * @param string|array|object $message
     * @param array $context
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = [])
    {
        $this->message = '';

        if (!in_array($level, $this->levels, true)) {
            throw new InvalidArgumentException('Level not defined: ' . $level);
        }

        $this->buildMessage($message)
            ->wrapMessage()
            ->buildContext($context)
            ->storage->store($this->message, $level);
    }

    /**
     * @return $this
     */
    protected function reloadStorage()
    {
        $this->storage = new $this->defaultParams['storage']($this->defaultParams);
        return $this;
    }

    /**
     * @return $this
     */
    protected function wrapMessage()
    {
        $this->message = strftime('%d-%m-%Y - %H:%M:%S', time())
            . PHP_EOL
            . $this->message
            . '-----------------------------------------------------------'
            . PHP_EOL;

        return $this;
    }

    /**
     * @param array $context
     * @return $this
     */
    protected function buildContext(array $context)
    {
        $replace = [];

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        $this->message = strtr($this->message, $replace);

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
        $this->defaultParams[$key] = $val;
        return $this->reloadStorage();
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
            return $this->defaultParams;
        }

        return $this->defaultParams[$key];
    }

    /**
     * @return string
     */
    public function getLastMessage()
    {
        return $this->message;
    }

    /**
     * recurrent function to convert array into message
     *
     * @param string|array|object $message
     * @param string $indent
     * @return $this
     * @throws \Psr\Log\InvalidArgumentException
     */
    protected function buildMessage($message, $indent = '')
    {
        switch (true) {
            case is_object($message) && method_exists($message, '__toString'):
            case is_string($message):
                $this->message = $message . PHP_EOL;
                break;

            case is_array($message):
                foreach ($message as $key => $value) {
                    $this->processMessage($key, $value, $indent);
                }
                break;

            default:
                throw new InvalidArgumentException(
                    'Incorrect message type. Must be string, array or object with __toString method.'
                );
                break;
        }

        return $this;
    }

    /**
     * @param string|int $key
     * @param mixed $value
     * @param string $indent
     * @return $this
     */
    protected function processMessage($key, $value, $indent)
    {
        if (is_int($key)) {
            $key = '- ';
        } else {
            $key = '- ' . $key . ': ';
        }

        if (is_array($value)) {
            $indent .= '    ';
            $this->message .= $key . PHP_EOL;
            $this->buildMessage($value, $indent);
        } else {
            $this->message .= $indent . $key . $value . PHP_EOL;
        }

        return $this;
    }
}
