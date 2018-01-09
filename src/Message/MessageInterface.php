<?php

namespace SimpleLog\Message;

interface MessageInterface
{
    /**
     * @param string|array|object $message
     * @param array $context
     */
    public function createMessage($message, array $context);

    /**
     * @return string
     */
    public function getMessage();
}
