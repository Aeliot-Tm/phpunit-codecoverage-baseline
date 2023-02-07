<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\CloverCoverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class V1P0Transformer implements TransformerInterface
{
    /**
     * @param array<string,int> $data
     *
     * @return Coverage
     */
    public function transform(array $data): Coverage
    {
        return new Coverage((new CloverCoverage($data))->getPercentage());
    }
}
