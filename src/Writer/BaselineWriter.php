<?php

declare(strict_types=1);

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

    public function write(Coverage $baseline): void
    {
        $data = [
            'version' => Version::CURRENT,
            'options' => iterator_to_array($baseline),
        ];
        $content = json_encode($data, JSON_PRETTY_PRINT);
        if (json_last_error()) {
            throw new \LogicException(json_last_error_msg());
        }
        file_put_contents($this->path, $content);
    }
}
