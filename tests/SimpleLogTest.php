<?php

namespace SimpleLog\Test;

use SimpleLog\Log;
use SimpleLog\LogStatic;
use SimpleLog\Storage\File;
use SimpleLog\Message\DefaultInlineMessage;
use PHPUnit\Framework\TestCase;
use SimpleLog\Message\DefaultMessage;

class SimpleLogTest extends TestCase
{
    /**
     * name of test event log file
     */
    public const NOTICE_LOG_NAME = '/notice.log';

    /**
     * name of test event log file
     */
    public const WARNING_LOG_NAME = '/warning.log';

    /**
     * store generated log file path
     *
     * @var string
     */
    protected $logPath;

    /**
     * actions launched before test starts
     */
    protected function setUp(): void
    {
        $this->logPath = __DIR__ . '/log';

        $this->tearDown();
    }

    public function testCreateLogMessageWithIncorrectLevel(): void
    {
        $this->expectExceptionMessage("Level not defined: incorrect");
        $this->expectException(\Psr\Log\InvalidArgumentException::class);

        (new Log(['log_path' => $this->logPath]))
            ->log('incorrect', 'Some log message');
    }

    public function testCreateIncorrectLogMessage(): void
    {
        $this->expectExceptionMessage(
            'method_exists(): Argument #1 ($object_or_class) must be of type object|string, int given'
        );
        $this->expectException(\TypeError::class);

        (new Log(['log_path' => $this->logPath]))
            ->makeLog(12312312);
    }

    /**
     * simple create log object and create log message in given directory
     */
    public function testCreateSimpleLogMessage(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getSampleContent(), \substr($content, \strpos($content, "\n") + 1));
    }

    /**
     * simple create log object and create log message in given directory
     */
    public function testCreateMultipleSimpleLogMessage(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message');

        $content = \file_get_contents($this->logPath . self::NOTICE_LOG_NAME);
        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals(
            $this->getSampleContent() . $this->getSampleContent(),
            \preg_replace('#[\d]{4}-[\d]{2}-[\d]{2} - [\d]{2}:[\d]{2}:[\d]{2}\n#', '', $content)
        );
    }

    public function testCreateSimpleLogWithOtherStorage(): void
    {
        $log = new Log([
            'storage' => new File(
                ['log_path' => $this->logPath]
            )
        ]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);
    }

    public function testCreateSimpleLogWithOtherMessage(): void
    {
        $log = new Log([
            'message' => new DefaultInlineMessage(),
            'log_path' => $this->logPath,
        ]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);
    }

    public function testGetLastMessage(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $log->makeLog('Some log message');

        $content = $log->getLastMessage();
        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getSampleContent(), substr($content, strpos($content, "\n") + 1));
    }

    /**
     * simple create log object and create log message from array data in given directory
     */
    public function testCreateLogWithArrayMessage(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog(
            [
                'message key' => 'some message',
                'another key' => 'some another message',
                'no key message',
            ]
        );

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getArrayMessageContent(), substr($content, strpos($content, "\n") + 1));
    }

    /**
     * simple create log object and create log message from array with sub arrays data in given directory
     */
    public function testCreateLogWithSubArrayMessage(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog(
            [
                'sub array' => [
                    'key' => 'val',
                    'key 2' => 'val 2',
                ],
            ]
        );

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        //hack with remove new lines because of differences between output and stored expectation
        $this->assertEquals(
            str_replace("\n", '', $this->getSubArrayMessageContent()),
            str_replace("\n", '', substr($content, strpos($content, "\n") + 1))
        );
    }

    /**
     * test setting and getting options via specified methods
     */
    public function testCreateLogObjectWithOtherConfig(): void
    {
        $log = new Log();

        $this->assertFileDoesNotExist($this->logPath . self::WARNING_LOG_NAME);

        $log->setOption('log_path', $this->logPath)
            ->setOption('level', 'warning')
            ->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::WARNING_LOG_NAME);
        $this->assertEquals('warning', $log->getOption('level'));
        $this->assertEquals(
            [
                'log_path' => $this->logPath,
                'level' => 'warning',
                'storage' => 'SimpleLog\Storage\File',
                'message' => DefaultMessage::class,
            ],
            $log->getOption()
        );
    }

    /**
     * check static log interface
     */
    public function testCreateStaticMakeLog(): void
    {
        LogStatic::setOption('log_path', $this->logPath);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);
        $this->assertEquals($this->logPath, LogStatic::getOption('log_path'));

        LogStatic::makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);
    }

    /**
     * check static log interface
     */
    public function testCreateStaticLog(): void
    {
        LogStatic::setOption('log_path', $this->logPath);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);
        $this->assertEquals($this->logPath, LogStatic::getOption('log_path'));

        LogStatic::log('notice', 'Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);
    }

    public function testLogWithContext(): void
    {
        $log = new Log(['log_path' => $this->logPath]);

        $this->assertFileDoesNotExist($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message with {context}', ['context' => 'some value']);

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals(
            $this->getSampleContentWithContext(),
            substr($content, strpos($content, "\n") + 1)
        );
    }

    protected function getSampleContent(): string
    {
        return <<<EOT
Some log message
-----------------------------------------------------------

EOT;
    }

    protected function getSampleContentWithContext(): string
    {
        return <<<EOT
Some log message with some value
-----------------------------------------------------------

EOT;
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

    protected function getSubArrayMessageContent(): string
    {
        return <<<EOT
- sub array:
    - key: val
    - key 2: val 2
-----------------------------------------------------------

EOT;
    }

    /**
     * actions launched after test was finished
     */
    protected function tearDown(): void
    {
        if (\file_exists($this->logPath . self::NOTICE_LOG_NAME)) {
            \unlink($this->logPath . self::NOTICE_LOG_NAME);
        }

        if (\file_exists($this->logPath . self::WARNING_LOG_NAME)) {
            \unlink($this->logPath . self::WARNING_LOG_NAME);
        }

        if (\file_exists($this->logPath)) {
            \rmdir($this->logPath);
        }
    }
}
