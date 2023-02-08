<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

interface TransformerInterface
{
    /**
     * @param array<string,mixed> $data
     *
     * @return Coverage<string,float>
     */
    public function transform(array $data): Coverage;
}
