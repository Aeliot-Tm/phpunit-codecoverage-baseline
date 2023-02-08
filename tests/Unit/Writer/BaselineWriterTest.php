<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\Writer;

use Aeliot\PHPUnitCodeCoverageBaseline\Enum\Version;
use Aeliot\PHPUnitCodeCoverageBaseline\Model\Coverage;
use Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit\UnitTestCase;
use Aeliot\PHPUnitCodeCoverageBaseline\Writer\BaselineWriter;

final class BaselineWriterTest extends UnitTestCase
{
    public function testPositiveFlow(): void
    {
        $suffix = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $path = $this->getTmpDir() . '/base_line_' . $suffix . '.json';
        (new BaselineWriter($path))->write(new Coverage(['a' => 1]));
        self::assertFileExists($path);

        $data = json_decode(file_get_contents($path), true);
        $expected = ['version' => Version::CURRENT, 'metrics' => ['a' => 1]];
        self::assertSame($expected, $data);
    }
}
