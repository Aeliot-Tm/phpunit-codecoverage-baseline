<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Console;

final class OptionsConfig
{
    /**
     * @var array<string,string>
     */
    private array $aliases = [];

    /**
     * @var array<string,array{ longName: string, shortName: string, defaultValue: string }>
     */
    private array $options = [];

    public function add(
        string $longName,
        string $shortName,
        string $defaultValue
    ): void {
        $this->validateNames($longName, $shortName);

        $optionConfig = [
            'longName' => $longName,
            'shortName' => $shortName,
            'defaultValue' => $defaultValue,
        ];
        $this->options[$longName] = &$optionConfig;
        $this->options[$shortName] = &$optionConfig;

        $this->aliases[$shortName] = $longName;
    }

    /**
     * @return array<string,string>
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @return array<string,array{ longName: string, shortName: string, defaultValue: string }>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string[]
     */
    public function prepareLongOptions(): array
    {
        return $this->mapToRequired(array_values($this->aliases));
    }

    public function prepareShortOptions(): string
    {
        return implode('', $this->mapToRequired(array_keys($this->aliases)));
    }

    /**
     * @param string[] $keys
     *
     * @return string[]
     */
    private function mapToRequired(array $keys): array
    {
        return array_map(static fn (string $x): string => "$x:", $keys);
    }

    private function validateNames(string $longName, string $shortName): void
    {
        if (array_key_exists($longName, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Duplicate option "%s" detected', $longName));
        }

        if (array_key_exists($shortName, $this->options)) {
            throw new \InvalidArgumentException(
                sprintf('Duplicate short name "%s" on the option "%s" detected', $shortName, $longName)
            );
        }

        if (strlen($shortName) > 1) {
            throw new \InvalidArgumentException(sprintf('Too long short name "%s" of option "%s"', $shortName, $longName));
        }
    }
}
