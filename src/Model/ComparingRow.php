<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

final class ComparingRow
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $old;

    /**
     * @var float
     */
    private $new;

    /**
     * @var float
     */
    private $progress;

    public function __construct(string $name, float $old, float $new)
    {
        $this->name = $name;
        $this->old = round($old, 2);
        $this->new = round($new, 2);
        $this->progress = $this->new - $this->old;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasProgress(): bool
    {
        return 0 < $this->progress;
    }

    public function hasRegress(): bool
    {
        return 0 > $this->progress;
    }

    /**
     * @return array<string,string>
     */
    public function getValues(): array
    {
        $progressPrefix = (0 < $this->progress) ? '+' : '';

        return [
            'name' => $this->name,
            'old' => $this->formatPercentage($this->old, 6),
            'new' => $this->formatPercentage($this->new, 6),
            'progress' => $this->formatPercentage($this->progress, 7, $progressPrefix),
        ];
    }

    private function formatPercentage(float $value, int $length, string $prefix = ''): string
    {
        return str_pad($prefix . number_format($value, 2, '.', ''), $length, ' ', \STR_PAD_LEFT) . ' %';
    }
}
