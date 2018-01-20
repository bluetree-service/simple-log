<?php

namespace SimpleLog\Message;

interface MessageInterface
{
    const DATE_FORMAT = '%Y-%m-%d';
    const TIME_FORMAT = '%H:%M:%S';
    const DATE_TIME_FORMAT = self::DATE_FORMAT . ' - ' . self::TIME_FORMAT;

    /**
     * @param string|array|object $message
     * @param array $context
     * @return $this
     */
    public function createMessage($message, array $context);

    /**
     * @return string
     */
    public function getMessage();
}
