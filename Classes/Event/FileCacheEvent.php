<?php

namespace FRUIT\FlRealurlImage\Event;

readonly class FileCacheEvent
{
    public function __construct(
        protected string $originalFileName,
        protected string $newFileName
    ) {}

    public function getOriginalFileName(): string
    {
        return $this->originalFileName;
    }

    public function getNewFileName(): string
    {
        return $this->newFileName;
    }
}
