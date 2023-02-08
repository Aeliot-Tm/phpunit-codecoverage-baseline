<?php

declare(strict_types=1);

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
