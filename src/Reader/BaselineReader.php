<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\SupportedType;

final class BaselineReader
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return array<string,int>
     */
    public function read(): array
    {
        $baseline = $this->sanitize($this->getBaseline());

        if (!$baseline) {
            throw new \DomainException('Empty baseline');
        }

        $notIntValues = array_filter($baseline, static function ($x): bool {
            return !\is_int($x);
        });
        if ($notIntValues) {
            throw new \DomainException('Invalid baseline data');
        }

        return $baseline;
    }

    /**
     * @return array<string,mixed>
     */
    private function getBaseline(): array
    {
        if (!file_exists($this->path) || !is_file($this->path) || !is_readable($this->path)) {
            throw new \RuntimeException(sprintf('Code coverage baseline "%s" does not exist.', $this->path));
        }

        $baseline = json_decode((string) file_get_contents($this->path), true);
        if (json_last_error()) {
            throw new \LogicException(json_last_error_msg());
        }
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
