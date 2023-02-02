PHPUnit code coverage comparing report
======================================

Add option `--verbose=v` or `-vv` to console command then you will get report:
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
