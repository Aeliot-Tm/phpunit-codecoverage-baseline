<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\CloverCoverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class V1P0Transformer implements TransformerInterface
{
    public function transform(array $data): Coverage
    {
        return new Coverage((new CloverCoverage($data))->getPercentage());
    }
}
