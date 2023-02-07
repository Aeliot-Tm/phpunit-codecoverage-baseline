<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use Aeliot\PHPUnitCodeCoverageBaseline\Comparator;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineTransformingReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use PHPUnit\Framework\TestCase;

final class ComparatorTest extends TestCase
{
    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param string[] $expected
     * @param array<string,float> $baseline
     * @param array<string,float> $cloverData
     */
    public function testRegressedNamesPositiveFlow(array $expected, array $baseline, array $cloverData): void
    {
        $baselineReader = $this->createMock(BaselineTransformingReader::class);
        $baselineReader->method('read')->willReturn(new Coverage($baseline));
        $cloverReader = $this->createMock(CloverReader::class);
        $cloverReader->method('read')->willReturn(new Coverage($cloverData));
        $comparator = new Comparator($baselineReader, $cloverReader);

        self::assertSame($expected, $comparator->compare()->getRegressedNames());
    }

    /**
     * @return iterable<array{
     *      0: array<string>,
     *      1: array<string,float>,
     *      2: array<string,float>
     * }>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        yield [
            [],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [
                'methods',
            ],
            [
                'methods' => 100.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [
                'conditionals',
            ],
            [
                'conditionals' => 100.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [
                'statements',
            ],
            [
                'statements' => 100.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [
                'elements',
            ],
            [
                'elements' => 100.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
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
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
            [
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
        ];

        yield [
            [],
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
        ];
    }
}
