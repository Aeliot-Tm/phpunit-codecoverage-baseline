<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineBuilder;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;
use PHPUnit\Framework\TestCase;

final class BaselineBuilderTest extends TestCase
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
