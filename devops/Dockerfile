
FROM php:latest as base

RUN apt-get update && apt-get install -y build-essential ca-certificates curl \
    procps net-tools libcurl4-openssl-dev \
    libgmp-dev libzip-dev libfreetype-dev

RUN echo "Setting up extensions" && \
    pecl install redis && docker-php-ext-enable redis && \
    docker-php-ext-install bcmath curl gd pdo_mysql gmp zip pcntl

# RUN echo "Cleaning up" && \
#     apt-get clean && \
#     rm -rf /var/lib/apt/lists/* && \
#     rm -rf /tmp/pear

RUN echo "Setting up composer" && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


FROM base as final
WORKDIR /var/www

COPY  composer.lock .
COPY  composer.json .
COPY  . .



WORKDIR /var/www
RUN /usr/local/bin/composer install --no-scripts
RUN chmod +x  /var/www/devops/entrypoint.sh
ENTRYPOINT ["/var/www/devops/entrypoint.sh"]