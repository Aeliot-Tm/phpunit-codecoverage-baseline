<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Model;

/**
 * @template TKey of string
 * @template TValue af float
 *
 * @phpstan-implements \IteratorAggregate<TKey,TValue>
 * @phpstan-implements \ArrayIterator<TKey,TValue>
 */
final class Coverage implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array<TKey,TValue>
     */
    private $options = [];

    /**
     * @param array<TKey,TValue|string> $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $option => $value) {
            $this->offsetSet($option, $value);
        }
    }

    /**
     * @return \ArrayIterator<TKey,TValue>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->options);
    }

    /**
     * @param TKey $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->options[$offset]);
    }

    /**
     * @param TKey $offset
     */
    public function offsetGet($offset): float
    {
        if (!isset($this->options[$offset])) {
            throw new \OutOfBoundsException(sprintf('Invalid offset %s', $offset));
        }

        return $this->options[$offset];
    }

    /**
     * @param TKey $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        if (is_numeric($value)) {
            $value = (float) $value;
        }
        if (!is_float($value)) {
            throw new \InvalidArgumentException(sprintf('Value of "%s" is not numeric', $offset));
        }

        $this->options[$offset] = $value;
    }

    /**
     * @param TKey $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->options[$offset]);
    }
}
