FROM php:7.4-apache

# Dependencies
 RUN apt-get update && apt-get install -y \
    git \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libjpeg-dev \
    libxpm-dev \
    libssl-dev \
    libmcrypt-dev \
    libwebp-dev \
    zip \
    unzip

# Install extensions using the helper script provided by the base image
RUN docker-php-ext-install \
    pdo_mysql

RUN a2enmod headers \
    && sed -ri -e 's/^([ \t]*)(<\/VirtualHost>)/\1\tHeader set Access-Control-Allow-Origin "*"\n\1\2/g' /etc/apache2/sites-available/*.conf


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
VOLUME /var/www/html

COPY . .

CMD php -S 0.0.0.0:8000 -t /var/www/html/public

EXPOSE 8000
