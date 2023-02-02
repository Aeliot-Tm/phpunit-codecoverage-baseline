<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Console;

final class OptionsReader
{
    /**
     * @var OptionsConfig
     */
    private $config;

    /**
     * @var GetOpt
     */
    private $getOpt;

    public function __construct(OptionsConfig $config, GetOpt $getOpt)
    {
        $this->config = $config;
        $this->getOpt = $getOpt;
    }

    /**
     * @return array<string,mixed>
     */
    public function read(): array
    {
        /** @var array<string,mixed> $data */
        $data = $this->getOpt->getOpt($this->config->prepareShortOptions(), $this->config->prepareLongOptions());
        $this->checkOnDuplicates($data);
        $data = $this->setDefaults($data);

        return $this->transformToLongKeys($data);
    }

    /**
     * @param array<string,mixed> $data
     */
    private function checkOnDuplicates(array $data): void
    {
        $duplicates = array_merge(
            $this->filterArrayValues($data),
            $this->filterDefinedByBothNames($data)
        );

        if ($duplicates) {
            $duplicates = array_unique($duplicates);
            sort($duplicates);
            throw new \RuntimeException(
                sprintf('There is duplicate options passed: %s', implode(', ', $duplicates))
            );
        }
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return string[]
     */
    private function filterArrayValues(array $data): array
    {
        $duplicates = [];
        $aliases = $this->config->getAliases();
        $arrays = array_filter($data, static function ($x): bool {
            return \is_array($x);
        });
        foreach (array_keys($arrays) as $optionName) {
            $duplicates[] = $aliases[$optionName] ?? $optionName;
        }

        return $duplicates;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return string[]
     */
    private function filterDefinedByBothNames(array $data): array
    {
        $duplicates = [];
        foreach ($this->config->getAliases() as $shortName => $longName) {
            if (isset($data[$shortName], $data[$longName])) {
                $duplicates[] = $longName;
            }
        }

        return $duplicates;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    private function setDefaults(array $data): array
    {
        $options = $this->config->getOptions();
        foreach ($this->config->getAliases() as $longName) {
            if (isset($data[$longName])) {
                continue;
            }

            $data[$longName] = $options[$longName]['defaultValue'];
        }

        return $data;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    private function transformToLongKeys(array $data): array
    {
        foreach ($this->config->getAliases() as $shortName => $longName) {
            if (isset($data[$shortName])) {
                $data[$longName] = $data[$shortName];
                unset($data[$shortName]);
            }
        }

        return $data;
    }
}
