<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Writer;

/**
 * @codeCoverageIgnore
 */
final class BaselineWriter
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param array<string,int> $baseline
     */
    public function write(array $baseline): void
    {
        file_put_contents($this->path, json_encode($baseline, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
    }
}
