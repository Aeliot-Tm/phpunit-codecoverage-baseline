<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Functional\Command;

use Aeliot\PHPUnitCodeCoverageBaseline\Test\Functional\FunctionalTestCase;

final class CloverCompareCommandTest extends FunctionalTestCase
{
    public function testPositiveFlow(): void
    {
        $command = 'bin/pccb pccb:clover:compare -vv'
            . ' -b tests/fixtures/baseline/baseline_v2.json'
            . ' -c tests/fixtures/clover/clover.xml';
        exec($command, $output, $resultCode);

        $expected = <<<OUTPUT
|--------------|--------------|--------------|-----------|
| Metrics      | Old coverage | New coverage | Progress  |
|--------------|--------------|--------------|-----------|
| methods      |   1.00 %     |  50.00 %     |  +49.00 % |
| conditionals |  30.00 %     |  75.00 %     |  +45.00 % |
| statements   |  50.00 %     |  83.33 %     |  +33.33 % |
| elements     |  70.00 %     |  87.50 %     |  +17.50 % |
|--------------|--------------|--------------|-----------|

Good job! You improved code coverage. Update baseline.
OUTPUT;

        self::assertEquals(0, $resultCode);
        self::assertEquals($expected, implode(PHP_EOL, $output));
    }
}
