<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\SupportedType;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingResult;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;

final class Comparator
{
    private BaselineReader $baselineReader;
    private CloverReader $cloverReader;

    public function __construct(BaselineReader $baselineReader, CloverReader $cloverReader)
    {
        $this->baselineReader = $baselineReader;
        $this->cloverReader = $cloverReader;
    }

    public function compare(): ComparingResult
    {
        $baseline = $this->baselineReader->read();
        $cloverData = $this->cloverReader->read();
        $result = new ComparingResult();

        foreach (SupportedType::getCoveredTypes() as $type => $typeCover) {
            if (!isset($baseline[$type])) {
                continue;
            }
            $baselineProgress = 0.0;
            $currentProgress = 0.0;

            $typeValue = $cloverData[$type];
            if ($typeValue) {
                $typeCoverValue = $cloverData[$typeCover];
                $currentProgress = $typeCoverValue / $typeValue;
            }

            if ($baseline[$type]) {
                $baselineProgress = ($baseline[$typeCover] ?? 0) / $baseline[$type];
            }

            $result->addRow(new ComparingRow($type, $baselineProgress, $currentProgress));
        }

        return $result;
    }
}
