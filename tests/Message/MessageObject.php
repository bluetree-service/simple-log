<?php

namespace SimpleLog\Test;

class MessageObject
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->message;
    }
}
