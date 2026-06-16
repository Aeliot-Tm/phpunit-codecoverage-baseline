<?php

/*
 * This file is part of the PHPUnit code coverage baseline project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

if (Phar::running()) {
    define('PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH', __DIR__ . '/../vendor/autoload.php');
} elseif (isset($GLOBALS['_composer_autoload_path'])) {
    define('PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH', $GLOBALS['_composer_autoload_path']);
    unset($GLOBALS['_composer_autoload_path']);
} else {
    $paths = [
        __DIR__ . '/../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/vendor/autoload.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            define('PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH', $file);
            break;
        }
    }
    unset($paths, $file);
}

if (!defined('PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH')) {
    fwrite(
        \STDERR,
        'You need to set up the project dependencies using Composer:' . \PHP_EOL . \PHP_EOL .
        '    composer install' . \PHP_EOL . \PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . \PHP_EOL
    );
    exit(1);
}

require_once PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH;
