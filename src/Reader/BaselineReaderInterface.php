<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

interface BaselineReaderInterface
{
    /**
     * @return mixed
     */
    public function read();
}
