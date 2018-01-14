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
     * @return $this
     */
    protected function processMessage($key, $value)
    {
        $row = ' | ';

        if (!is_int($key)) {
            $row .= $key . ':';
        }

        if (is_array($value)) {
            $this->message .= $row;
            $this->buildMessage($value);
        } else {
            $this->message .= $row . $value;
        }

        return $this;
    }
}
