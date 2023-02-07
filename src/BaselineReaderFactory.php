<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline;

use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\AwareTransformer;
use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V1P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer\V2P0Transformer;
use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Version;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineReader;
use Aeliot\PHPUnitCodeCoverageBaseline\Reader\BaselineTransformingReader;

/**
 * @codeCoverageIgnore
 */
final class BaselineReaderFactory
{
    public function createReader(string $path): BaselineTransformingReader
    {
        $baselineReader = new BaselineReader($path);
        $awareTransformer = $this->createTransformer();

        return new BaselineTransformingReader($baselineReader, $awareTransformer);
    }

    private function createTransformer(): AwareTransformer
    {
        $transformers = [
            Version::VERSION_1 => new V1P0Transformer(),
            Version::VERSION_2 => new V2P0Transformer(),
        ];

        return new AwareTransformer($transformers);
    }
}
