<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use Aeliot\PHPUnitCodeCoverageBaseline\Comparator;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use PHPUnit\Framework\TestCase;

final class ComparatorTest extends TestCase
{
    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param string[] $expected
     * @param array<string,int> $baseline
     * @param array<string,int> $cloverData
     */
    public function testRegressedNamesPositiveFlow(array $expected, array $baseline, array $cloverData): void
    {
        $baselineReader = $this->createMock(BaselineReader::class);
        $baselineReader->method('read')->willReturn($baseline);
        $cloverReader = $this->createMock(CloverReader::class);
        $cloverReader->method('read')->willReturn($cloverData);
        $comparator = new Comparator($baselineReader, $cloverReader);

        self::assertSame($expected, $comparator->compare()->getRegressedNames());
    }

    /**
     * @return iterable<array{
     *      0: array<string>,
     *      1: array<string,int>,
     *      2: array<string,int>
     * }>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        yield [
            [],
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ],
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 0,
                'conditionals' => 0,
            ],
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [
                'methods',
            ],
            [
                'methods' => 1,
                'coveredmethods' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [
                'conditionals',
            ],
            [
                'conditionals' => 1,
                'coveredconditionals' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [
                'statements',
            ],
            [
                'statements' => 1,
                'coveredstatements' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [
                'elements',
            ],
            [
                'elements' => 1,
                'coveredelements' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [
                'methods',
                'conditionals',
                'statements',
                'elements',
            ],
            [
                'methods' => 1,
                'coveredmethods' => 1,
                'conditionals' => 1,
                'coveredconditionals' => 1,
                'statements' => 1,
                'coveredstatements' => 1,
                'elements' => 1,
                'coveredelements' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 1,
                'coveredmethods' => 1,
                'conditionals' => 1,
                'coveredconditionals' => 1,
                'statements' => 1,
                'coveredstatements' => 1,
                'elements' => 1,
                'coveredelements' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 1,
                'conditionals' => 1,
                'coveredconditionals' => 1,
                'statements' => 1,
                'coveredstatements' => 1,
                'elements' => 1,
                'coveredelements' => 1,
            ],
        ];

        yield [
            [],
            [
                'methods' => 1,
                'coveredmethods' => 0,
                'conditionals' => 1,
                'coveredconditionals' => 0,
                'statements' => 1,
                'coveredstatements' => 0,
                'elements' => 1,
                'coveredelements' => 0,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 1,
                'conditionals' => 1,
                'coveredconditionals' => 1,
                'statements' => 1,
                'coveredstatements' => 1,
                'elements' => 1,
                'coveredelements' => 1,
            ],
        ];

        yield [
            [],
            [
                'methods' => 1,
                'conditionals' => 1,
                'statements' => 1,
                'elements' => 1,
            ],
            [
                'methods' => 1,
                'coveredmethods' => 1,
                'conditionals' => 1,
                'coveredconditionals' => 1,
                'statements' => 1,
                'coveredstatements' => 1,
                'elements' => 1,
                'coveredelements' => 1,
            ],
        ];
    }
}
