<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\AwareTransformer;
use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V1P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V2P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Version;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class AwareTransformerTest extends UnitTestCase
{
    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param array<string,mixed> $expected
     * @param array<string,mixed> $data
     */
    public function testPositiveFlow(array $expected, array $data): void
    {
        self::assertSame($expected, iterator_to_array($this->createAwareTransformer()->transform($data)));
    }

    /**
     * @dataProvider getDataForTestDetectedFirstVersion
     *
     * @param array<string,mixed> $data
     */
    public function testDetectedFirstVersion(array $data): void
    {
        $transformerV1 = $this->createMock(V1P0Transformer::class);
        $transformerV1->expects(self::once())->method('transform')->with($data);
        $transformerV2 = $this->createMock(V2P0Transformer::class);
        $transformerV2->expects(self::exactly(0))->method('transform');

        $transformers = [
            Version::VERSION_1 => $transformerV1,
            Version::VERSION_2 => $transformerV2,
        ];

        $awareTransformer = new AwareTransformer($transformers);
        $awareTransformer->transform($data);
    }

    /**
     * @dataProvider getDataForTestDetectedSecondVersion
     *
     * @param array<string,mixed> $data
     */
    public function testDetectedSecondVersion(array $data): void
    {
        $transformerV1 = $this->createMock(V1P0Transformer::class);
        $transformerV1->expects(self::exactly(0))->method('transform');
        $transformerV2 = $this->createMock(V2P0Transformer::class);
        $transformerV2->expects(self::once())->method('transform')->with($data);

        $transformers = [
            Version::VERSION_1 => $transformerV1,
            Version::VERSION_2 => $transformerV2,
        ];

        $awareTransformer = new AwareTransformer($transformers);
        $awareTransformer->transform($data);
    }

    /**
     * @return iterable<int,array<string|mixed>>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        yield [
            [
                'methods' => 50.0,
                'conditionals' => 0.0,
                'statements' => 100.0,
                'elements' => 100.0,
            ],
            [
                'methods' => 2,
                'coveredmethods' => 1,
                'conditionals' => 2,
                'coveredconditionals' => 0,
                'statements' => 2,
                'coveredstatements' => 2,
                'elements' => 2,
                'coveredelements' => 2,
            ],
        ];

        yield [
            [
                'a' => 50.0,
                'b' => 0.0,
                'c' => 100.0,
            ],
            [
                'version' => '2.0',
                'metrics' => [
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
                'version' => '2.0',
                'metrics' => [
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
                'version' => '2.0',
                'metrics' => [
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
     * @return iterable<array<array<string,int>>>
     */
    public function getDataForTestDetectedFirstVersion(): iterable
    {
        yield [
            [
                'methods' => 2,
                'coveredmethods' => 1,
                'conditionals' => 2,
                'coveredconditionals' => 0,
                'statements' => 2,
                'coveredstatements' => 2,
                'elements' => 2,
                'coveredelements' => 2,
            ],
        ];
        yield [
            [
                'any_key_except_version' => 2,
            ],
        ];
    }

    /**
     * @return iterable<array<array<string,mixed>>>
     */
    public function getDataForTestDetectedSecondVersion(): iterable
    {
        yield [
            [
                'version' => '2.0',
                'metrics' => [
                    'any_key' => 0.0,
                ],
            ],
        ];

        yield [
            [
                'version' => '2.0',
            ],
        ];
    }

    private function createAwareTransformer(): AwareTransformer
    {
        $transformers = [
            Version::VERSION_1 => new V1P0Transformer(),
            Version::VERSION_2 => new V2P0Transformer(),
        ];

        return new AwareTransformer($transformers);
    }
}
