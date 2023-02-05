<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Enum;

final class Version
{
    public const CURRENT = self::VERSION_1;
    public const VERSION_1 = '1';

    private function __construct()
    {
        // forbid creating of an instance
    }

    private function __clone()
    {
        // forbid creating of an instance
    }

    public function __wakeup()
    {
        // forbid creating of an instance
        throw new \DomainException(sprintf('It is forbidden to create an instance of %s', __CLASS__));
    }
}
