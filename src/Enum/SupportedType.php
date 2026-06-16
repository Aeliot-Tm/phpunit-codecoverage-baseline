<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
