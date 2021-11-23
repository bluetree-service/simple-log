<?php

declare(strict_types=1);

namespace SimpleLog\Message;

class DefaultJsonMessage extends DefaultMessage
{
    /**
     * @var array
     */
    protected $messageScheme = [];

    /**
     * @var array
     */
    protected $context = [];

    /**
     * @param string|array|object $message
     * @param array $context
     * @return $this
     */
    public function createMessage($message, array $context): MessageInterface
    {
        $this->context = $context;

        [$date, $time] = $this->dateTimeSplit();

        $this->messageScheme['date'] = $date;
        $this->messageScheme['time'] = $time;

        if (!\is_array($message) && \method_exists($message, '__toString')) {
            $message = (string)$message;
        }

        $this->messageScheme['data'] = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        $this->message = \json_encode($this->messageScheme);
        $this->buildContext($this->context);

        return $this->message;
    }
}
