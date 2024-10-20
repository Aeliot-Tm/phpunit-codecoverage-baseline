ARG PHP_VERSION=php:7.1
FROM ${PHP_VERSION}
RUN apt-get --allow-releaseinfo-change update && apt-get install -y \
        libxml2-dev \
        libzip-dev \
        unzip  \
        git \
    && docker-php-ext-install -j$(nproc) xml \
    && docker-php-ext-install -j$(nproc) zip

# Xdebug
ARG XDEBUG_VERSION=2.9.8
ARG PHP_XDEBUG_PORT=9003
RUN pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=coverage,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=\"host.docker.internal\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=\${PHP_XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Memory limit
RUN echo "memory_limit = 1G" >> /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename composer --install-dir=/bin \
    && php -r "unlink('composer-setup.php');"

# Install PHIVE
RUN set -xe; \
    curl -sSL -o phive.phar https://phar.io/releases/phive.phar && \
    curl -sSL -o phive.phar.asc https://phar.io/releases/phive.phar.asc && \
    gpg --keyserver hkps://keys.openpgp.org --recv-keys 0x9D8A98B29B2D5D79 && \
    gpg --verify phive.phar.asc phive.phar && \
    chmod +x phive.phar && \
    mv phive.phar /usr/local/bin/phive

WORKDIR /app

COPY composer.json composer.json
RUN composer install --prefer-dist --no-suggest --no-interaction --no-scripts --classmap-authoritative --no-autoloader
COPY ./ ./
RUN composer dump-autoload
