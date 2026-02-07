<?php

declare(strict_types=1);

namespace SimpleLog;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;
use SimpleLog\Storage\StorageInterface;
use SimpleLog\Message\MessageInterface;
use SimpleLog\Storage\File;
use SimpleLog\Message\DefaultMessage;

class Log implements LogInterface, LoggerInterface
{
    use LoggerTrait;

    /**
     * @var array
     */
    protected array $defaultParams = [
        'log_path' => './log',
        'level' => 'notice',
        'storage' => File::class,
        'message' => DefaultMessage::class,
    ];

    /**
     * @var StorageInterface
     */
    protected StorageInterface $storage;

    /**
     * @var array
     */
    protected array $levels = [];

    /**
     * @var MessageInterface
     */
    protected MessageInterface $message;

    /**
     * @var MessageInterface
     */
    protected MessageInterface $lastMessage;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->defaultParams = \array_merge($this->defaultParams, $params);
        $this->levels = [
            'EMERGENCY' => LogLevel::EMERGENCY,
            'ALERT' => LogLevel::ALERT,
            'CRITICAL' => LogLevel::CRITICAL,
            'ERROR' => LogLevel::ERROR,
            'WARNING' => LogLevel::WARNING,
            'NOTICE' => LogLevel::NOTICE,
            'INFO' => LogLevel::INFO,
            'DEBUG' => LogLevel::DEBUG,
        ];

        $this->reloadStorage();
        $this->reloadMessage();
    }

    /**
     * log event information into file
     *
     * @param array|string|object $message
     * @param array $context
     * @return $this
     */
    public function makeLog($message, array $context = []): LogInterface
    {
        $this->log($this->defaultParams['level'], $message, $context);

        return $this;
    }

    /**
     * @param string $level
     * @param string|array|object $message
     * @param array $context
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = []): void
    {
        if (!\in_array($level, $this->levels, true)) {
            throw new InvalidArgumentException('Level not defined: ' . $level);
        }

        $newMessage = $this->message
            ->createMessage($message, $context)
            ->getMessage();

        $this->storage->store($newMessage, $level);
        $this->lastMessage = $this->message;
        $this->reloadMessage();
    }

    /**
     * @return $this
     */
    protected function reloadStorage(): LogInterface
    {
        if ($this->defaultParams['storage'] instanceof StorageInterface) {
            $this->storage = $this->defaultParams['storage'];
            return $this;
        }

        $this->storage = new $this->defaultParams['storage']($this->defaultParams);
        return $this;
    }

    /**
     * @return $this
     */
    protected function reloadMessage(): LogInterface
    {
        if ($this->defaultParams['message'] instanceof MessageInterface) {
            $this->message = $this->defaultParams['message'];
            return $this;
        }

        $this->message = new $this->defaultParams['message']($this->defaultParams);
        return $this;
    }

    /**
     * set log option for all future executions of makeLog
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function setOption(string $key, mixed $val): LogInterface
    {
        $this->defaultParams[$key] = $val;
        return $this->reloadStorage();
    }

    /**
     * return all configuration or only given key value
     *
     * @param null|string $key
     * @return mixed
     */
    public function getOption(?string $key = null): mixed
    {
        if ($key === null) {
            return $this->defaultParams;
        }

        return $this->defaultParams[$key];
    }

    /**
     * @return string
     */
    public function getLastMessage(): string
    {
        return $this->lastMessage->getMessage();
    }
}
