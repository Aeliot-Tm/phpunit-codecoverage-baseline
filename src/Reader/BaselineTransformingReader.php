<?php

declare(strict_types=1);

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

    public function read(): Coverage
    {
        return $this->transformer->transform($this->baselineReader->read());
    }
}
