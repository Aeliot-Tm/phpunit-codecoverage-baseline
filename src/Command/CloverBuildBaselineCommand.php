<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Command;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineBuilder;
use Aeliot\PHPUnitCodeCoverageBaseline\CloverInputOptionsAssigner;
use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Command as CommandEnum;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
final class CloverBuildBaselineCommand extends Command
{
    public function __construct()
    {
        parent::__construct(CommandEnum::CLOVER_BUILD_BASELINE);
    }

    protected function configure(): void
    {
        $definition = $this->getDefinition();
        CloverInputOptionsAssigner::addBaselineOption($definition);
        CloverInputOptionsAssigner::addCloverOption($definition);
        CloverInputOptionsAssigner::addPrecisionOption($definition);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $builder = new BaselineBuilder(
            new BaselineWriter($input->getOption('baseline')),
            new CloverReader($input->getOption('clover'))
        );

        $builder->build();

        return 0;
    }
}
