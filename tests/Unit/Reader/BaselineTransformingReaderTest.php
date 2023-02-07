<?php

declare(strict_types=1);

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
