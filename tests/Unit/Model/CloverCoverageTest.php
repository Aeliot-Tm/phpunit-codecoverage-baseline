<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Model;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\CloverCoverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class CloverCoverageTest extends UnitTestCase
{
    /**
     * @dataProvider getDataForTestPercentage
     *
     * @param array<string,float> $expected
     * @param array<string,mixed> $data
     */
    public function testPercentage(array $expected, array $data): void
    {
        self::assertSame($expected, (new CloverCoverage($data))->getPercentage());
    }

    /**
     * @dataProvider getDataForTestThrowsExceptionOnMissedTypesAndPresentedCoveredPair
     *
     * @param array<string,int> $data
     */
    public function testThrowsExceptionOnMissedTypesAndPresentedCoveredPair(array $data): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/^Missed types detected: /');
        (new CloverCoverage($data))->getPercentage();
    }

    /**
     * @return iterable<array<array<string,mixed>>>
     */
    public function getDataForTestPercentage(): iterable
    {
        yield 'covered 0% on zero types' => [
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
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
        yield 'covered 0% on filled types' => [
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
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

        yield 'covered 100%' => [
            [
                'methods' => 100.0,
                'conditionals' => 100.0,
                'statements' => 100.0,
                'elements' => 100.0,
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

        yield 'covered 0% on missed "covered.." options' => [
            [
                'methods' => 0.0,
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'methods' => 1,
                'conditionals' => 1,
                'statements' => 1,
                'elements' => 1,
            ],
        ];

        yield 'missed option "methods" with its "covered.." option' => [
            [
                'conditionals' => 0.0,
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ],
        ];

        yield 'missed option "methods" & "conditionals" with their "covered.." options' => [
            [
                'statements' => 0.0,
                'elements' => 0.0,
            ],
            [
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ],
        ];

        yield 'empty data' => [
            [],
            [],
        ];
    }

    /**
     * @return iterable<array<array<string,mixed>>>
     */
    public function getDataForTestThrowsExceptionOnMissedTypesAndPresentedCoveredPair(): iterable
    {
        yield [
            [
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ]
        ];
        yield [
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ]
        ];
        yield [
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'coveredstatements' => 0,
                'elements' => 0,
                'coveredelements' => 0,
            ]
        ];
        yield [
            [
                'methods' => 0,
                'coveredmethods' => 0,
                'conditionals' => 0,
                'coveredconditionals' => 0,
                'statements' => 0,
                'coveredstatements' => 0,
                'coveredelements' => 0,
            ]
        ];
        yield [
            [
                'coveredmethods' => 0,
                'coveredconditionals' => 0,
                'coveredstatements' => 0,
                'coveredelements' => 0,
            ]
        ];
    }
}
