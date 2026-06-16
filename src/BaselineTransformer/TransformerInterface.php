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

interface TransformerInterface
{
    /**
     * @param array<string,mixed> $data
     *
     * @return Coverage<string,float>
     */
    public function transform(array $data): Coverage;
}
