ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-apache
WORKDIR /var/www/html

# Install additional packages needed by the app.
ADD symfony-cli.list /etc/apt/sources.list.d/symfony-cli.list
RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
    curl \
    wget \
    openssl \
    git \
    libpq-dev \
    libzip-dev \
    unzip \
    vim \
    symfony-cli
ADD php.ini /usr/local/etc/php/conf.d/php.ini

# Install required extensions.
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    zip

RUN apt-get install -y zlib1g-dev libicu-dev g++ \
	&& docker-php-ext-configure intl \
	&& docker-php-ext-install intl

RUN docker-php-ext-enable sodium

# Install opcache extension for PHP accelerator
RUN docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get autoremove -y

# Install Composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get autoremove -y && apt-get clean && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Xdebug.
RUN pecl install xdebug && docker-php-ext-enable xdebug
ADD xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
ADD error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && usermod -s /bin/bash www-data

# Disable default VH on apache
RUN a2dissite 000-default.conf
RUN a2enmod rewrite
RUN a2enmod ssl

# Copy and enable the VH
COPY vhost.conf /etc/apache2/sites-available/
RUN a2ensite vhost.conf
RUN service apache2 restart

RUN chown -R www-data:www-data /var/www

EXPOSE 7080 9000