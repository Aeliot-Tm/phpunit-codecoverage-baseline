<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Enum;

final class Version
{
    public const CURRENT = self::VERSION_2;
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
    public function __unserialize(array $data): void
    {
        // forbid creating of an instance
        throw new \DomainException(\sprintf('It is forbidden to create an instance of %s', __CLASS__));
    }
}
