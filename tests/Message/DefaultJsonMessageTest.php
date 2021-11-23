<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultJsonMessage;
use SimpleLog\Test\DefaultInlineMessageTest as Inline;

class DefaultJsonMessageTest extends TestCase
{
    public function testSimpleMessage(): void
    {
        $message = (new DefaultJsonMessage())->createMessage('Some log message', [])->getMessage();

        $this->assertMatchesRegularExpression($this->getSampleContent(), $message);

        $message = (new DefaultJsonMessage())
            ->createMessage(new MessageObject('Some log message'), [])->getMessage();

        $this->assertMatchesRegularExpression($this->getSampleContent(), $message);
    }

    protected function getSampleContent(): string
    {
        return '#{"date":"'
            . Inline::DATE_FORMAT
            . '","time":"'
            . Inline::TIME_FORMAT
            . '","data":"Some log message"}#';
    }

    public function testSimpleMessageWithArray(): void
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultJsonMessage())->createMessage($content, [])->getMessage();

        $this->assertMatchesRegularExpression($this->getArrayMessageContent(), $message);
    }

    protected function getArrayMessageContent(): string
    {
        return '#{"date":"'
            . Inline::DATE_FORMAT
            . '","time":"'
            . Inline::TIME_FORMAT
            . '"'
            . ',"data":{"message key":"some message","another key":"some another message","0":"no key message"}}#';
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
        $message = (new DefaultJsonMessage())->createMessage($content, [])->getMessage();

        $this->assertMatchesRegularExpression($this->getSubArrayMessageContent(), $message);
    }

    protected function getSubArrayMessageContent(): string
    {
        return '#{"date":"'
            . Inline::DATE_FORMAT
            . '","time":"'
            . Inline::TIME_FORMAT
            . '"'
            . ',"data":{"sub array":{"key":"val","key 2":"val 2"}}}#';
    }

    public function testMessageWithContext(): void
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultJsonMessage())
            ->createMessage('Some log message with {context}', $context)->getMessage();

        $this->assertMatchesRegularExpression($this->getSampleContentWithContext(), $message);
    }

    protected function getSampleContentWithContext(): string
    {
        return '#{"date":"'
            . Inline::DATE_FORMAT
            . '","time":"'
            . Inline::TIME_FORMAT
            . '"'
            . ',"data":"Some log message with some value"}#';
    }
}
