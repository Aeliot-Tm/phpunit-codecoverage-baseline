<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Writer;

/**
 * @codeCoverageIgnore
 */
final class BaselineWriter
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param array<string,int> $baseline
     */
    public function write(array $baseline): void
    {
        $content = json_encode($baseline, JSON_PRETTY_PRINT);
        if (json_last_error()) {
            throw new \LogicException(json_last_error_msg());
        }
        file_put_contents($this->path, $content);
    }
}
