<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * @codeCoverageIgnore
 */
final class CloverInputOptionsAssigner
{
    public static function addBaselineOption(InputDefinition $definition): void
    {
        $definition->addOption(new InputOption(
            'baseline',
            'b',
            InputOption::VALUE_REQUIRED,
            'Path to the baseline of the CLover report',
            'phpunit.clover.baseline.json'
        ));
    }

    public static function addCloverOption(InputDefinition $definition): void
    {
        $definition->addOption(new InputOption(
            'clover',
            'c',
            InputOption::VALUE_REQUIRED,
            'Path to the CLover report',
            'build/coverage/clover.xml'
        ));
    }
}
