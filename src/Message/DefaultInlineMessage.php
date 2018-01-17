<?php

namespace SimpleLog\Message;

class DefaultInlineMessage extends DefaultMessage
{
    /**
     * @return $this
     */
    protected function wrapMessage()
    {
        $date = strftime('%d-%m-%Y - %H:%M:%S', time());
        $this->message = '[' . $date . '] ' . $this->message;

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
        $row = ' | ';

        if (!is_int($key)) {
            $row .= $key . ':';
        }

        if (is_array($value)) {
            $this->message .= $row;
            $this->buildMessage($value, $indent);
        } else {
            $this->message .= $row . $value;
        }

        return $this;
    }
}
