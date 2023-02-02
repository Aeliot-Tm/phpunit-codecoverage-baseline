<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Model;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use PHPUnit\Framework\TestCase;

final class ComparingRowTest extends TestCase
{
    public function testContainingOfProgress(): void
    {
        $row = new ComparingRow('any string', 0.1, 0.2);
        self::assertFalse($row->hasRegress());
        self::assertTrue($row->hasProgress());
    }

    public function testContainingOfRegress(): void
    {
        $row = new ComparingRow('any string', 0.2, 0.1);
        self::assertFalse($row->hasProgress());
        self::assertTrue($row->hasRegress());
    }

    /**
     * @dataProvider getDataForTestNumbersFormattingOnJsonSerialise
     *
     * @param array<string,string> $expectedResult
     */
    public function testNumbersFormattingOnJsonSerialise(array $expectedResult, float $old, float $new): void
    {
        $row = new ComparingRow($expectedResult['name'], $old, $new);
        self::assertSame($expectedResult, $row->getValues());
    }

    /**
     * @return iterable<array{ 0: array<string,string>, 1: float, 2: float }>
     */
    public function getDataForTestNumbersFormattingOnJsonSerialise(): iterable
    {
        yield 'no coverage' => [
            [
                'name' => 'any string',
                'old' => '  0.00 %',
                'new' => '  0.00 %',
                'progress' => '   0.00 %',
            ],
            0.0,
            0.0,
        ];
        yield 'no changes' => [
            [
                'name' => 'any string',
                'old' => ' 10.00 %',
                'new' => ' 10.00 %',
                'progress' => '   0.00 %',
            ],
            0.1,
            0.1,
        ];

        yield '+100 %' => [
            [
                'name' => 'any string',
                'old' => '  0.00 %',
                'new' => '100.00 %',
                'progress' => '+100.00 %',
            ],
            0.0,
            1.0,
        ];

        yield '-100 %' => [
            [
                'name' => 'any string',
                'old' => '100.00 %',
                'new' => '  0.00 %',
                'progress' => '-100.00 %',
            ],
            1.0,
            0.0,
        ];

        yield 'smallest difference' => [
            [
                'name' => 'any string',
                'old' => '  0.01 %',
                'new' => '  0.10 %',
                'progress' => '  +0.09 %',
            ],
            0.0001,
            0.001,
        ];

        yield 'not showable difference' => [
            [
                'name' => 'any string',
                'old' => '  0.00 %',
                'new' => '  0.01 %',
                'progress' => '  +0.01 %',
            ],
            0.00001,
            0.0001,
        ];
    }
}
