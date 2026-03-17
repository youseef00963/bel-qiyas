<?php

file_put_contents('Dockerfile', <<<'EOT'
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

ENTRYPOINT ["/bin/sh", "-c", "php artisan migrate --force && php -S 0.0.0.0:${PORT:-8080} -t public"]
EOT);

echo "✓ Dockerfile updated\n";
echo "\nهلق شغّل:\n";
echo "git add Dockerfile\n";
echo "git commit -m \"fix PORT binding\"\n";
echo "git push\n";