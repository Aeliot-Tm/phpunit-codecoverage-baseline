Compare Clover report with baseline
===================================

1. Add [baseline](clover_build_baseline.md) file to the project.
2. Run your tests with switched on clover report. See [base readme](./../README.md#usage).
3. Call console command:
   ```shell
   vendor/bin/pccb pccb:clover:compare -vv
   ```
   It accepts options:

| Full name    | Short name | Description                                                                                                       | Default value                  |
|--------------|------------|-------------------------------------------------------------------------------------------------------------------|--------------------------------|
| `--baseline` | `-b`       | Path to the baseline                                                                                              | `phpunit.clover.baseline.json` |
| `--clover`   | `-c`       | Path to the Clover report                                                                                         | `build/coverage/clover.xml`    |
| `--verbose`  | `-v`       | Generates verbose report. See Symfony [verbosity levels](https://symfony.com/doc/current/console/verbosity.html). |                                |


### Report in verbose mode

Add verbosity option to console command according to [Symfony documentation](https://symfony.com/doc/current/console/verbosity.html) since "verbose" level. 
Then you will get report:
```
Clover baseline comparing results:
|--------------|--------------|--------------|-----------|
| Metrics      | Old coverage | New coverage | Progress  |
|--------------|--------------|--------------|-----------|
| methods      |   5.00 %     |  50.00 %     |  +45.00 % |
| conditionals |  50.01 %     |  45.12 %     |   -4.89 % |
| statements   |  40.00 %     |  50.00 %     |  +10.00 % |
| elements     |  50.19 %     |  50.19 %     |    0.00 % |
|--------------|--------------|--------------|-----------|
```

If you have some progress and don't have any regress then you get suggestion after the table to update your baseline.
```
Good job! You improved code coverage. Update baseline.
```
