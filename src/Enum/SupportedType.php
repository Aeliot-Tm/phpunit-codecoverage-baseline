<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Enum;

final class SupportedType
{
    public const CONDITIONALS = 'conditionals';
    public const ELEMENTS = 'elements';
    public const METHODS = 'methods';
    public const STATEMENTS = 'statements';

    /**
     * @return string[]
     */
    public static function getSupportedKeys(): array
    {
        $supportedTypes = self::getSupportedTypes();
        $coveredTypes = self::mapCoveredTypes($supportedTypes);

        return array_merge($supportedTypes, $coveredTypes);
    }

    /**
     * @return string[]
     */
    public static function getSupportedTypes(): array
    {
        return [
            self::METHODS,
            self::CONDITIONALS,
            self::STATEMENTS,
            self::ELEMENTS,
        ];
    }

    /**
     * @param string[] $supportedTypes
     *
     * @return string[]
     */
    private static function mapCoveredTypes(array $supportedTypes): array
    {
        return array_map(static function (string $x): string {
            return 'covered' . $x;
        }, $supportedTypes);
    }
}
