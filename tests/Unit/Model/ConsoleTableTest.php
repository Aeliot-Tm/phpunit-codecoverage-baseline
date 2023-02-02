<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Model;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\ComparingRow;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\ConsoleTable;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class ConsoleTableTest extends UnitTestCase
{
    /**
     * @dataProvider getDataForTestAddComparingPositiveFlow
     *
     * @param array<int|string,string> $columns
     * @param array<int|string,string> $values
     */
    public function testAddComparingRowPositiveFlow(string $expected, array $columns, array $values): void
    {
        self::assertSame($expected, $this->getContentOfMockedComparingRow($values, $columns));
    }

    /**
     * @dataProvider getDataForTestAddComparingRowSortsValues
     *
     * @param array<int|string,string> $columns
     * @param array<int|string,string> $values
     */
    public function testAddComparingRowSortsValues(string $expected, array $columns, array $values): void
    {
        self::assertSame($expected, $this->getContentOfMockedComparingRow($values, $columns));
    }

    /**
     * @dataProvider getDataForTestAddComparingRowThrowsExceptionOnInvalidKey
     *
     * @param array<int|string,string> $columns
     * @param array<int|string,string> $values
     */
    public function testAddComparingRowThrowsExceptionOnInvalidKey(array $columns, array $values): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/row does not contain column/i');
        $this->getContentOfMockedComparingRow($values, $columns);
    }

    /**
     * @dataProvider getDataForTestAddComparingRowThrowsExceptionOnExtraKey
     *
     * @param array<int|string,string> $columns
     * @param array<int|string,string> $values
     */
    public function testAddComparingRowThrowsExceptionOnExtraKey(array $columns, array $values): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/row contain extra column\(s\):/i');
        $this->getContentOfMockedComparingRow($values, $columns);
    }

    /**
     * @dataProvider getDataForTestAddLineThrowsExceptionOnValuesCountNotSameAsColumns
     *
     * @param string[] $columns
     * @param string[] $values
     */
    public function testAddLineThrowsExceptionOnValuesCountNotSameAsColumns(array $columns, array $values): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid values count');
        $this->getContentOfLineValues($columns, $values);
    }

    /**
     * @dataProvider getDataForTestExtendsByColumn
     *
     * @param string[] $columns
     * @param string[] $values
     */
    public function testExtendsByColumn(string $expected, array $columns, array $values): void
    {
        self::assertSame($expected, $this->getContentOfLineValues($columns, $values));
    }

    /**
     * @dataProvider getDataForTestExtendsByValue
     *
     * @param string[] $columns
     * @param string[] $values
     */
    public function testExtendsByValue(string $expected, array $columns, array $values): void
    {
        self::assertSame($expected, $this->getContentOfLineValues($columns, $values));
    }

    /**
     * @dataProvider getDataForTestPrintHeaders
     *
     * @param string[] $columns
     */
    public function testPrintHeaders(string $expected, array $columns): void
    {
        self::assertSame($expected, (new ConsoleTable($columns))->getContent());
    }

    /**
     * @return iterable<array{ 0: string, 1: array<int|string,string>, 2: array<int|string,string> }>
     */
    public function getDataForTestAddComparingPositiveFlow(): iterable
    {
        yield 'with string keys' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c1' => 'Value 1',
                'c2' => 'Value 2',
            ],
        ];

        yield 'with int keys' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'Column 1',
                'Column 2',
            ],
            [
                'Value 1',
                'Value 2',
            ],
        ];
    }

    /**
     * @return iterable<array{ 0: string, 1: array<int|string,string>, 2: array<int|string,string> }>
     */
    public function getDataForTestAddComparingRowSortsValues(): iterable
    {
        yield 'string keys, sorted columns & values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c1' => 'Value 1',
                'c2' => 'Value 2',
            ],
        ];

        yield 'string keys, sorted columns, not sorted values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c2' => 'Value 2',
                'c1' => 'Value 1',
            ],
        ];

        yield 'string keys, reversed columns, sorted values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 2 | Column 1 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 2  | Value 1  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'c2' => 'Column 2',
                'c1' => 'Column 1',
            ],
            [
                'c1' => 'Value 1',
                'c2' => 'Value 2',
            ],
        ];

        yield 'int keys, sorted columns & values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                1 => 'Column 1',
                2 => 'Column 2',
            ],
            [
                1 => 'Value 1',
                2 => 'Value 2',
            ],
        ];

        yield 'int keys, sorted columns, not sorted values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 1 | Column 2 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 1  | Value 2  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                1 => 'Column 1',
                2 => 'Column 2',
            ],
            [
                2 => 'Value 2',
                1 => 'Value 1',
            ],
        ];

        yield 'int keys, reversed columns, sorted values' => [
            '|----------|----------|' . PHP_EOL .
            '| Column 2 | Column 1 |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL .
            '| Value 2  | Value 1  |' . PHP_EOL .
            '|----------|----------|' . PHP_EOL,
            [
                'c2' => 'Column 2',
                'c1' => 'Column 1',
            ],
            [
                'c1' => 'Value 1',
                'c2' => 'Value 2',
            ],
        ];
    }

    /**
     * @return iterable<array{ 0: array<int|string,string>, 1: array<int|string,string> }>
     */
    public function getDataForTestAddComparingRowThrowsExceptionOnInvalidKey(): iterable
    {
        yield [
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c1' => 'Value 1',
            ],
        ];

        yield [
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c1' => 'Value 1',
                'c3' => 'Value 3',
            ],
        ];

        yield [
            [
                1 => 'Column 1',
                2 => 'Column 2',
            ],
            [
                1 => 'Value 1',
            ],
        ];

        yield [
            [
                1 => 'Column 1',
                2 => 'Column 2',
            ],
            [
                1 => 'Value 1',
                3 => 'Value 3',
            ],
        ];
    }

    /**
     * @return iterable<array{ 0: array<int|string,string>, 1: array<int|string,string> }>
     */
    public function getDataForTestAddComparingRowThrowsExceptionOnExtraKey(): iterable
    {
        yield [
            [
                'c1' => 'Column 1',
                'c2' => 'Column 2',
            ],
            [
                'c1' => 'Value 1',
                'c2' => 'Value 2',
                'c3' => 'Value 3',
            ],
        ];

        yield [
            [
                1 => 'Column 1',
                2 => 'Column 2',
            ],
            [
                1 => 'Value 1',
                2 => 'Value 2',
                3 => 'Value 3',
            ],
        ];
    }

    /**
     * @return iterable<array{ 0: array<string>, 1: array<string> }>
     */
    public function getDataForTestAddLineThrowsExceptionOnValuesCountNotSameAsColumns(): iterable
    {
        yield [['Column 1', 'Column 2'], ['Value 1']];
        yield [['Column 1', 'Column 2'], ['Value 1', 'Value 2', 'Value 3']];
    }

    /**
     * @return iterable<array{ 0: string, 1: array<string>, 2: array<string> }>
     */
    public function getDataForTestExtendsByColumn(): iterable
    {
        yield [
            '|-------------|' . PHP_EOL .
            '| long column |' . PHP_EOL .
            '|-------------|' . PHP_EOL .
            '| any         |' . PHP_EOL .
            '|-------------|' . PHP_EOL,
            ['long column'],
            ['any'],
        ];
        yield [
            '|---------------|--------|' . PHP_EOL .
            '| long column 1 | long 2 |' . PHP_EOL .
            '|---------------|--------|' . PHP_EOL .
            '| any           | any    |' . PHP_EOL .
            '|---------------|--------|' . PHP_EOL,
            ['long column 1', 'long 2'],
            ['any', 'any'],
        ];
    }

    /**
     * @return iterable<array{ 0: string, 1: array<string>, 2: array<string> }>
     */
    public function getDataForTestExtendsByValue(): iterable
    {
        yield [
            '|------------|' . PHP_EOL .
            '| any        |' . PHP_EOL .
            '|------------|' . PHP_EOL .
            '| long value |' . PHP_EOL .
            '|------------|' . PHP_EOL,
            ['any'],
            ['long value'],
        ];
        yield [
            '|--------------|--------------|' . PHP_EOL .
            '| any          | any 2        |' . PHP_EOL .
            '|--------------|--------------|' . PHP_EOL .
            '| long value 1 | another long |' . PHP_EOL .
            '|--------------|--------------|' . PHP_EOL,
            ['any', 'any 2'],
            ['long value 1', 'another long'],
        ];
    }

    /**
     * @return iterable<array{ 0: string, 1: array<string> }>
     */
    public function getDataForTestPrintHeaders(): iterable
    {
        yield [
            '|---|' . PHP_EOL .
            '| a |' . PHP_EOL .
            '|---|' . PHP_EOL .
            '|---|' . PHP_EOL,
            ['a'],
        ];
        yield [
            '|---|---|' . PHP_EOL .
            '| a | b |' . PHP_EOL .
            '|---|---|' . PHP_EOL .
            '|---|---|' . PHP_EOL,
            ['a', 'b'],
        ];
    }

    /**
     * @param array<int|string,string> $values
     */
    private function createComparingRowMockWithValueReturn(array $values): ComparingRow
    {
        $comparingRow = $this->createMock(ComparingRow::class);
        $comparingRow->method('getValues')->willReturn($values);

        return $comparingRow;
    }

    /**
     * @param array<int|string,string> $columns
     * @param array<int|string,string> $values
     */
    private function getContentOfMockedComparingRow(array $values, array $columns): string
    {
        $comparingRow = $this->createComparingRowMockWithValueReturn($values);
        $table = new ConsoleTable($columns);
        $table->addComparingRow($comparingRow);

        return $table->getContent();
    }

    /**
     * @param string[] $columns
     * @param string[] $values
     */
    private function getContentOfLineValues(array $columns, array $values): string
    {
        $table = new ConsoleTable($columns);
        $table->addLine(...$values);

        return $table->getContent();
    }
}
