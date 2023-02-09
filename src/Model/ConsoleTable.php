<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

final class ConsoleTable
{
    /**
     * @var string[]
     */
    private $columns;

    /**
     * @var int
     */
    private $columnsCount;

    /**
     * @var array<int,int|string>
     */
    private $columnsKeys;

    /**
     * @var array<int,int>
     */
    private $columnsWidth;

    /**
     * @var array<int,array<string>>
     */
    private $values = [];

    /**
     * @param string[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
        $this->columnsCount = count($columns);
        $this->columnsKeys = array_keys($this->columns);
        $this->columnsWidth = array_map('strlen', array_values($columns));
    }

    public function addComparingRow(ComparingRow $row): void
    {
        $data = $row->getValues();
        $values = [];
        foreach ($this->columnsKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new \InvalidArgumentException(sprintf('Row does not contain column "%s"', $key));
            }

            $values[] = $data[$key];
            unset($data[$key]);
        }

        if ($data) {
            $message = sprintf('Row contain extra column(s): %s', implode(', ', array_keys($data)));
            throw new \InvalidArgumentException($message);
        }

        $this->addLine(...$values);
    }

    public function addLine(string ...$values): void
    {
        if (count($values) !== $this->columnsCount) {
            throw new \InvalidArgumentException('Invalid values count');
        }

        $this->values[] = $values;
        $this->updateWidth($values);
    }

    public function getContent(): string
    {
        $content = [];
        $content[] = $this->buildSeparateLine();
        $content[] = $this->buildTableLine(array_values($this->columns));
        $content[] = $this->buildSeparateLine();
        foreach ($this->values as $values) {
            $content[] = $this->buildTableLine($values);
        }
        if ($this->values) {
            $content[] = $this->buildSeparateLine();
        }

        return implode(PHP_EOL, $content) . PHP_EOL;
    }

    private function buildSeparateLine(): string
    {
        return $this->buildTableLine(array_fill(0, count($this->columns), ''), '-');
    }

    /**
     * @param array<int,string> $values
     */
    private function buildTableLine(array $values, string $filler = ' '): string
    {
        foreach ($values as $index => $value) {
            $values[$index] = str_pad($value, $this->columnsWidth[$index], $filler);
        }

        return '|' . $filler . implode($filler . '|' . $filler, $values) . $filler . '|';
    }

    /**
     * @param string[] $values
     */
    private function updateWidth(array $values): void
    {
        $widths = array_map('strlen', $values);
        foreach ($this->columnsWidth as $index => $width) {
            $this->columnsWidth[$index] = max($width, $widths[$index]);
        }
    }
}
