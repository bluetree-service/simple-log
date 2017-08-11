<?php

namespace SimpleLog\Storage;

interface StorageInterface
{
    public function store($message, $level);
}
