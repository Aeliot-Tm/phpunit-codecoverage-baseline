PHPUnit code coverage baseline
==============================

It is a base implementation of baseline support for Clover reposts of PHPUnit.

Installation
------------

`composer require --dev aeliot-tm/phpunit-codecoverage-baseline`

Usage
-----

1. Add baseline file to the project. See [example](docs/phpunit.clover.baseline.json).
2. Run your tests with [configured](https://phpunit.readthedocs.io/en/9.5/configuration.html#the-report-element) 
   code coverage Clover report or with [command line option](https://phpunit.readthedocs.io/en/9.5/textui.html?highlight=clover#command-line-options).
   ```shell
   phpunit --coverage-clover 'build/coverage/clover.xml' tests/
   ```
3. Call [script](bin/phpunit_clover_compare).
   ```shell
   vendor/bin/phpunit_clover_compare
   ```
   It accepts options:

| Full name    | Short name | Description               | Default value                  |
|--------------|------------|---------------------------|--------------------------------|
| `--baseline` | `-b`       | Path to the baseline      | `phpunit.clover.baseline.json` |
| `--clover`   | `-c`       | Path to the Clover report | `build/coverage/clover.xml`    |
