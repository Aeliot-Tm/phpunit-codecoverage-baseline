CHANGELOG
=========

2.0.1
-----
* Bug fixes:
  * Fix comparing and displaying of data used for comparing of Clover code coverage report with its baseline.
* Minors:
  * Configure matrix for better dependencies testing.
  * Update scripts in composer config and running of them on GitGub Actions.
  * Added script to replace required versions of packages.

2.0.0
-----
* Feature:
  * Changed format of Clover code coverage baseline to improve its readability.
  * Added support for old version of Clover code coverage baseline.
* Backward compatibility breaks:
  * Used package `symfony/console` instead of custom console calls handling.
* Deprecations:
  * Scripts `bin/pccb_clover_build_baseline` and `bin/pccb_clover_compare` are deprecated.
    Single script `bin/pccb` should be used for all commands calls.
* Minors:
  * Configured Docker for dev purposes.

1.1.0
-----
* Features:
  * Beautified report of clover baseline comparing results when used option "verbose".
  * Added compatibility with PHP 7.1.
* Minors:
  * Added check by PHPStan.

1.0.0
-----
* Features:
  * Implemented baseline builder.
* Minors:
  * Code refactored in OOP approach.
  * Removed messages about fallback to the default options values.
  * Configured running of automated tests on GitHub. 

0.1
---
* Features:
  * Initial implementation of baseline comparing.
