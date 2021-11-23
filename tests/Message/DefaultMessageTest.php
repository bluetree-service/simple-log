<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultMessage;

class DefaultMessageTest extends TestCase
{
    public function testSimpleMessage(): void
    {
        $message = (new DefaultMessage())->createMessage('Some log message', [])->getMessage();

        $this->assertEquals($this->getSampleContent(), \substr($message, strpos($message, "\n") + 1));
    }

    protected function getSampleContent(): string
    {
        return <<<EOT
Some log message
-----------------------------------------------------------

EOT;
    }

    public function testSimpleMessageWithArray(): void
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultMessage())->createMessage($content, [])->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getArrayMessageContent(), \substr($message, \strpos($message, "\n") + 1));
    }

    protected function getArrayMessageContent(): string
    {
        return <<<EOT
- message key: some message
- another key: some another message
- no key message
-----------------------------------------------------------

EOT;
    }

    /**
     * simple create log object and create log message from array with sub arrays data in given directory
     */
    public function testCreateLogWithSubArrayMessage(): void
    {
        $content = [
            'sub array' => [
                'key' => 'val',
                'key 2' => 'val 2',
            ],
        ];
        $message = (new DefaultMessage())->createMessage($content, [])->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        //hack with remove new lines because of differences between output and stored expectation
        $this->assertEquals(
            \str_replace("\n", '', $this->getSubArrayMessageContent()),
            \str_replace("\n", '', \substr($message, \strpos($message, "\n") + 1))
        );
    }

    protected function getSubArrayMessageContent(): string
    {
        return <<<EOT
- sub array:
    - key: val
    - key 2: val 2
-----------------------------------------------------------

EOT;
    }

    public function testMessageWithContext(): void
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultMessage())->createMessage('Some log message with {context}', $context)->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals(
            $this->getSampleContentWithContext(),
            \substr($message, \strpos($message, "\n") + 1)
        );
    }

    protected function getSampleContentWithContext(): string
    {
        return <<<EOT
Some log message with some value
-----------------------------------------------------------

EOT;
    }

    public function testMessageWithError(): void
    {
        if (\PHP_VERSION < '8.0.0') {
            $this->expectExceptionMessage(
                'Incorrect message type. Must be string, array or object with __toString method.'
            );
            $this->expectException(\Psr\Log\InvalidArgumentException::class);
        } else {
            $this->expectExceptionMessage(
                'method_exists(): Argument #1 ($object_or_class) must be of type object|string, int given'
            );
            $this->expectException(\TypeError::class);
        }

        (new DefaultMessage())->createMessage(32432, [])->getMessage();
    }
}
