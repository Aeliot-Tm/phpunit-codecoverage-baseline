<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class BaselineReaderTest extends UnitTestCase
{
    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param array<string,int> $expected
     */
    public function testPositiveFlow(array $expected, string $path): void
    {
        self::assertEquals($expected, (new BaselineReader($path))->read());
    }

    public function testThrowExceptionOnFileNotExist(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/Code coverage baseline "(.+)" does not exist\./');
        (new BaselineReader('invalid_path'))->read();
    }

    public function testThrowExceptionOnBrokenFile(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Syntax error');
        $path = __DIR__ . '/../../fixtures/baseline/baseline_invalid.json';
        (new BaselineReader($path))->read();
    }

    public function testThrowExceptionOnNotArrayFileContent(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Cannot read baseline');
        $path = __DIR__ . '/../../fixtures/baseline/baseline_not_array.json';
        (new BaselineReader($path))->read();
    }

    /**
     * @dataProvider getDataForTestThrowExceptionOnEmptyBaseline
     */
    public function testThrowExceptionOnEmptyBaseline(string $path): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Empty baseline');
        (new BaselineReader($path))->read();
    }

    /**
     * @dataProvider getDataForTestThrowExceptionWithNotIntValue
     */
    public function testThrowExceptionWithNotIntValue(string $path): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid baseline data');
        (new BaselineReader($path))->read();
    }

    /**
     * @return iterable<array{ 0: array<string,int>, 1: string }>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        yield [
            [
                'methods' => 1,
                'conditionals' => 3,
                'statements' => 5,
                'elements' => 7,
                'coveredmethods' => 2,
                'coveredconditionals' => 4,
                'coveredstatements' => 6,
                'coveredelements' => 8,
            ],
            __DIR__ . '/../../fixtures/baseline/baseline.json',
        ];

        yield [
            [
                'methods' => 1,
                'coveredmethods' => 2,
                'conditionals' => 3,
                'coveredconditionals' => 4,
                'statements' => 5,
                'coveredstatements' => 6,
                'elements' => 7,
                'coveredelements' => 8,
            ],
            __DIR__ . '/../../fixtures/baseline/baseline_with_another_fields.json',
        ];

        yield [
            [
                'methods' => 1,
                'conditionals' => 3,
                'statements' => 5,
                'elements' => 7,
            ],
            __DIR__ . '/../../fixtures/baseline/baseline_types_only.json',
        ];

        yield [
            ['conditionals' => 3],
            __DIR__ . '/../../fixtures/baseline/baseline_type_conditionals.json',
        ];

        yield [
            ['elements' => 7],
            __DIR__ . '/../../fixtures/baseline/baseline_type_elements.json',
        ];

        yield [
            ['statements' => 5],
            __DIR__ . '/../../fixtures/baseline/baseline_type_statements.json',
        ];

        yield [
            ['methods' => 1],
            __DIR__ . '/../../fixtures/baseline/baseline_type_methods.json',
        ];
    }

    /**
     * @return iterable<array<string>>
     */
    public function getDataForTestThrowExceptionOnEmptyBaseline(): iterable
    {
        yield [__DIR__ . '/../../fixtures/baseline/baseline_empty.json'];
        yield [__DIR__ . '/../../fixtures/baseline/baseline_with_another_fields_only.json'];
    }

    /**
     * @return iterable<array<string>>
     */
    public function getDataForTestThrowExceptionWithNotIntValue(): iterable
    {
        yield [__DIR__ . '/../../fixtures/baseline/baseline_with_not_int_1.json'];
        yield [__DIR__ . '/../../fixtures/baseline/baseline_with_not_int_2.json'];
        yield [__DIR__ . '/../../fixtures/baseline/baseline_with_not_int_3.json'];
        yield [__DIR__ . '/../../fixtures/baseline/baseline_with_not_int_4.json'];
    }
}
