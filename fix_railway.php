<?php

// nixpacks.toml
file_put_contents('nixpacks.toml', <<<'EOT'
[phases.setup]
nixPkgs = ["php82", "php82Extensions.pdo", "php82Extensions.pdo_mysql", "php82Extensions.mbstring", "php82Extensions.tokenizer", "php82Extensions.xml", "php82Extensions.ctype", "php82Extensions.fileinfo", "php82Extensions.bcmath", "php82Extensions.curl", "composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[phases.build]
cmds = ["php artisan config:cache", "php artisan route:cache", "php artisan view:cache"]

[start]
cmd = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
EOT);
echo "✓ nixpacks.toml\n";

// Procfile
file_put_contents('Procfile', 'web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT');
echo "✓ Procfile\n";

echo "\n✅ تم! هلق:\n";
echo "1. git add .\n";
echo "2. git commit -m \"add railway config\"\n";
echo "3. git push\n";