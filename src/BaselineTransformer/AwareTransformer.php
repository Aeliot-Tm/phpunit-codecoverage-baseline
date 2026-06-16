<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\PHPUnitCodeCoverageBaseline\BaselineTransformer;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Version;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;

final class AwareTransformer implements TransformerInterface
{
    /**
     * @var TransformerInterface[]
     */
    private $transformers;

    /**
     * @param array<string,TransformerInterface> $transformers
     */
    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param array<string,mixed> $data
     *
     * @return Coverage<string,float>
     */
    public function transform(array $data): Coverage
    {
        $version = $data['version'] ?? Version::VERSION_1;

        return $this->getTransformer($version)->transform($data);
    }

    private function getTransformer(string $version): TransformerInterface
    {
        if (!\array_key_exists($version, $this->transformers)) {
            throw new \DomainException(\sprintf('Unsupported version %s of baseline detected', $version));
        }

        return $this->transformers[$version];
    }
}
