<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineBuilder;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;
use PHPUnit\Framework\TestCase;

final class BaselineBuilderTest extends TestCase
{
    public function testPositiveFlow(): void
    {
        $data = ['a' => 1, 'b' => 2];

        $baselineWriter = $this->createMock(BaselineWriter::class);
        $baselineWriter->expects($this->once())->method('write')->with($data);

        $cloverReader = $this->createMock(CloverReader::class);
        $cloverReader->expects($this->once())->method('read')->willReturn($data);

        (new BaselineBuilder($baselineWriter, $cloverReader))->build();
    }
}
