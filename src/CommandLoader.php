<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\Command\CloverBuildBaselineCommand;
use Aeliot\PHPUnitCodeCoverageBaseline\Command\CloverCompareCommand;
use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Command as CommandEnum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * @codeCoverageIgnore
 */
final class CommandLoader implements CommandLoaderInterface
{
    public function get($name): Command
    {
        switch ($name) {
            case CommandEnum::CLOVER_BUILD_BASELINE:
                return new CloverBuildBaselineCommand();
            case CommandEnum::CLOVER_COMPARE:
                return new CloverCompareCommand();
            default:
                throw new CommandNotFoundException(sprintf('Command "%s" does not exist.', $name));
        }
    }

    public function has($name): bool
    {
        return \in_array($name, CommandEnum::getAll(), true);
    }

    public function getNames(): array
    {
        return CommandEnum::getAll();
    }
}
