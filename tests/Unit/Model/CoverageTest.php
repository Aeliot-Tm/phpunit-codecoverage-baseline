<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Model;

use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;

final class CoverageTest extends UnitTestCase
{
    public function testCreatingWithEmptyArray(): void
    {
        $this->expectNotToPerformAssertions();
        new Coverage([]);
    }

    public function testTraversableFunctionality(): void
    {
        $data = ['a' => 0.0, 'b' => 100.0];
        self::assertSame($data, iterator_to_array(new Coverage($data)));
    }

    public function testCastFloatOnObjectCreate(): void
    {
        $data = ['a' => 0, 'b' => 100.0, 'c' => '2', 'd' => '2.3'];
        $expected = ['a' => 0.0, 'b' => 100.0, 'c' => 2.0, 'd' => 2.3];
        self::assertSame($expected, iterator_to_array(new Coverage($data)));
    }

    /**
     * @dataProvider getDataForTestAcceptingOfNumericValue
     *
     * @param array<int|string,mixed> $data
     */
    public function testAcceptingOfNumericValue(array $data): void
    {
        $coverage = new Coverage($data);
        self::assertSame((float) $data['a'], $coverage['a']);

        $coverage['b'] = $data['a'];
        self::assertSame((float) $data['a'], $coverage['b']);
    }

    /**
     * @dataProvider getDataForTestThrowExceptionOnNotNumericValue
     *
     * @param array<int|string,mixed> $data
     */
    public function testThrowExceptionOnNotNumericValue(array $data): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Value of ".*" is not numeric/');
        new Coverage($data);
    }

    /**
     * @dataProvider getDataForTestThrowExceptionOnNotNumericValue
     *
     * @param array<int|string,mixed> $data
     */
    public function testThrowExceptionOnNotNumericValueOnArrayAccess(array $data): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Value of ".*" is not numeric/');
        $coverage = new Coverage([]);
        $coverage['a'] = $data['a'];
    }

    public function testThrowExceptionOnArrayAccessToNotExistingOffset(): void
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Invalid offset any_key');
        (new Coverage([]))['any_key'];
    }

    public function testArrayAssess(): void
    {
        $coverage = new Coverage(['a' => 1.1, 'b' => 2.2]);

        self::assertTrue(isset($coverage['a']));
        self::assertSame(1.1, $coverage['a']);

        self::assertTrue(isset($coverage['b']));
        self::assertSame(2.2, $coverage['b']);
        unset($coverage['b']);
        self::assertFalse(isset($coverage['b']));

        self::assertFalse(isset($coverage['c']));
        $coverage['c'] = 3.3;
        self::assertTrue(isset($coverage['c']));
        self::assertSame(3.3, $coverage['c']);
    }

    public function testThrowExceptionOnArrayAccessOnNotExistingKey(): void
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Invalid offset any_key');

        $coverage = new Coverage([]);
        $coverage['any_key'];
    }

    public function getDataForTestAcceptingOfNumericValue(): iterable
    {
        foreach ($this->getNumericValues() as $value) {
            yield [['a' => $value]];
        }
    }

    public function getDataForTestThrowExceptionOnNotNumericValue(): iterable
    {
        foreach ($this->getNotNumericValues() as $value) {
            yield [['a' => $value]];
        }
    }

    public function getNumericValues(): array
    {
        return [
            1.1,
            1,
            '1',
            '1.2',
        ];
    }

    public function getNotNumericValues(): iterable
    {
        return [
            '*',
            [],
            (object) [],
            '1.1.1',
        ];
    }
}
