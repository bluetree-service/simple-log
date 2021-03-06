<?php

namespace SimpleLog\Message;

use Psr\Log\InvalidArgumentException;

class DefaultMessage implements MessageInterface
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @param string|array|object $message
     * @param array $context
     * @return $this
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function createMessage($message, array $context)
    {
        $this->buildMessage($message)
            ->wrapMessage()
            ->buildContext($context);

        return $this;
    }

    /**
     * @param array $context
     * @return $this
     */
    protected function buildContext(array $context)
    {
        $replace = [];

        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        $this->message = strtr($this->message, $replace);

        return $this;
    }

    /**
     * @return $this
     */
    protected function wrapMessage()
    {
        $this->message = strftime(self::DATE_TIME_FORMAT, time())
            . PHP_EOL
            . $this->message
            . '-----------------------------------------------------------'
            . PHP_EOL;

        return $this;
    }

    /**
     * recurrent function to convert array into message
     *
     * @param string|array|object $message
     * @param string $indent
     * @return $this
     * @throws \Psr\Log\InvalidArgumentException
     */
    protected function buildMessage($message, $indent = '')
    {
        switch (true) {
            case is_array($message):
                $this->buildArrayMessage($message, $indent);
                break;

            case method_exists($message, '__toString'):
            case is_string($message):
                $this->message = $message . PHP_EOL;
                break;

            default:
                throw new InvalidArgumentException(
                    'Incorrect message type. Must be string, array or object with __toString method.'
                );
                break;
        }

        return $this;
    }

    /**
     * @param array $message
     * @param string $indent
     */
    protected function buildArrayMessage(array $message, $indent)
    {
        foreach ($message as $key => $value) {
            $this->processMessage($key, $value, $indent);
        }
    }

    /**
     * @param string|int $key
     * @param mixed $value
     * @param string $indent
     * @return $this
     */
    protected function processMessage($key, $value, $indent)
    {
        $row = '- ';

        if (!is_int($key)) {
            $row .= $key . ':';
        }

        if (is_array($value)) {
            $indent .= '    ';
            $this->message .= $row . PHP_EOL;
            $this->buildMessage($value, $indent);
        } else {
            $this->message .= $indent
                . $row
                . (!$key ? '' : ' ')
                . $value
                . PHP_EOL;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
