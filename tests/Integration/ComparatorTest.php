<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Integration;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineReaderFactory;
use Aeliot\PHPUnitCodeCoverageBaseline\Comparator;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;

final class ComparatorTest extends IntegrationTestCase
{
    public function testRowsValues(): void
    {
        $expected = [
            [
                'name' => 'methods',
                'old' => '  1.00 %',
                'new' => ' 50.00 %',
                'progress' => ' +49.00 %',
            ],
            [
                'name' => 'conditionals',
                'old' => ' 30.00 %',
                'new' => ' 75.00 %',
                'progress' => ' +45.00 %',
            ],
            [
                'name' => 'statements',
                'old' => ' 50.00 %',
                'new' => ' 83.33 %',
                'progress' => ' +33.33 %',
            ],
            [
                'name' => 'elements',
                'old' => ' 70.00 %',
                'new' => ' 87.50 %',
                'progress' => ' +17.50 %',
            ],
        ];
        $baselinePath = __DIR__ . '/../fixtures/baseline/baseline_v2.json';
        $baselineReader = (new BaselineReaderFactory())->createReader($baselinePath);
        $cloverPath = __DIR__ . '/../fixtures/clover/clover.xml';
        $cloverReader = new CloverReader($cloverPath);
        $results = (new Comparator($baselineReader, $cloverReader))->compare();
        $actual = array_map(static function (ComparingRow $row): array {
            return $row->getValues();
        }, $results->getRows());

        self::assertEquals($expected, $actual);
    }
}
