<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Enum;

final class Command
{
    public const CLOVER_BUILD_BASELINE = 'pccb:clover:build-baseline';

    public const CLOVER_COMPARE = 'pccb:clover:compare';

    /**
     * @return string[]
     */
    public static function getAll(): array
    {
        return [
            self::CLOVER_COMPARE,
            self::CLOVER_BUILD_BASELINE,
        ];
    }
}
