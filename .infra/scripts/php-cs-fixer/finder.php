<?php

declare(strict_types=1);

/*
 * This file is part of the TODO Registrar project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return $finder = (new PhpCsFixer\Finder())
    ->files()
    ->ignoreVCS(true)
    ->in(dirname(__DIR__, 3))
    ->exclude(['tests/fixtures', 'var', 'vendor'])
    ->append([
        dirname(__DIR__, 3) . '/bin/include_autoloader.php',
        dirname(__DIR__, 3) . '/bin/pccb',
        dirname(__DIR__, 3) . '/bin/pccb_clover_build_baseline',
        dirname(__DIR__, 3) . '/bin/pccb_clover_compare',
    ]);
