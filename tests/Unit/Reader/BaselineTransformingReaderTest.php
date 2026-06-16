<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\AwareTransformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineTransformingReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class BaselineTransformingReaderTest extends UnitTestCase
{
    public function testPositiveFlow(): void
    {
        $data = ['any_key' => 'value'];
        $baselineReader = $this->createMock(BaselineReader::class);
        $baselineReader->expects(self::once())->method('read')->willReturn($data);

        $awareTransformer = $this->createMock(AwareTransformer::class);
        $awareTransformer->expects(self::once())->method('transform')->with($data)->willReturn(new Coverage([]));

        $transformingReader = new BaselineTransformingReader($baselineReader, $awareTransformer);
        $transformingReader->read();
    }
}
