<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Command;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineReaderFactory;
use Aeliot\PHPUnitCodeCoverageBaseline\CloverInputOptionsAssigner;
use Aeliot\PHPUnitCodeCoverageBaseline\Comparator;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ConsoleTable;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
final class CloverCompareCommand extends Command
{
    public function __construct()
    {
        parent::__construct('pccb:clover:compare');
    }

    protected function configure(): void
    {
        $definition = $this->getDefinition();
        CloverInputOptionsAssigner::addBaselineOption($definition);
        CloverInputOptionsAssigner::addCloverOption($definition);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $comparator = new Comparator(
            (new BaselineReaderFactory())->createReader($input->getOption('baseline')),
            new CloverReader($input->getOption('clover'))
        );

        $results = $comparator->compare();
        $exitCode = 0;
        if ($regressedTypes = $results->getRegressedNames()) {
            $exitCode = 1;
            if (!$output->isQuiet()) {
                $output->writeln(sprintf('[ERROR] There is detected regress of code coverage on types: %s.', implode(', ', $regressedTypes)));
            }
        }

        if ($output->isVerbose()) {
            $table = $this->createTable();
            $rows = $results->getRows();
            array_walk($rows, static function (ComparingRow $x) use ($table) {
                $table->addComparingRow($x);
            });

            $output->writeln($table->getContent());

            if (!$exitCode && $results->hasImprovement()) {
                $output->writeln('Good job! You improved code coverage. Update baseline.');
            }
        }

        return $exitCode;
    }

    private function createTable(): ConsoleTable
    {
        return new ConsoleTable([
            'name' => 'Metrics',
            'old' => 'Old coverage',
            'new' => 'New coverage',
            'progress' => 'Progress',
        ]);
    }
}
