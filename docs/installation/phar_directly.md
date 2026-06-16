# Downloading of PHAR directly

Download PHAR directly to root directory of the project or in another place as you wish.
```shell
# Do adjust the URL if you need a release other than the latest
wget -O pccb.phar "https://github.com/Aeliot-Tm/phpunit-codecoverage-baseline/releases/latest/download/pccb.phar"

# make executable
chmod +x pccb.phar
```

Additionally, you may validate downloaded PHAR file with GPG signature:
```shell
# Do adjust the URL if you need a release other than the latest
wget -O pccb.phar.asc "https://github.com/Aeliot-Tm/phpunit-codecoverage-baseline/releases/latest/download/pccb.phar.asc"

# Check that the signature matches
gpg --verify pccb.phar.asc pccb.phar

# Check the issuer (the ID can also be found from the previous command)
gpg --keyserver hkps://keys.openpgp.org --recv-keys A9B00724C9F9727D799CDEB4721E74FEB9C5DFE7

rm pccb.phar.asc
```
