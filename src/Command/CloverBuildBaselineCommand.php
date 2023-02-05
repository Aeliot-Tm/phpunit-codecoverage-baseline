<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Command;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineBuilder;
use Aeliot\PHPUnitCodeCoverageBaseline\CloverInputOptionsAssigner;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CloverBuildBaselineCommand extends Command
{
    public function __construct()
    {
        parent::__construct('pccb:clover:build-baseline');
    }

    protected function configure(): void
    {
        $definition = $this->getDefinition();
        CloverInputOptionsAssigner::addBaselineOption($definition);
        CloverInputOptionsAssigner::addCloverOption($definition);
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
