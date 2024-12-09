<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

/**
 * @implements \ArrayAccess<string,float>
 * @implements \IteratorAggregate<string,float>
 */
final class Coverage implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array<string,float>
     */
    private $metrics = [];

    /**
     * @param array<string,numeric> $metrics
     */
    public function __construct(array $metrics)
    {
        foreach ($metrics as $metric => $value) {
            $this->offsetSet($metric, $value);
        }
    }

    /**
     * @return \ArrayIterator<string,float>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->metrics);
    }

    /**
     * @param string $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->metrics[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetGet($offset): float
    {
        if (!isset($this->metrics[$offset])) {
            throw new \OutOfBoundsException(sprintf('Invalid offset %s', $offset));
        }

        return $this->metrics[$offset];
    }

    /**
     * @param string $offset
     * @param numeric $value
     *
     * @phpstan-param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (is_numeric($value)) {
            $value = (float) $value;
        }
        if (!is_float($value)) {
            throw new \InvalidArgumentException(sprintf('Value of "%s" is not numeric', $offset));
        }

        $this->metrics[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->metrics[$offset]);
    }
}
