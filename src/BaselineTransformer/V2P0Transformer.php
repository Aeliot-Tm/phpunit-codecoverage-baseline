<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class V2P0Transformer implements TransformerInterface
{
    public function transform(array $data): Coverage
    {
        if (!isset($data['options']) || !is_array($data['options'])) {
            throw new \InvalidArgumentException('Data does not contain valid "options" part');
        }

        return new Coverage($data['options']);
    }
}
