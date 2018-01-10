<?php

namespace SimpleLog\Message;

use Psr\Log\InvalidArgumentException;

class DefaultJsonMessage implements MessageInterface
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param string|array|object $message
     * @param array $context
     */
    public function createMessage($message, array $context)
    {

    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
