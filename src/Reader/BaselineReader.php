<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

final class BaselineReader implements BaselineReaderInterface
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
        $baseline = $this->getBaseline();

        if (!$baseline) {
            throw new \DomainException('Empty baseline');
        }

        return $baseline;
    }

    /**
     * @return array<string,mixed>
     */
    private function getBaseline(): array
    {
        if (!file_exists($this->path) || !is_file($this->path) || !is_readable($this->path)) {
            throw new \RuntimeException(\sprintf('Code coverage baseline "%s" does not exist.', $this->path));
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
}
