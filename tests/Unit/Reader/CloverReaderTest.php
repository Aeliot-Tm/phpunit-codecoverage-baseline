<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\Reader\CloverReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class CloverReaderTest extends UnitTestCase
{
    public function testPositiveFlow(): void
    {
        $path = __DIR__ . '/../../fixtures/clover/clover.xml';
        $expected = [
            'methods' => 50.0,
            'conditionals' => 75.0,
            'statements' => 83.33,
            'elements' => 87.5,
        ];
        self::assertEquals($expected, iterator_to_array((new CloverReader($path))->read()));
    }

    public function testThrowExceptionOnFileNotExist(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/Coverage clover file "(.+)" does not exist. Maybe it is not calculated yet\./');
        (new CloverReader('invalid_path'))->read();
    }

    public function testThrowExceptionOnBrokenFile(): void
    {
        $this->expectWarning();
        $this->expectWarningMessageMatches('/parser error/');
        $path = __DIR__ . '/../../fixtures/clover/clover_invalid.xml';
        (new CloverReader($path))->read();
    }

    public function testThrowExceptionOnEmptyCloverData(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Empty clover data');
        $path = __DIR__ . '/../../fixtures/clover/clover_without_required_attributes.xml';
        (new CloverReader($path))->read();
    }

    /**
     * @dataProvider getDataForTestThrowExceptionWithoutMetrics
     */
    public function testThrowExceptionWithoutMetrics(string $path): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot find tag "metrics" of the project.');
        (new CloverReader($path))->read();
    }

    /**
     * @return iterable<array<int,string>>
     */
    public function getDataForTestThrowExceptionWithoutMetrics(): iterable
    {
        yield [__DIR__ . '/../../fixtures/clover/clover_without_metrics.xml'];
        yield [__DIR__ . '/../../fixtures/clover/clover_without_project.xml'];
        yield [__DIR__ . '/../../fixtures/clover/clover_with_another_document.xml'];
        yield [__DIR__ . '/../../fixtures/clover/clover_with_xml_only.xml'];
    }
}
