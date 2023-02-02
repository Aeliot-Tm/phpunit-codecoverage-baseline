<?php

declare(strict_types=1);

namespace Aeliot\PHPUnitCodeCoverageBaseline\Test\Unit;

use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    /**
     * Add fallback for running with different versions of PHPUnit
     */
    public function expectExceptionMessageMatches(string $messageRegExp): void
    {
        if (method_exists(parent::class, 'expectExceptionMessageMatches')) {
            parent::expectExceptionMessageMatches($messageRegExp);
        } elseif (method_exists(parent::class, 'expectExceptionMessageRegExp')) {
            parent::expectExceptionMessageRegExp($messageRegExp);
        } else {
            throw new \DomainException(sprintf('It is impossible to call method %s', __METHOD__));
        }
    }

    /**
     * Add fallback for running with different versions of PHPUnit
     */
    public function expectWarningMessageMatches(string $messageRegExp): void
    {
        if (method_exists(parent::class, 'expectWarningMessageMatches')) {
            parent::expectWarningMessageMatches($messageRegExp);
        } else {
            $this->expectExceptionMessageMatches($messageRegExp);
        }
    }

    public function expectWarning(): void
    {
        if (method_exists(parent::class, 'expectWarning')) {
            parent::expectWarning();
        } else {
            $this->expectException(Warning::class);
        }
    }
}
