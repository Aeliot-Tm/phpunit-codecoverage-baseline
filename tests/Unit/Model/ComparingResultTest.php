<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Model;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingResult;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class ComparingResultTest extends UnitTestCase
{
    public function testImproveDetecting(): void
    {
        $comparingResult = new ComparingResult();
        self::assertFalse($comparingResult->hasImprovement());

        $comparingResult->addRow(new ComparingRow('any string', 0, 0));
        self::assertFalse($comparingResult->hasImprovement());

        $comparingResult->addRow(new ComparingRow('any string', 1, 0));
        self::assertFalse($comparingResult->hasImprovement());

        $comparingResult->addRow(new ComparingRow('any string', 0, 1));
        self::assertTrue($comparingResult->hasImprovement());
    }

    public function testRegressDetecting(): void
    {
        $comparingResult = new ComparingResult();
        self::assertSame([], $comparingResult->getRegressedNames());

        $comparingResult->addRow(new ComparingRow('a', 0, 0));
        self::assertSame([], $comparingResult->getRegressedNames());

        $comparingResult->addRow(new ComparingRow('b', 1, 0));
        self::assertSame(['b'], $comparingResult->getRegressedNames());

        $comparingResult->addRow(new ComparingRow('c', 0, 1));
        self::assertSame(['b'], $comparingResult->getRegressedNames());

        $comparingResult->addRow(new ComparingRow('d', 1, 0));
        self::assertSame(['b', 'd'], $comparingResult->getRegressedNames());
    }

    public function testGetRows(): void
    {
        $expected = [];
        $comparingResult = new ComparingResult();
        $comparingResult->addRow($expected[] = new ComparingRow('a', 0, 0));
        $comparingResult->addRow($expected[] = new ComparingRow('b', 1, 0));
        $comparingResult->addRow($expected[] = new ComparingRow('c', 0, 1));

        self::assertSame($expected, $comparingResult->getRows());
    }
}
