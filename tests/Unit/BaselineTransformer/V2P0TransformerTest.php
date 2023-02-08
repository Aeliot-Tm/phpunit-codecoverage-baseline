<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V2P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class V2P0TransformerTest extends UnitTestCase
{
    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param array<string,float> $expected
     * @param array<string,mixed> $data
     */
    public function testPositiveFlow(array $expected, array $data): void
    {
        self::assertSame($expected, iterator_to_array((new V2P0Transformer())->transform($data)));
    }

    /**
     * @dataProvider getDataForTestThrowExceptionWithInvalidOrMissedOptions
     *
     * @param array<string,mixed> $data
     */
    public function testThrowExceptionWithInvalidOrMissedOptions(array $data): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Data does not contain valid "options" part');

        (new V2P0Transformer())->transform($data);
    }

    /**
     * @return iterable<int,array<string,mixed>>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        yield [
            [
                'a' => 50.0,
                'b' => 0.0,
                'c' => 100.0,
            ],
            [
                'options' => [
                    'a' => 50.0,
                    'b' => 0.0,
                    'c' => 100.0,
                ],
            ],
        ];

        yield [
            [
                'methods' => 50.0,
                'conditionals' => 0.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
            [
                'options' => [
                    'methods' => 50.0,
                    'conditionals' => 0.0,
                    'statements' => 100.0,
                    'elements' => 100.0,
                ],
            ],
        ];

        yield [
            [
                'methods' => 2.0,
                'coveredmethods' => 1.0,
                'conditionals' => 2.0,
                'coveredconditionals' => 0.0,
                'statements' => 2.0,
                'coveredstatements' => 2.0,
                'elements' => 2.0,
                'coveredelements' => 2.0,
            ],
            [
                'options' => [
                    'methods' => 2,
                    'coveredmethods' => 1,
                    'conditionals' => 2,
                    'coveredconditionals' => 0,
                    'statements' => 2,
                    'coveredstatements' => 2,
                    'elements' => 2,
                    'coveredelements' => 2,
                ],
            ],
        ];
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public function getDataForTestThrowExceptionWithInvalidOrMissedOptions(): iterable
    {
        yield [[]];
        yield [[
            'methods' => 2,
            'coveredmethods' => 1,
            'conditionals' => 2,
            'coveredconditionals' => 0,
            'statements' => 2,
            'coveredstatements' => 2,
            'elements' => 2,
            'coveredelements' => 2,
        ]];
    }
}
