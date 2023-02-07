<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingResult;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineTransformingReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;

final class Comparator
{
    /**
     * @var BaselineTransformingReader
     */
    private $baselineReader;

    /**
     * @var CloverReader
     */
    private $cloverReader;

    public function __construct(BaselineTransformingReader $baselineReader, CloverReader $cloverReader)
    {
        $this->baselineReader = $baselineReader;
        $this->cloverReader = $cloverReader;
    }

    public function compare(): ComparingResult
    {
        $baseline = $this->baselineReader->read();
        $cloverData = $this->cloverReader->read();
        $result = new ComparingResult();

        foreach ($cloverData as $type => $currentProgress) {
            if (!isset($baseline[$type])) {
                continue;
            }

            $result->addRow(new ComparingRow($type, $baseline[$type], $currentProgress));
        }

        return $result;
    }
}
