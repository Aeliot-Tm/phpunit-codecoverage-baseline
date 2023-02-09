PHPUnit code coverage baseline
==============================

Package implements support of baseline for Clover repost of PHPUnit.

Installation
------------

Call command line script to install: 
```shell
composer require --dev aeliot-tm/phpunit-codecoverage-baseline
```

Usage
-----

**To get started:**
1. Run PHPUnit with the switched on Clover report in [xml config file](https://phpunit.readthedocs.io/en/9.5/configuration.html#the-report-element)
   or with [command-line options](https://phpunit.readthedocs.io/en/9.5/textui.html?highlight=clover#command-line-options).
   ```shell
   phpunit --coverage-clover 'build/coverage/clover.xml' tests/
   ```
2. [Build baseline](docs/clover_build_baseline.md) for clover report and commit into your project.

**Regular using:**
1. [Run comparing](docs/clover_compare_with_baseline.md) of current Clover report with the baseline. 
   It is recommended to configure it on your GitHub or GitLab CI.
2. Update your baseline time-to-time when you have progress with your code coverage.
