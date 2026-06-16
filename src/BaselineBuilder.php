<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
