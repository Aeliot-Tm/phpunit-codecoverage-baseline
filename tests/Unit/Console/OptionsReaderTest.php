<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Console;

use Aeliot\PHPUnitCodeCoverageBaseline\Console\GetOpt;
use Aeliot\PHPUnitCodeCoverageBaseline\Console\OptionsConfig;
use Aeliot\PHPUnitCodeCoverageBaseline\Console\OptionsReader;
use PHPUnit\Framework\TestCase;

final class OptionsReaderTest extends TestCase
{
    /**
     * @dataProvider getDataForTestGetDefaultValues
     *
     * @param array<string,string> $expected
     * @param array<string,string|array<int,string>> $values
     * @param array<int,array<int,string>> $options
     */
    public function testGetDefaultValues(array $expected, array $values, array $options): void
    {
        $reader = $this->buildOptionsReader($options, $values);
        self::assertSame($expected, $reader->read());
    }

    /**
     * @dataProvider getDataForTestPositiveFlow
     *
     * @param array<string,string> $expected
     * @param array<string,string|array<int,string>> $values
     * @param array<int,array<int,string>> $options
     */
    public function testPositiveFlow(array $expected, array $values, array $options): void
    {
        $reader = $this->buildOptionsReader($options, $values);
        self::assertSame($expected, $reader->read());
    }

    /**
     * @dataProvider getDataForTestThrowExceptionOnDuplicates
     *
     * @param array<string,string|array<int,string>> $values
     * @param array<int,array<int,string>> $options
     */
    public function testThrowExceptionOnDuplicates(array $values, array $options): void
    {
        $this->expectException(\RuntimeException::class);

        $this->buildOptionsReader($options, $values)->read();
    }

    /**
     * @return iterable<array{ 0: array<string,string>, 1: array<int,array<string>> }>
     */
    public function getDataForTestGetDefaultValues(): iterable
    {
        $dataSetForLongNames = [[], [], []];
        $dataSetForShortNames = [[], [], []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $defaultValue = "default_$shortName";

            $dataSetForLongNames[0][$longName] = $defaultValue;
            $dataSetForLongNames[2][] = [$longName, $shortName, $defaultValue];
            yield $dataSetForLongNames;

            $dataSetForShortNames[0][$longName] = $defaultValue;
            $dataSetForShortNames[2][] = [$longName, $shortName, $defaultValue];
            yield $dataSetForShortNames;
        }
    }

    /**
     * @return iterable<array{
     *     0: array<string,string>,
     *     1: array<string,string>,
     *     2: array<int,array<string>>
     * }>
     */
    public function getDataForTestPositiveFlow(): iterable
    {
        $dataSetForLongNames = [[], [], []];
        $dataSetForShortNames = [[], [], []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $defaultValue = "default_$shortName";
            $value = "value_$shortName";

            $dataSetForLongNames[0][$longName] = $value;
            $dataSetForLongNames[1][$longName] = $value;
            $dataSetForLongNames[2][] = [$longName, $shortName, $defaultValue];
            yield $dataSetForLongNames;

            $dataSetForShortNames[0][$longName] = $value;
            $dataSetForShortNames[1][$shortName] = $value;
            $dataSetForShortNames[2][] = [$longName, $shortName, $defaultValue];
            yield $dataSetForShortNames;
        }
    }

    /**
     * @return iterable<array{ 0: array<string,string|array<string>>, 1: array<int,array<string>> }>
     */
    public function getDataForTestThrowExceptionOnDuplicates(): iterable
    {
        yield [['a' => ['value1', 'value2']], [['long_a', 'a', 'any string']]];
        yield [['a' => 'any string', 'long_a' => 'any string'], [['long_a', 'a', 'any string']]];
    }

    /**
     * @param array<int,array<int|string,string>> $options
     */
    private function buildOptionsConfig(array $options): OptionsConfig
    {
        $config = new OptionsConfig();
        foreach ($options as $datum) {
            $config->add(...$datum);
        }

        return $config;
    }

    /**
     * @param array<int,array<int,string>> $options
     * @param array<string,string|array<int,string>> $values
     */
    private function buildOptionsReader(array $options, array $values): OptionsReader
    {
        $getOpt = $this->createMock(GetOpt::class);
        $getOpt->method('getOpt')->willReturn($values);

        return new OptionsReader($this->buildOptionsConfig($options), $getOpt);
    }
}
