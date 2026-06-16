<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineBuilder;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;

final class BaselineBuilderTest extends UnitTestCase
{
    public function testPositiveFlow(): void
    {
        $data = new Coverage(['a' => 10.0, 'b' => 20.0]);

        $baselineWriter = $this->createMock(BaselineWriter::class);
        $baselineWriter->expects(self::once())->method('write')->with($data);

        $cloverReader = $this->createMock(CloverReader::class);
        $cloverReader->expects(self::once())->method('read')->willReturn($data);

        (new BaselineBuilder($baselineWriter, $cloverReader))->build();
    }
}
