<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

final class CloverCoverage
{
    /**
     * @var array<string,int>
     */
    private $data;

    /**
     * @param array<string,int> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array<string,float>
     */
    public function getPercentage(): array
    {
        $percentage = [];
        foreach ($this->detectCoverageParameters($this->data) as $type) {
            $amount = $this->data[$type];
            $coverage = $this->data['covered' . $type] ?? 0;
            $percent = $amount ? $coverage / $amount : 0.0;
            $percentage[$type] = round($percent * 100, 2);
        }

        return $percentage;
    }

    private function detectCoverageParameters(array $data): array
    {
        $keys = array_keys($data);
        $coveredKeys = array_filter($keys, static function (string $x): bool {
            return stripos($x, 'covered') === 0;
        });

        $coveredTypes = array_map(static function (string $x): string {
            return substr($x, 7);
        }, $coveredKeys);
        $missedTypes = array_diff($coveredTypes, $keys);
        if ($missedTypes) {
            throw new \InvalidArgumentException(sprintf('Missed types detected: %s', implode(', ', $coveredTypes)));
        }

        return array_diff($keys, $coveredKeys);
    }
}
