<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Console;

use Symfony\Component\Console\Application as SymfonyApplication;

final class Application extends SymfonyApplication
{
    public const VERSION = '2.2.0';

    public function __construct()
    {
        parent::__construct('PHPUnit code coverage baseline', self::VERSION);
    }
}
