<?php

declare(strict_types=1);

namespace SimpleLog\Message;

use Psr\Log\InvalidArgumentException;

class DefaultMessage implements MessageInterface
{
    /**
     * @var string
     */
    protected string $message = '';

    /**
     * @param string|array $message
     * @param array $context
     * @return $this
     * @throws InvalidArgumentException
     */
    public function createMessage(string|array $message, array $context): MessageInterface
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
    protected function buildContext(array $context): MessageInterface
    {
        $replace = [];

        foreach ($context as $key => $val) {
            if (!\is_array($val) && (!\is_object($val) || \method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        $this->message = \strtr($this->message, $replace);

        return $this;
    }

    /**
     * @return $this
     */
    protected function wrapMessage(): MessageInterface
    {
        $this->message = $this->dateTime()
            . PHP_EOL
            . $this->message
            . '-----------------------------------------------------------'
            . PHP_EOL;

        return $this;
    }

    /**
     * recurrent function to convert array into message
     *
     * @param string|array $message
     * @param string $indent
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function buildMessage(string|array $message, string $indent = ''): MessageInterface
    {
        match (true) {
            \is_array($message) => $this->buildArrayMessage($message, $indent),
            \is_string($message) => $this->message = $message . PHP_EOL,
        };

        return $this;
    }

    /**
     * @param array $message
     * @param string $indent
     */
    protected function buildArrayMessage(array $message, string $indent): void
    {
        foreach ($message as $key => $value) {
            $this->processMessage($key, $value, $indent);
        }
    }

    /**
     * @param string|int $key
     * @param string|array $value
     * @param string $indent
     * @return $this
     */
    protected function processMessage(string|int $key, string|array $value, string $indent): MessageInterface
    {
        $row = '- ';

        if (!\is_int($key)) {
            $row .= $key . ':';
        }

        if (\is_array($value)) {
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
     * @return array
     */
    protected function dateTimeSplit(): array
    {
        $dateTime = new \DateTime();
        $date = $dateTime->format(self::DATE_FORMAT);
        $time = $dateTime->format(self::TIME_FORMAT);

        return [$date, $time];
    }

    /**
     * @return string
     */
    protected function dateTime(): string
    {
        return (new \DateTime())->format(self::DATE_TIME_FORMAT);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
