<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultInlineMessage;

class DefaultInlineMessageTest extends TestCase
{
    public function testSimpleMessage()
    {
        $message = (new DefaultInlineMessage)->createMessage('Some log message', [])->getMessage();

        $this->assertRegExp($this->getSampleContent(), $message);
    }

    protected function getSampleContent()
    {
        return '#\[[\d]{2}-[\d]{2}-[\d]{4} - [\d]{2}:[\d]{2}:[\d]{2}\] Some log message#';
    }

    public function testSimpleMessageWithArray()
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultInlineMessage)->createMessage($content, [])->getMessage();

        $this->assertRegExp($this->getArrayMessageContent(), $message);
    }

    protected function getArrayMessageContent()
    {
        return '#\[[\d]{2}-[\d]{2}-[\d]{4} - [\d]{2}:[\d]{2}:[\d]{2}\]'
            . '  \| message key:some message \| another key:some another message \| no key message#';
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
        $message = (new DefaultInlineMessage)->createMessage($content, [])->getMessage();

        $this->assertRegExp($this->getSubArrayMessageContent(), $message);
    }

    protected function getSubArrayMessageContent()
    {
        return '#\[[\d]{2}-[\d]{2}-[\d]{4} - [\d]{2}:[\d]{2}:[\d]{2}\]  \| sub array: \| key:val \| key 2:val 2#';
    }

    public function testMessageWithContext()
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultInlineMessage)->createMessage('Some log message with {context}', $context)->getMessage();

        $this->assertRegExp($this->getSampleContentWithContext(), $message);
    }

    protected function getSampleContentWithContext()
    {
        return '#\[[\d]{2}-[\d]{2}-[\d]{4} - [\d]{2}:[\d]{2}:[\d]{2}\] Some log message with some value#';
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Incorrect message type. Must be string, array or object with __toString method.
     */
    public function testMessageWithError()
    {
        (new DefaultInlineMessage)->createMessage(32432, [])->getMessage();
    }
}
