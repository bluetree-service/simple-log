<?php

declare(strict_types=1);

namespace SimpleLog\Message;

class DefaultInlineMessage extends DefaultMessage
{
    /**
     * @return $this
     */
    protected function wrapMessage(): MessageInterface
    {
        $date = $this->dateTime();
        $this->message = '[' . $date . '] ' . $this->message;

        return $this;
    }

    /**
     * @param string|int $key
     * @param mixed $value
     * @param string $indent
     * @return $this
     */
    protected function processMessage($key, $value, string $indent): MessageInterface
    {
        $row = ' | ';

        if (!\is_int($key)) {
            $row .= $key . ':';
        }

        if (\is_array($value)) {
            $this->message .= $row;
            $this->buildMessage($value, $indent);
        } else {
            $this->message .= $row . $value;
        }

        return $this;
    }
}
