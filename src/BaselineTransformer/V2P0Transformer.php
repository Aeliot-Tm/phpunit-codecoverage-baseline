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

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class V2P0Transformer implements TransformerInterface
{
    public function transform(array $data): Coverage
    {
        if (!isset($data['metrics']) || !\is_array($data['metrics'])) {
            throw new \InvalidArgumentException('Data does not contain valid "metrics" part');
        }

        return new Coverage($data['metrics']);
    }
}
