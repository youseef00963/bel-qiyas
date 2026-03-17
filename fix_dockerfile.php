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
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 8080

CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
EOT);

echo "✓ Dockerfile\n";
echo "\n✅ تم! هلق:\n";
echo "git add .\n";
echo "git commit -m \"fix Dockerfile\"\n";
echo "git push\n";