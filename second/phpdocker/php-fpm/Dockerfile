FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Install php
RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php7.4-mysql \ 
        php7.4-xdebug; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

COPY ./ /application

RUN composer install --prefer-source --no-interaction