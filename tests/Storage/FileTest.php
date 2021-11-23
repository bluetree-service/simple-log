<?php

namespace SimpleLog\Test;

use SimpleLog\Storage\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * store generated log file path
     *
     * @var string
     */
    protected $logPath;

    /**
     * @var array
     */
    protected $fileConfig = [];

    /**
     * @var string
     */
    protected $testLog = 'notice';

    /**
     * @var string
     */
    protected $fullTestFilePath;

    /**
     * @var array
     */
    protected $testMessage = [
        'Some log message',
        'Some another log message',
    ];

    /**
     * actions launched before test starts
     */
    protected function setUp(): void
    {
        $this->logPath = __DIR__ . '/../log';
        $this->fileConfig = ['log_path' => $this->logPath];
        $this->fullTestFilePath = $this->logPath . '/' . $this->testLog . '.log';

        $this->tearDown();
    }

    public function testCreateLogFile(): void
    {
        $this->assertFileDoesNotExist($this->fullTestFilePath);

        (new File($this->fileConfig))->store($this->testMessage[0], $this->testLog);

        $this->assertFileExists($this->fullTestFilePath);

        $content = \file_get_contents($this->fullTestFilePath);
        $this->assertEquals($this->testMessage[0], $content);
    }

    public function testAddMessageForExistingLog(): void
    {
        $storage = new File($this->fileConfig);

        $this->assertFileDoesNotExist($this->fullTestFilePath);

        $storage->store($this->testMessage[0], $this->testLog);

        $this->assertFileExists($this->fullTestFilePath);

        $content = \file_get_contents($this->fullTestFilePath);
        $this->assertEquals($this->testMessage[0], $content);

        $storage->store($this->testMessage[1], $this->testLog);

        $this->assertFileExists($this->fullTestFilePath);

        $content = \file_get_contents($this->fullTestFilePath);
        $this->assertEquals($this->testMessage[0] . $this->testMessage[1], $content);
    }

    public function testExceptionDuringCreateLogDirectory(): void
    {
        $this->expectExceptionMessage("Unable to create log directory: /none/exists");
        $this->expectException(\SimpleLog\LogException::class);

        $storage = new File(['log_path' => '/none/exists']);

        $storage->store($this->testMessage[0], $this->testLog);
    }

    public function testExceptionDuringSaveLogFile(): void
    {
        $this->expectException(\SimpleLog\LogException::class);
        \chmod(__DIR__ . '/../no_permission/notice.log', 0555);
        (new File(['log_path' => __DIR__ . '/../no_permission']))
            ->store($this->testMessage[0], $this->testLog);
    }

    /**
     * actions launched after test was finished
     */
    protected function tearDown(): void
    {
        if (\file_exists($this->fullTestFilePath)) {
            \unlink($this->fullTestFilePath);
        }
    }
}
