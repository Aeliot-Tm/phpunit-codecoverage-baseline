<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\SupportedType;

final class BaselineReader
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return array<string,int>
     */
    public function read(): array
    {
        /** @var array<string,int> $baseline */
        $baseline = $this->sanitize($this->getBaseline());

        if (!$baseline) {
            throw new \DomainException('Empty baseline');
        }

        if (array_filter($baseline, static fn ($x) => !\is_int($x))) {
            throw new \DomainException('Invalid baseline data');
        }

        return $baseline;
    }

    /**
     * @return array<string,mixed>
     */
    private function getBaseline(): array
    {
        if (!file_exists($this->path)) {
            throw new \RuntimeException(sprintf('Code coverage baseline "%s" does not exist.', $this->path));
        }

        $baseline = json_decode(file_get_contents($this->path), true, 512, JSON_THROW_ON_ERROR);
        if (!\is_array($baseline)) {
            throw new \DomainException('Cannot read baseline');
        }

        return $baseline;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    private function sanitize(array $data): array
    {
        $baseline = [];
        foreach (SupportedType::getSupportedKeys() as $key) {
            if (isset($data[$key])) {
                $baseline[$key] = $data[$key];
            }
        }

        return $baseline;
    }
}
