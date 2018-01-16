<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultJsonMessage;

class DefaultJsonMessageTest extends TestCase
{
    public function testSimpleMessage()
    {
        $message = (new DefaultJsonMessage)->createMessage('Some log message', [])->getMessage();

        $this->assertRegExp($this->getSampleContent(), $message);
    }

    protected function getSampleContent()
    {
        return '#{"date":"[\d]{2}-[\d]{2}-[\d]{4}","time":"[\d]{2}:[\d]{2}:[\d]{2}","data":"Some log message"}#';
    }

    public function testSimpleMessageWithArray()
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultJsonMessage)->createMessage($content, [])->getMessage();

        $this->assertRegExp($this->getArrayMessageContent(), $message);
    }

    protected function getArrayMessageContent()
    {
        return '#{"date":"[\d]{2}-[\d]{2}-[\d]{4}","time":"[\d]{2}:[\d]{2}:[\d]{2}"'
            . ',"data":{"message key":"some message","another key":"some another message","0":"no key message"}}#';
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
        $message = (new DefaultJsonMessage)->createMessage($content, [])->getMessage();

        $this->assertRegExp($this->getSubArrayMessageContent(), $message);
    }

    protected function getSubArrayMessageContent()
    {
        return '#{"date":"[\d]{2}-[\d]{2}-[\d]{4}","time":"[\d]{2}:[\d]{2}:[\d]{2}"'
            . ',"data":{"sub array":{"key":"val","key 2":"val 2"}}}#';
    }

    public function testMessageWithContext()
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultJsonMessage)->createMessage('Some log message with {context}', $context)->getMessage();

        $this->assertRegExp($this->getSampleContentWithContext(), $message);
    }

    protected function getSampleContentWithContext()
    {
        return '#{"date":"[\d]{2}-[\d]{2}-[\d]{4}","time":"[\d]{2}:[\d]{2}:[\d]{2}"'
            . ',"data":"Some log message with some value"}#';
    }
}
