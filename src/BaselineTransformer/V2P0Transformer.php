<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class V2P0Transformer implements TransformerInterface
{
    public function transform(array $data): Coverage
    {
        if (!isset($data['metrics']) || !is_array($data['metrics'])) {
            throw new \InvalidArgumentException('Data does not contain valid "metrics" part');
        }

        return new Coverage($data['metrics']);
    }
}
