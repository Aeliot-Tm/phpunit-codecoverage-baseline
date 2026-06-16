<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\Writer;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Version;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class BaselineWriter
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
     * @param Coverage<string,float> $baseline
     */
    public function write(Coverage $baseline): void
    {
        $data = [
            'version' => Version::CURRENT,
            'metrics' => iterator_to_array($baseline),
        ];
        $content = json_encode($data, \JSON_PRETTY_PRINT);
        if (json_last_error()) {
            throw new \LogicException(json_last_error_msg());
        }
        file_put_contents($this->path, $content);
    }
}
