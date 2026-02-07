<?php

namespace SimpleLog\Test;

use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultInlineMessage;

class DefaultInlineMessageTest extends TestCase
{
    public const DATE_FORMAT = '[\d]{4}-[\d]{2}-[\d]{2}';
    public const TIME_FORMAT = '[\d]{2}:[\d]{2}:[\d]{2}';
    public const DATE_TIME_FORMAT = self::DATE_FORMAT . ' - ' . self::TIME_FORMAT;

    public function testSimpleMessage(): void
    {
        $message = (new DefaultInlineMessage())->createMessage('Some log message', [])->getMessage();

        $this->assertMatchesRegularExpression($this->getSampleContent(), $message);

//        $message = (new DefaultInlineMessage())
//            ->createMessage(new MessageObject('Some log message'), [])->getMessage();
//
//        $this->assertMatchesRegularExpression($this->getSampleContent(), $message);
    }

    protected function getSampleContent(): string
    {
        return '#\[' . self::DATE_TIME_FORMAT . '] Some log message#';
    }

    public function testSimpleMessageWithArray(): void
    {
        $content = [
            'message key' => 'some message',
            'another key' => 'some another message',
            'no key message',
        ];
        $message = (new DefaultInlineMessage())->createMessage($content, [])->getMessage();

        $this->assertMatchesRegularExpression($this->getArrayMessageContent(), $message);
    }

    protected function getArrayMessageContent(): string
    {
        return '#\['
            . self::DATE_TIME_FORMAT
            . ']'
            . '  \| message key:some message \| another key:some another message \| no key message#';
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
        $message = (new DefaultInlineMessage())->createMessage($content, [])->getMessage();

        $this->assertMatchesRegularExpression($this->getSubArrayMessageContent(), $message);
    }

    protected function getSubArrayMessageContent(): string
    {
        return '#\[' . self::DATE_TIME_FORMAT . ']  \| sub array: \| key:val \| key 2:val 2#';
    }

    public function testMessageWithContext(): void
    {
        $context = ['context' => 'some value'];
        $message = (new DefaultInlineMessage())
            ->createMessage('Some log message with {context}', $context)->getMessage();

        $this->assertMatchesRegularExpression($this->getSampleContentWithContext(), $message);
    }

    protected function getSampleContentWithContext(): string
    {
        return '#\[' . self::DATE_TIME_FORMAT . '] Some log message with some value#';
    }
}
