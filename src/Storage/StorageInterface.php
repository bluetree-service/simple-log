<?php

declare(strict_types=1);

namespace SimpleLog\Storage;

interface StorageInterface
{
    /**
     * StorageInterface constructor.
     *
     * @param array $params
     */
    public function __construct(array $params);

    /**
     * @param string $message
     * @param string $level
     * @return StorageInterface
     */
    public function store(string $message, string $level): StorageInterface;
}
