<?php

declare(strict_types=1);

if (isset($GLOBALS['_composer_autoload_path'])) {
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
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );
    die(1);
}

require PHPUNIT_CCB_COMPOSER_AUTOLOAD_PATH;
