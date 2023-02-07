<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

interface TransformerInterface
{
    public function transform(array $data): Coverage;
}
