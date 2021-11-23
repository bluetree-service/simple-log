<?php

declare(strict_types=1);

namespace SimpleLog\Message;

interface MessageInterface
{
    public const DATE_FORMAT = 'Y-m-d';
    public const TIME_FORMAT = 'H:m:s';
    public const DATE_TIME_FORMAT = self::DATE_FORMAT . ' - ' . self::TIME_FORMAT;

    /**
     * @param string|array|object $message
     * @param array $context
     * @return $this
     */
    public function createMessage($message, array $context): MessageInterface;

    /**
     * @return string
     */
    public function getMessage(): string;
}
