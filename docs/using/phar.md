### Using of PHAR file

1. Download PHAR directly to root directory
   ```shell
   wget -O pccb.phar "https://github.com/Aeliot-Tm/phpunit-codecoverage-baseline/releases/latest/download/pccb.phar"
   ```
2. Call script with necessary commands:
   - [pccb:clover:build-baseline](../clover_build_baseline.md)
   - [pccb:clover:compare](../clover_compare_with_baseline.md)
   ```shell
   php pccb.phar <command> <options>
   ```

Additional instructions how to verify package read [here](../installation/phar_directly.md).
