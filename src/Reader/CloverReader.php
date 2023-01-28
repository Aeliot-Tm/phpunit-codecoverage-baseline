<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Reader;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\SupportedType;

final class CloverReader
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return array<string,int>
     */
    public function read(): array
    {
        $attributes = $this->getAttributes();

        $data = [];
        foreach (SupportedType::getSupportedKeys() as $key) {
            if(isset($attributes[$key])) {
                $data[$key] = (int) (string) $attributes[$key];
            }
        }

        if (!$data) {
            throw new \RuntimeException('Empty clover data');
        }

        return $data;
    }

    private function getAttributes(): \SimpleXMLElement
    {
        $metricsSet = $this->getClover()->xpath('/coverage/project/metrics');
        if (!$metricsSet) {
            throw new \RuntimeException('Cannot find tag "metrics" of the project.');
        }

        return $metricsSet[0]->attributes();
    }

    private function getClover(): \SimpleXMLElement
    {
        if (!file_exists($this->path)) {
            throw new \RuntimeException(
                sprintf('Coverage clover file "%s" does not exist. Maybe it is not calculated yet.', $this->path)
            );
        }

        $clover = simplexml_load_string(file_get_contents($this->path));
        if (!$clover instanceof \SimpleXMLElement) {
            // @codeCoverageIgnoreStart
            // NOTE: ignored case PHPUnit transforms Warning generated by simplexml_load_string() function
            //       during the parsing invalid XML file to Exception.
            throw new \RuntimeException('Cannot load file "clover.xml".');
            // @codeCoverageIgnoreEnd
        }

        return $clover;
    }
}
