FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    zip unzip curl && \
    docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.example .env && \
    sed -i 's/SESSION_DRIVER=file/SESSION_DRIVER=cookie/' .env && \
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env && \
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate --force

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

EXPOSE 80