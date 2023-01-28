<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Console;

use Aeliot\PHPUnitCodeCoverageBaseline\Console\OptionsConfig;
use PHPUnit\Framework\TestCase;

final class OptionsConfigTest extends TestCase
{
    /**
     * @dataProvider getDataForTestAliases
     *
     * @param array<string,string> $expected
     * @param array<int,array<int,string>> $options
     */
    public function testAliases(array $expected, array $options): void
    {
        $config = $this->buildOptionsConfig($options);
        self::assertSame($expected, $config->getAliases());
    }

    /**
     * @dataProvider getDataForTestOptions
     *
     * @param array<string,array<string,string>> $expected
     * @param array<int,array<int,string>> $options
     */
    public function testOptions(array $expected, array $options): void
    {
        $config = $this->buildOptionsConfig($options);
        $actual = $config->getOptions();
        ksort($actual);
        ksort($expected);
        self::assertSame($expected, $actual);
    }

    /**
     * @dataProvider getDataForTestPrepareLongOptions
     *
     * @param array<int,string> $expected
     * @param array<int,array<int,string>> $options
     */
    public function testPrepareLongOptions(array $expected, array $options): void
    {
        $config = $this->buildOptionsConfig($options);
        self::assertSame($expected, $config->prepareLongOptions());
    }

    /**
     * @dataProvider getDataForTestPrepareShortOptions
     *
     * @param array<int,array<int,string>> $options
     */
    public function testPrepareShortOptions(string $expected, array $options): void
    {
        $config = $this->buildOptionsConfig($options);
        self::assertSame($expected, $config->prepareShortOptions());
    }

    /**
     * @dataProvider getDataForTestThrowExceptionOnDuplicateName
     *
     * @param array<int,array<int,string>> $options
     */
    public function testThrowExceptionOnDuplicateName(array $options): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->buildOptionsConfig($options);
    }

    public function testThrowExceptionOnInvalidShortName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new OptionsConfig())->add('any_key', 'aa', 'any string');
    }

    public function getDataForTestAliases(): iterable
    {
        $dataSet = [[], []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $dataSet[0][$shortName] = $longName;
            $dataSet[1][] = [$longName, $shortName, 'any string'];
            yield $dataSet;
        }
    }

    public function getDataForTestOptions(): iterable
    {
        $dataSet = [[], []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $defaultValue = "default_$shortName";
            $optionConfig = [
                'longName' => $longName,
                'shortName' => $shortName,
                'defaultValue' => $defaultValue,
            ];

            $dataSet[0][$longName] = $optionConfig;
            $dataSet[0][$shortName] = $optionConfig;
            $dataSet[1][] = [$longName, $shortName, $defaultValue];
            yield $dataSet;
        }
    }

    public function getDataForTestPrepareLongOptions(): iterable
    {
        $dataSet = [[], []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $dataSet[0][] = "$longName:";
            $dataSet[1][] = [$longName, $shortName, 'any string'];
            yield $dataSet;
        }
    }

    public function getDataForTestPrepareShortOptions(): iterable
    {
        $dataSet = ['', []];
        $keys = ['a', 'b', 'c'];
        foreach ($keys as $shortName) {
            $longName = "long_$shortName";
            $dataSet[0] .= "$shortName:";
            $dataSet[1][] = [$longName, $shortName, 'any string'];
            yield $dataSet;
        }
    }

    public function getDataForTestThrowExceptionOnDuplicateName(): iterable
    {
        yield [[
            ['long_a', 'a', 'any string'],
            ['long_a', 'b', 'any string'],
        ]];
        yield [[
            ['long_a', 'a', 'any string'],
            ['long_b', 'a', 'any string'],
        ]];
    }

    /**
     * @param array<int,array<int,string>> $options
     */
    private function buildOptionsConfig(array $options): OptionsConfig
    {
        $config = new OptionsConfig();
        foreach ($options as $datum) {
            $config->add(...$datum);
        }

        return $config;
    }
}
