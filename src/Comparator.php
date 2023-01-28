<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\SupportedType;
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

    public function compare(): array
    {
        $baseline = $this->baselineReader->read();
        $cloverData = $this->cloverReader->read();
        $regressedTypes = [];

        foreach (SupportedType::getCoveredTypes() as $type => $typeCover) {
            if (!isset($baseline[$type])) {
                continue;
            }
            $baselineProgress = 0.0;
            $currentProgress = 0.0;

            $typeValue = $cloverData[$type];
            $typeCoverValue = $cloverData[$typeCover];
            if ($typeValue) {
                $currentProgress = $typeCoverValue / $typeValue;
            }

            if ($baseline[$type]) {
                $baselineProgress = ($baseline[$typeCover] ?? 0) / $baseline[$type];
            }

            if ($currentProgress < $baselineProgress) {
                $regressedTypes[] = $type;
            }
        }

        return $regressedTypes;
    }
}
