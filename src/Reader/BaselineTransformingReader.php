<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\AwareTransformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class BaselineTransformingReader implements BaselineReaderInterface
{
    /**
     * @var BaselineReader
     */
    private $baselineReader;
    /**
     * @var AwareTransformer
     */
    private $transformer;

    public function __construct(BaselineReader $baselineReader, AwareTransformer $transformer)
    {
        $this->baselineReader = $baselineReader;
        $this->transformer = $transformer;
    }

    /**
     * @return Coverage<string,float>
     */
    public function read(): Coverage
    {
        return $this->transformer->transform($this->baselineReader->read());
    }
}
