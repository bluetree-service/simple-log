<?php

namespace ClassEvent\Test;

use SimpleLog\Log;
use SimpleLog\LogStatic;
use PHPUnit\Framework\TestCase;

class SimpleLogTest extends TestCase
{
    /**
     * name of test event log file
     */
    const NOTICE_LOG_NAME = '/notice.log';

    /**
     * name of test event log file
     */
    const WARNING_LOG_NAME = '/warning.log';

    /**
     * store generated log file path
     *
     * @var string
     */
    protected $logPath;

    /**
     * actions launched before test starts
     */
    protected function setUp()
    {
        $this->logPath = dirname(__FILE__) . '/log';

        if (file_exists($this->logPath . self::NOTICE_LOG_NAME)) {
            unlink($this->logPath . self::NOTICE_LOG_NAME);
        }

        if (file_exists($this->logPath . self::WARNING_LOG_NAME)) {
            unlink($this->logPath . self::WARNING_LOG_NAME);
        }

        if (file_exists($this->logPath)) {
            rmdir($this->logPath);
        }
    }

    /**
     * simple create log object and create log message in given directory
     */
    public function testCreateLogObject()
    {
        $log = new Log;

        $this->assertFileNotExists($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog('Some log message', [
            'log_path' => $this->logPath
        ]);

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getSampleContent(), substr($content, strpos($content, "\n") +1));
    }

    /**
     * simple create log object and create log message from array data in given directory
     */
    public function testCreateLogWithArrayMessage()
    {
        $log = new Log;

        $this->assertFileNotExists($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog(
            [
                'message key' => 'some message',
                'another key' => 'some another message',
                'no key message',
            ],
            [
                'log_path' => $this->logPath
            ]
        );

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        $this->assertEquals($this->getArrayMessageContent(), substr($content, strpos($content, "\n") +1));
    }

    /**
     * simple create log object and create log message from array with sub arrays data in given directory
     */
    public function testCreateLogWithSubArrayMessage()
    {
        $log = new Log;

        $this->assertFileNotExists($this->logPath . self::NOTICE_LOG_NAME);

        $log->makeLog(
            [
                'sub array' => [
                    'key' => 'val',
                    'key 2' => 'val 2',
                ],
            ],
            [
                'log_path' => $this->logPath
            ]
        );

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);

        $content = file_get_contents($this->logPath . self::NOTICE_LOG_NAME);

        //because of different time and date of creating log file, we remove first line with date
        //hack with remove new lines because of differences between output and stored expectation
        $this->assertEquals(
            str_replace("\n", '', $this->getSubArrayMessageContent()),
            str_replace("\n", '', substr($content, strpos($content, "\n") +1))
        );
    }

    /**
     * test setting and getting options via specified methods
     */
    public function testCreateLogObjectWithOtherConfig()
    {
        $log = new Log;

        $this->assertFileNotExists($this->logPath . self::WARNING_LOG_NAME);

        $log->setOption('log_path', $this->logPath)
            ->setOption('type', 'warning')
            ->makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::WARNING_LOG_NAME);
        $this->assertEquals('warning', $log->getOption('type'));
        $this->assertEquals(
            [
                'log_path' => $this->logPath,
                'type' => 'warning',
            ],
            $log->getOption()
        );
    }

    /**
     * check static log interface
     */
    public function testCreateStaticLog()
    {
        LogStatic::setOption('log_path', $this->logPath);

        $this->assertFileNotExists($this->logPath . self::NOTICE_LOG_NAME);
        $this->assertEquals($this->logPath, LogStatic::getOption('log_path'));

        LogStatic::makeLog('Some log message');

        $this->assertFileExists($this->logPath . self::NOTICE_LOG_NAME);
    }

    protected function getSampleContent()
    {
        return <<<EOT
Some log message
-----------------------------------------------------------

EOT;
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

    protected function getSubArrayMessageContent()
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
    protected function tearDown()
    {
        if (file_exists($this->logPath . self::NOTICE_LOG_NAME)) {
            unlink($this->logPath . self::NOTICE_LOG_NAME);
        }

        if (file_exists($this->logPath . self::WARNING_LOG_NAME)) {
            unlink($this->logPath . self::WARNING_LOG_NAME);
        }

        if (file_exists($this->logPath)) {
            rmdir($this->logPath);
        }
    }
}
