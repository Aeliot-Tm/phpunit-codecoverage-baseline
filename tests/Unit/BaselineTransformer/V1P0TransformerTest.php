<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V1P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class V1P0TransformerTest extends UnitTestCase
{
    public function testPositiveFlow(): void
    {
        $expected = [
            'methods' => 50.0,
            'conditionals' => 0.0,
            'statements' => 100.0,
            'elements' => 100.0,
        ];
        $data = [
            'methods' => 2,
            'coveredmethods' => 1,
            'conditionals' => 2,
            'coveredconditionals' => 0,
            'statements' => 2,
            'coveredstatements' => 2,
            'elements' => 2,
            'coveredelements' => 2,
        ];

        self::assertSame($expected, iterator_to_array((new V1P0Transformer())->transform($data)));
    }
}
