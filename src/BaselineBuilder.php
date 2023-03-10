<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;

final class BaselineBuilder
{
    /**
     * @var BaselineWriter
     */
    private $baselineWriter;

    /**
     * @var CloverReader
     */
    private $cloverReader;

    public function __construct(BaselineWriter $baselineWriter, CloverReader $cloverReader)
    {
        $this->baselineWriter = $baselineWriter;
        $this->cloverReader = $cloverReader;
    }

    public function build(): void
    {
        $baseline = $this->cloverReader->read();
        $this->baselineWriter->write($baseline);
    }
}
