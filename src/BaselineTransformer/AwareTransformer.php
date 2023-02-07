<?php

declare(strict_types=1);

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

    public function transform(array $data): Coverage
    {
        $version = $data['version'] ?? Version::VERSION_1;

        return $this->getTransformer($version)->transform($data);
    }

    private function getTransformer(string $version): TransformerInterface
    {
        if (!array_key_exists($version, $this->transformers)) {
            throw new \DomainException(sprintf('Unsupported version %s of baseline detected', $version));
        }

        return $this->transformers[$version];
    }
}
