Build baseline for Clover report
================================

1. Run your tests with switched on clover report. See [base readme](./../README.md#usage).
2. Call console command:
   ```shell
   vendor/bin/pccb_clover_build_baseline
   ```
   It accepts options:

| Full name    | Short name | Description               | Default value                  |
|--------------|------------|---------------------------|--------------------------------|
| `--baseline` | `-b`       | Path to the baseline      | `phpunit.clover.baseline.json` |
| `--clover`   | `-c`       | Path to the Clover report | `build/coverage/clover.xml`    |

Resulting file contains the same options as Clover report. See [example](phpunit.clover.baseline.json).

Baseline v2 contains calculated metrics of code coverage. 

Baseline v1 contained metrics values identical as they represented in Clover report (exact amount of detected and covered classes, methods and so on).

**Notes:**
1. You can remove some metrics from resulting file. Then they will be counted as not covered.
2. All not standard metrics added manually will be ignored during comparing of Clover report with the baseline.
