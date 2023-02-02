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
        $this->old = round($old * 100, 2);
        $this->new = round($new * 100, 2);
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
            'old' => str_pad(number_format($this->old, 2), 6, ' ', \STR_PAD_LEFT) . ' %',
            'new' => str_pad(number_format($this->new, 2), 6, ' ', \STR_PAD_LEFT) . ' %',
            'progress' => str_pad($progressPrefix . number_format($this->progress, 2), 7, ' ', \STR_PAD_LEFT) . ' %',
        ];
    }
}
