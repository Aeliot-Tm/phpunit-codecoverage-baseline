<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Console;

/**
 * @codeCoverageIgnore
 */
final class GetOpt
{
    /**
     * @param string[] $longOptions
     *
     * @return array<string,mixed>|false
     */
    public function getOpt(string $shortOptions, array $longOptions = [])
    {
        return getopt($shortOptions, $longOptions);
    }
}
