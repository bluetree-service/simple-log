<?php

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
    public function store($message, $level);
}
