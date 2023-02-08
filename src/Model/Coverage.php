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
    private $options = [];

    /**
     * @param array<string,numeric> $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $option => $value) {
            $this->offsetSet($option, $value);
        }
    }

    /**
     * @return \ArrayIterator<string,float>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->options);
    }

    /**
     * @param string $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->options[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetGet($offset): float
    {
        if (!isset($this->options[$offset])) {
            throw new \OutOfBoundsException(sprintf('Invalid offset %s', $offset));
        }

        return $this->options[$offset];
    }

    /**
     * @param string $offset
     * @param numeric $value
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
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->options[$offset]);
    }
}
