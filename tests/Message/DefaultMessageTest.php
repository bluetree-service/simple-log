<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultMessage;

class DefaultMessageTest extends TestCase
{
    public function testSimpleMessage()
    {
        $message = (new DefaultMessage)->createMessage('Some log message', [])->getMessage();

        $this->assertEquals($this->getSampleContent(), substr($message, strpos($message, "\n") +1));
    }

    protected function getSampleContent()
    {
        return <<<EOT
Some log message
-----------------------------------------------------------

EOT;
    }

    public function testSimpleMessageWithArray()
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultMessage)->createMessage($content, [])->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getArrayMessageContent(), substr($message, strpos($message, "\n") +1));
    }

    protected function getArrayMessageContent()
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
    public function testCreateLogWithSubArrayMessage()
    {
        $content = [
            'sub array' => [
                'key' => 'val',
                'key 2' => 'val 2',
            ],
        ];
        $message = (new DefaultMessage)->createMessage($content, [])->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        //hack with remove new lines because of differences between output and stored expectation
        $this->assertEquals(
            str_replace("\n", '', $this->getSubArrayMessageContent()),
            str_replace("\n", '', substr($message, strpos($message, "\n") +1))
        );
    }

    protected function getSubArrayMessageContent()
    {
        return <<<EOT
- sub array:
     - key: val
    - key 2: val 2
-----------------------------------------------------------

EOT;
    }

    public function testMessageWithContext()
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultMessage)->createMessage('Some log message with {context}', $context)->getMessage();

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals(
            $this->getSampleContentWithContext(),
            substr($message, strpos($message, "\n") +1)
        );
    }

    protected function getSampleContentWithContext()
    {
        return <<<EOT
Some log message with some value
-----------------------------------------------------------

EOT;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Incorrect message type. Must be string, array or object with __toString method.
     */
    public function testMessageWithError()
    {
        (new DefaultMessage)->createMessage(32432, [])->getMessage();
    }
}
