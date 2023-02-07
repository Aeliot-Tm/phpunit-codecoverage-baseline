<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Enum;

final class Version
{
    public const CURRENT = self::VERSION_1;
    public const VERSION_1 = '1.0';
    public const VERSION_2 = '2.0';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // forbid creating of an instance
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
        // forbid creating of an instance
    }

    /**
     * @codeCoverageIgnore
     */
    public function __wakeup()
    {
        // forbid creating of an instance
        throw new \DomainException(sprintf('It is forbidden to create an instance of %s', __CLASS__));
    }
}
